<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leaderboard extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('projects_model');
		$this->load->model('users_model');
		$this->load->model('stories_model', 'stories');
		
		$this->view_data['page_is'] = 'Leaderboard';
		$this->view_data['action_is'] = $this->uri->segment(2);
		// - check if user is logged in
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
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
				$this->view_data['myActiveMissions'] = $this->stories->get_num_my_works($user_id, 'in progress');
				$this->view_data['myActiveMessages'] = $this->message_model->num_unread($user_id);
				$this->view_data['myActiveNotifications'] = 0;
			}
			$this->view_data['username'] = $this->session->userdata('username');
		} else { // - if user not login, redirect to dashboard. 
			//redirect("login"); 
		}
	}
	
	function index(){
		$user_id = $this->session->userdata('user_id');
		$this->view_data['leaderboard_points'] = $this->users_model->leaderboard_points(10);
		$this->view_data['leaderboard_centered'] = $this->users_model->leaderboard_centered_details($user_id);
		
		$this->view_data['window_title'] = $this->session->userdata('username');
		$this->load->view('leaderboard_codearmy_view', $this->view_data);
	}
	
	// - profile index function
	function index_old() {
		$this->view_data['leaderboard_project'] = $this->users_model->leaderboard_projects();
		$this->view_data['leaderboard_points'] = $this->users_model->leaderboard_points();
		$this->view_data['leaderboard_time'] = $this->users_model->leaderboard_time();
		
		$this->view_data['window_title'] = "Workpad Leaderboard";
		$this->load->view('leader_board_view', $this->view_data);		
	}
	
	function Ajax_leaderboard(){
		$leaderboard_project = $this->users_model->leaderboard_projects();
		$leaderboard_points = $this->users_model->leaderboard_points();
		$leaderboard_time = $this->users_model->leaderboard_time();
		foreach($leaderboard_project as $i=>$leader):
			echo $leader['user_id'];
			if($i<(count($leaderboard_project)-1))echo ',';
		endforeach;
		echo ';';
		foreach($leaderboard_points as $i=>$leader):
			echo $leader['user_id'];
			if($i<(count($leaderboard_points)-1))echo ',';
		endforeach;
		echo ';';
		foreach($leaderboard_time as $i=>$leader):
			echo $leader['user_id'];
			if($i<(count($leaderboard_time)-1))echo ',';
		endforeach;
		echo '~';
		$this->view_data['leaderboard_project'] = $leaderboard_project;
		$this->view_data['leaderboard_points'] = $leaderboard_points;
		$this->view_data['leaderboard_time'] = $leaderboard_time;
		$this->view_data['window_title'] = "Workpad Leaderboard";
		$this->load->view('Ajax_leaderboard', $this->view_data);
	}
}