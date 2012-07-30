<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
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
	
	function inbox(){
		$user_id = $this->session->userdata('user_id');
		$this->view_data['messages'] = $this->message_model->get_messages($user_id,'inbox');
		$this->view_data['window_title'] = "Inbox";
		$this->load->view('inbox_codearmy_view', $this->view_data);
	}
	
	function compose(){
		$user_id = $this->session->userdata('user_id');
		$this->view_data['messages'] = $this->message_model->get_messages($user_id,'inbox');
		$this->view_data['window_title'] = "Inbox";
		$this->load->view('message_compose_codearmy_view', $this->view_data);
	}
	
	function send(){
		$user_id = $this->session->userdata('user_id');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('to', 'To', 'required');
		$this->form_validation->set_rules('message', 'Message', 'required');
		
		if ($this->form_validation->run() == FALSE){
			$this->view_data['form_error'] = true;
			$this->compose();
		} else {
			$this->message_model->send_message($user_id);
			redirect("/messages/inbox");
		}
	}
	
	function important(){
		$user_id = $this->session->userdata('user_id');
		$this->view_data['messages'] = $this->message_model->get_messages($user_id,'important');
		$this->view_data['window_title'] = "Inbox";
		$this->load->view('message_important_codearmy_view', $this->view_data);
	}
	
	function archive(){
		$user_id = $this->session->userdata('user_id');
		$this->view_data['messages'] = $this->message_model->get_messages($user_id,'archive');
		$this->view_data['window_title'] = "Inbox";
		$this->load->view('message_archive_codearmy_view', $this->view_data);
	}
	
	function sent(){
		$user_id = $this->session->userdata('user_id');
		$this->view_data['messages'] = $this->message_model->get_messages($user_id,'sent');
		$this->view_data['window_title'] = "Inbox";
		$this->load->view('message_sent_codearmy_view', $this->view_data);
	}
	
	function trash(){
		$user_id = $this->session->userdata('user_id');
		$this->view_data['messages'] = $this->message_model->get_messages($user_id,'trash');
		$this->view_data['window_title'] = "Inbox";
		$this->load->view('message_trash_codearmy_view', $this->view_data);
	}
	
	function search(){
		$user_id = $this->session->userdata('user_id');
		$this->view_data['window_title'] = "Inbox";
		$this->load->view('message_search_codearmy_view', $this->view_data);
	}
	
	function read(){
		$user_id = $this->session->userdata('user_id');
		$this->view_data['window_title'] = "Message Title";
		$this->load->view('message_codearmy_view', $this->view_data);
	}
	
	function notifications(){
		$user_id = $this->session->userdata('user_id');
		$this->view_data['window_title'] = "Message Title";
		$this->load->view('notifications_codearmy_view', $this->view_data);
	}
	
}