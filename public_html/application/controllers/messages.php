<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->paginaionlimit =10;
		//enable for debugging
		//$this->output->enable_profiler(TRUE);
		$this->load->model('users_model');
		$this->load->model('message_model');
		$this->load->model('skill_model');
		$this->load->model('projects_model');
		$this->load->model('stories_model', 'stories');
		
		
		$this->view_data['page_is'] = 'Messages';
		$this->view_data['action_is'] = $this->uri->segment(2);
		$controller = $this->uri->segment(1);
		$action = $this->uri->segment(2);
		$param = $this->uri->segment(3);
		$this->view_data['action_is'] = $action;
		// - check if user is logged in
		$check_login = $this->users_model->is_authorised();
		if($check_login == true) {
			$user_id = $this->session->userdata('user_id');
			$me = $this->users_model->get_user($user_id);
			$me = $me->result_array();
			$me = $me[0];
			$myProfile = $this->users_model->get_profile($user_id);
			$myProfile = $myProfile->result_array();
			$myProfile = $myProfile[0];
			$this->view_data['me'] = $me;
			$this->view_data['myProfile'] = $myProfile;
			$this->view_data['myActiveMissions'] = $this->stories->get_num_my_works($user_id, 'in progress');
			$this->view_data['myActiveMessages'] = $this->message_model->num_unread($user_id);
			$this->view_data['myActiveNotifications'] = 0;
			$this->view_data['username'] = $this->session->userdata('username');
		} else if(strpos($action, "AjaxTab")===false){ // - if user not login, redirect to dashboard.
			$referer = $controller;
			if($action)$referer .= '/'.$action;
			if($param)$referer .= "/".$param;
			$this->session->set_userdata('referer', $referer); 
			redirect("login"); 
		}
	}
	
	
	function index(){
		redirect("/messages/inbox");
	}
	
	function inbox($offset=0){
		$user_id = $this->session->userdata('user_id');
		if(!isset($offset))$offset=0;
		$offset = intval($offset);
		$this->view_data['messages'] = $this->message_model->get_messages($user_id,'inbox',$offset*$this->paginaionlimit,$this->paginaionlimit);
		$this->view_data['limit'] = $this->paginaionlimit;
		$this->view_data['current'] = $offset;
		$this->view_data['total'] = $this->message_model->get_total_messages($user_id,'inbox');
		$this->view_data['window_title'] = "Inbox";
		$this->load->view('inbox_codearmy_view', $this->view_data);
	}
	
	function compose($to=''){
		$user_id = $this->session->userdata('user_id');
		if(strlen(trim($to))<2)$to="";
		$this->view_data['compose_to'] = $to;
		$this->view_data['window_title'] = "Compose message";
		$this->load->view('message_compose_codearmy_view', $this->view_data);
	}
	
	function send($offset=0){
		$user_id = $this->session->userdata('user_id');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('msg-to', 'To', 'required|max_length[40]|callback_check_user');
		$this->form_validation->set_rules('msg-subj', 'Subject', 'required|max_length[100]');
		$this->form_validation->set_rules('msg-text', 'Message', 'required');
		
		if ($this->form_validation->run() == FALSE){
			$this->view_data['form_error'] = true;
			$this->compose();
		} else {
			$this->load->helper('htmlpurifier');
			$to = $this->input->post('msg-to');
			$to = $this->users_model->get_user($to,'username')->result_array();
			$to = $to[0]['user_id'];
			$subject = $this->input->post('msg-subj');
			$msg = html_purify($this->input->post('msg-text'));
			$parent_id = $this->input->post('parent_id');
			$res = $this->message_model->send_message($user_id,$to,$subject,$msg,$parent_id);
			if (!$res){
				$this->compose();
			} else {
				$this->session->set_flashdata('message', "<div class=\"msg-sent\">Your message sent.</div>");
				redirect("/messages/inbox");
			}
		}
	}
	
	public function check_user($str){
		$sql = "SELECT user_id FROM users WHERE username = ?";
		$data = $this->db->query($sql, $str);
		if ($data->num_rows() > 0){
			return true;
		} else {
			$this->form_validation->set_message('check_user', 'User not found.');
			return false;
		}
	}
	
	function important($offset=0){
		$user_id = $this->session->userdata('user_id');
		if(!isset($offset))$offset=0;
		$offset = intval($offset);
		$this->view_data['messages'] = $this->message_model->get_messages($user_id,'important',$offset*$this->paginaionlimit,$this->paginaionlimit);
		$this->view_data['limit'] = $this->paginaionlimit;
		$this->view_data['current'] = $offset;
		$this->view_data['total'] = $this->message_model->get_total_messages($user_id,'important');
		$this->view_data['window_title'] = "Important messages";
		$this->load->view('message_important_codearmy_view', $this->view_data);
	}
	
	function archive(){
		$user_id = $this->session->userdata('user_id');
		if(!isset($offset))$offset=0;
		$offset = intval($offset);
		$this->view_data['messages'] = $this->message_model->get_messages($user_id,'archive',$offset*$this->paginaionlimit,$this->paginaionlimit);
		$this->view_data['limit'] = $this->paginaionlimit;
		$this->view_data['current'] = $offset;
		$this->view_data['total'] = $this->message_model->get_total_messages($user_id,'archive');
		$this->view_data['window_title'] = "Archive messages";
		$this->load->view('message_archive_codearmy_view', $this->view_data);
	}
	
	function sent(){
		$user_id = $this->session->userdata('user_id');
		if(!isset($offset))$offset=0;
		$offset = intval($offset);
		$this->view_data['messages'] = $this->message_model->get_messages($user_id,'sent',$offset*$this->paginaionlimit,$this->paginaionlimit);
		$this->view_data['limit'] = $this->paginaionlimit;
		$this->view_data['current'] = $offset;
		$this->view_data['total'] = $this->message_model->get_total_messages($user_id,'sent');
		$this->view_data['window_title'] = "Sent messages";
		$this->load->view('message_sent_codearmy_view', $this->view_data);
	}
	
	function trash(){
		$user_id = $this->session->userdata('user_id');
		if(!isset($offset))$offset=0;
		$offset = intval($offset);
		$this->view_data['messages'] = $this->message_model->get_messages($user_id,'trash',$offset*$this->paginaionlimit,$this->paginaionlimit);
		$this->view_data['limit'] = $this->paginaionlimit;
		$this->view_data['current'] = $offset;
		$this->view_data['total'] = $this->message_model->get_total_messages($user_id,'trash');
		$this->view_data['window_title'] = "Trash";
		$this->load->view('message_trash_codearmy_view', $this->view_data);
	}
	
	function search($offset=0, $search=''){
		$user_id = $this->session->userdata('user_id');
		if(!isset($offset))$offset=0;
		$offset = intval($offset);
		$search = $this->input->post('msg-search');
		$this->view_data['messages'] = $this->message_model->search_messages($search, $user_id,$offset*$this->paginaionlimit,$this->paginaionlimit);
		$this->view_data['limit'] = $this->paginaionlimit;
		$this->view_data['current'] = $offset;
		$this->view_data['total'] = $this->message_model->get_total_messages($user_id,'search');
		$this->view_data['window_title'] = "Search messages";
		$this->load->view('message_search_codearmy_view', $this->view_data);
	}
	
	function read($message_id){
		$user_id = $this->session->userdata('user_id');
		$this->view_data['message_selected'] = $message_id;
		$this->view_data['messages'] = $this->message_model->get_message($message_id,$user_id);
		$this->message_model->make_read(array($message_id),$user_id);
		$this->view_data['window_title'] = "Message Title";
		$this->load->view('message_codearmy_view', $this->view_data);
	}
	
	function notifications(){
		$user_id = $this->session->userdata('user_id');
		$this->view_data['window_title'] = "Message Title";
		$this->load->view('notifications_codearmy_view', $this->view_data);
	}
	
	function Ajax_flag_important(){
		//only on inbox, important and archive page
		$user_id = $this->session->userdata('user_id');
		$list = $this->input->post('message_id');
		$list = explode(',',$list);
		echo json_encode($this->message_model->make_important($list,$user_id));
	}
	
	function Ajax_flag_unimportant(){
		$user_id = $this->session->userdata('user_id');
		$list = $this->input->post('message_id');
		$list = explode(',',$list);
		echo json_encode($this->message_model->make_unimportant($list,$user_id));
	}
	
	function Ajax_flag_read(){
		$user_id = $this->session->userdata('user_id');
		$list = $this->input->post('message_id');
		$list = explode(',',$list);
		echo json_encode($this->message_model->make_read($list,$user_id));
	}
	
	function Ajax_flag_unread(){
		$user_id = $this->session->userdata('user_id');
		$list = $this->input->post('message_id');
		$list = explode(',',$list);
		echo json_encode($this->message_model->make_unread($list,$user_id));
	}
	
	function Ajax_trash(){
		$user_id = $this->session->userdata('user_id');
		$list = $this->input->post('message_id');
		$list = explode(',',$list);
		echo json_encode($this->message_model->to_trash($list,$user_id));
	}
	
	function Ajax_delete(){
		$user_id = $this->session->userdata('user_id');
		$list = $this->input->post('message_id');
		$list = explode(',',$list);
		echo json_encode($this->message_model->delete($list,$user_id));
	}
	
	function Ajax_recover(){
		$user_id = $this->session->userdata('user_id');
		$list = $this->input->post('message_id');
		$list = explode(',',$list);
		echo json_encode($this->message_model->recover($list,$user_id));
	}
	
	function chat(){
		$this->view_data['window_title'] = "Message Title";
		$this->load->view('chat_view', $this->view_data);
	}
	
	function chat_send(){
		$user_id = $this->session->userdata('user_id');
		$this->load->helper('htmlpurifier');
		if($id=$user_id){
			$msg = html_purify($this->input->post('message'));
			require_once(getcwd()."/application/helpers/pusher/Pusher.php");
			$pusher = new Pusher('deb0d323940b00c093ee', '9ab20336af22c4e7fa77', '25755');
			$data = array(
				'user_id' => $user_id,
				'username' => $this->view_data['me']['username'],
				'message' => $msg
			);
			$pusher->trigger('presence-chat-public', 'incomming-message', $data );
			echo $msg;
		}
	}
}