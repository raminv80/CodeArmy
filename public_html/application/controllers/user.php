<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('projects_model');
		$this->load->model('skill_model');
		$this->load->model('inbox_model');
		$this->load->model('stories_model', 'stories');
		
		$this->view_data['page_is'] = 'user';
		$this->view_data['action_is'] = $this->uri->segment(2);
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
			}
		// - check if user is logged in
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
		} else { // - if user not login, redirect to dashboard. 
			/*$controller = $this->uri->segment(1);
			$action = $this->uri->segment(2);
			$param = $this->uri->segment(3);
			$referer = $controller;
			if($action)$referer .= '/'.$action;
			if($param)$referer .= "/".$param;
			$this->session->set_userdata('referer', $referer);
			redirect("login"); */
		}	
	}
	
	function show($id){
		$this->session->set_userdata('check_id', $id);
		$user_id = $id;
		$me = $this->users_model->get_user($user_id);
		$me = $me->result_array();
		$me = $me[0];
		$myProfile = $this->users_model->get_profile($user_id);
		
		if($myProfile){
			$myProfile = $myProfile->result_array();
			$myProfile = $myProfile[0];
		}
		$this->view_data['me'] = $me;
		$this->view_data['myProfile'] = $myProfile;
		$this->view_data['profile'] = $myProfile;
		$this->view_data['works_completed'] = $this->users_model->works_compeleted($user_id);
		$this->view_data['hours_spent']  = $this->users_model->hours_spent($user_id);
		$this->view_data['hours_saved'] = $this->users_model->hours_saved($user_id);
		$this->view_data['last_task'] = $this->users_model->last_task($user_id);
		$this->view_data['working_on'] = $this->users_model->working_on($user_id);
		$this->view_data['collaborators'] = $this->users_model->collaborators($user_id);
		$this->view_data['badges'] = $this->skill_model->get_my_badges($user_id);
		$this->view_data['leaderboard_project'] = $this->users_model->leaderboard_projects(3);
		$this->view_data['leaderboard_points'] = $this->users_model->leaderboard_points(3);
		$this->view_data['leaderboard_time'] = $this->users_model->leaderboard_time(3);
		$this->view_data['my_skills'] = $this->skill_model->get_my_skills($user_id);
		$this->view_data['last_badge'] = $this->skill_model->get_last_badge($user_id);
		$this->view_data['window_title'] = $me['username']." | Workpad";
		$this->load->view('user_view', $this->view_data);	
	}
	
}