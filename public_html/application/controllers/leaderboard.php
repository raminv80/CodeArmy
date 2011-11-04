<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leaderboard extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('stories_model','story');
		
		$this->view_data['page_is'] = 'Leaderboard';
		
		// - check if user is logged in
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
		} else { // - if user not login, redirect to dashboard. 
			//redirect("login"); 
		}
	}
	
	
	// - profile index function
	function index() {
		$this->view_data['leaderboard_project'] = $this->users_model->leaderboard_projects();
		$this->view_data['leaderboard_points'] = $this->users_model->leaderboard_points();
		$this->view_data['leaderboard_time'] = $this->users_model->leaderboard_time();
		
		$this->view_data['window_title'] = "Workpad :: Leaderboard";
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
		$this->view_data['window_title'] = "Workpad :: Leaderboard";
		$this->load->view('Ajax_leaderboard', $this->view_data);
	}
}