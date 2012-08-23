<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pusher extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('stories_model', 'stories');
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
		}
	}
	
	function auth(){
		if($this->session->userdata('user_id')){
			$chanel = $this->input->post('channel_name');
			$soket_id = $this->input->post('socket_id');
			$callback = $this->input->post('callback');
			$userdata = array(
				'user_id' => $this->view_data['me']['user_id'],
				'user_info' => array(
					'username' => $this->view_data['me']['username'],
				)
			);
			$res = array(
				'auth'=>'deb0d323940b00c093ee:'.hash_hmac('sha256',$soket_id.':'.$chanel.':'.json_encode($userdata),'9ab20336af22c4e7fa77',false),
				"channel_data" => json_encode($userdata)
			);
			echo json_encode($res);
		}
	}
}