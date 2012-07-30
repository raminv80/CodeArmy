<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller {
	var $view_data = array();
	var $check_login =false;
	
	function __construct() {
		parent::__construct();
		//$this->load->model('users_model');
		$this->load->model('projects_model');
		$this->load->model('users_model');
		$this->load->model('stories_model', 'stories');
		$this->view_data['page_is'] = 'About';
		$this->view_data['action_is'] = 'index';
		$user_id = $this->session->userdata('user_id');
			if($user_id){
				$me = $this->users_model->get_user($user_id);
				$me = $me->result_array();
				$me = $me[0];
				$myProfile = $this->users_model->get_profile($user_id);
				$myProfile = $myProfile->result_array();
				$myProfile = $myProfile[0];
				$this->view_data['me'] = $me;
				$this->view_data['myProfile'] = $myProfile;
				$this->view_data['username'] = $this->session->userdata('username');
				$this->view_data['myActiveMissions'] = $this->stories->get_num_my_works($user_id, 'in progress');
				$this->view_data['myActiveMessages'] = $this->message_model->num_unread($user_id);
			}
		// - check if user is logged in
		$check_login = $this->session->userdata('is_logged_in');
	}
	
	function index(){
		$this->view_data['window_title'] = 'About us';
		$this->load->view('aboutus_codearmy_view', $this->view_data);
	}
	
	function index_old(){
		$this->view_data['window_title'] = 'About us';
		$this->load->view('about_us_view', $this->view_data);
	}
}