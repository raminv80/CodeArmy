<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help extends CI_Controller {
	var $view_data = array();
	var $check_login =false;
	
	function __construct() {
		parent::__construct();
		$this->load->model('users_model');
		//$this->load->model('users_model');
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
		$this->view_data['page_is'] = 'Help';
		
		// - check if user is logged in
		$check_login = $this->session->userdata('is_logged_in');
	}
	
	function index(){
		$this->view_data['window_title'] = 'Help';
		$this->load->view('help_view', $this->view_data);
	}
	
	function github(){
		$this->view_data['window_title'] = 'How to use Github?';
		$this->load->view('help_github_view', $this->view_data);
	}
}