<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Privacy extends CI_Controller {
	function __construct() {
		parent::__construct();
		//$this->load->model('users_model');
		$this->load->model('users_model');
		$user_id = $this->session->userdata('user_id');
		if($user_id){
			$myProfile = $this->users_model->get_profile($user_id);
			$myProfile = $myProfile->result_array();
			$myProfile = $myProfile[0];
			$me = $this->users_model->get_user($user_id);
			$me = $me->result_array();
			$me = $me[0];
			$this->view_data['myProfile'] = $myProfile;
			$this->view_data['me'] = $me;
		}
		$this->view_data['page_is'] = 'Privacy';
		
		// - check to verify if user is login...
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
		}
	}
	
	// index page
	function index() {
		$this->view_data['window_title'] = 'Terms & Conditions';
		$this->load->view('privacy_view', $this->view_data);
	}
}