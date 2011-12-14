<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Myoffice extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('projects_model');
		$this->load->model('skill_model');
		$this->load->model('inbox_model');
		$this->load->model('stories_model', 'stories');
		
		$this->view_data['page_is'] = 'Myoffice';
		$this->view_data['action_is'] = $this->uri->segment(2);
		// - check if user is logged in
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
			$this->view_data['user_id'] = $this->session->userdata('user_id');
		} else { // - if user not login, redirect to dashboard. 
			$controller = $this->uri->segment(1);
			$action = $this->uri->segment(2);
			$param = $this->uri->segment(3);
			$referer = $controller;
			if($action)$referer .= '/'.$action;
			if($param)$referer .= "/".$param;
			$this->session->set_userdata('referer', $referer);
			redirect("login"); 
		}	
	}
	
	function index(){
		$user_id = $this->session->userdata('user_id');
		$me = $this->users_model->get_user($user_id);
		$me = $me->result_array();
		$me = $me[0];
		$myProfile = $this->users_model->get_profile($user_id);
		$myProfile = $myProfile->result_array();
		$myProfile = $myProfile[0];
		
		$this->view_data['me'] = $me;
		$this->view_data['myProfile'] = $myProfile;
		$this->view_data['works_completed'] = $this->users_model->works_compeleted($user_id);
		$this->view_data['hours_spent']  = $this->users_model->hours_spent($user_id);
		$this->view_data['hours_saved'] = $this->users_model->hours_saved($user_id);
		$this->view_data['last_task'] = $this->users_model->last_task($user_id);
		$this->view_data['working_on'] = $this->users_model->working_on($user_id);
		$this->view_data['leaderboard_project'] = $this->users_model->leaderboard_projects(3);
		$this->view_data['leaderboard_points'] = $this->users_model->leaderboard_points(3);
		$this->view_data['leaderboard_time'] = $this->users_model->leaderboard_time(3);
		$this->view_data['collaborators'] = $this->users_model->collaborators($user_id);
		$this->view_data['my_skills'] = $this->skill_model->get_my_skills($user_id);
		$this->view_data['last_badge'] = $this->skill_model->get_last_badge($user_id);
		
		$this->view_data['window_title'] = "Workpad :: MyOffice";
		$this->load->view('my_office_view', $this->view_data);	
	}
		
	function AjaxTab_tab_1(){
		//Summary Tab
		$user_id = $this->session->userdata('user_id');
		$me = $this->users_model->get_user($user_id);
		$me = $me->result_array();
		$me = $me[0];
		$myProfile = $this->users_model->get_profile($user_id);
		$myProfile = $myProfile->result_array();
		$myProfile = $myProfile[0];
		
		$this->view_data['me'] = $me;
		$this->view_data['myProfile'] = $myProfile;
		$this->view_data['works_completed'] = $this->users_model->works_compeleted($user_id);
		$this->view_data['hours_spent']  = $this->users_model->hours_spent($user_id);
		$this->view_data['hours_saved'] = $this->users_model->hours_saved($user_id);
		$this->view_data['last_task'] = $this->users_model->last_task($user_id);
		$this->view_data['working_on'] = $this->users_model->working_on($user_id);
		$this->view_data['leaderboard_project'] = $this->users_model->leaderboard_projects(3);
		$this->view_data['leaderboard_points'] = $this->users_model->leaderboard_points(3);
		$this->view_data['leaderboard_time'] = $this->users_model->leaderboard_time(3);
		$this->view_data['collaborators'] = $this->users_model->collaborators($user_id);
		$this->view_data['last_badge'] = $this->skill_model->get_last_badge($user_id);
		$this->view_data['my_skills'] = $this->skill_model->get_my_skills($user_id);
		$this->load->view('Ajax_tab_1', $this->view_data);	
	}
	
	function AjaxTab_tab_2(){
		//Achievement Tab
		$user_id = $this->session->userdata('user_id');
		$me = $this->users_model->get_user($user_id);
		$me = $me->result_array();
		$me = $me[0];
		$myProfile = $this->users_model->get_profile($user_id);
		$myProfile = $myProfile->result_array();
		$myProfile = $myProfile[0];
		$this->view_data['badges'] = $this->skill_model->get_my_badges($user_id);
		$this->load->view('Ajax_tab_2', $this->view_data);	
	}
	
	function AjaxTab_tab_3(){
		//Inbox Tab
		$user_id = $this->session->userdata('user_id');
		$me = $this->users_model->get_user($user_id);
		$me = $me->result_array();
		$me = $me[0];
		$myProfile = $this->users_model->get_profile($user_id);
		$myProfile = $myProfile->result_array();
		$myProfile = $myProfile[0];
		
		$this->view_data['messages'] = $this->inbox_model->list_messages($user_id);
		$this->view_data['recom'] = $this->users_model->recommendation($user_id);
		$this->load->view('Ajax_tab_3', $this->view_data);	
	}
	
	function AjaxTab_tab_4(){
		//MyDesk Tab
		$user_id = $this->session->userdata('user_id');
		$me = $this->users_model->get_user($user_id);
		$me = $me->result_array();
		$me = $me[0];
		$myProfile = $this->users_model->get_profile($user_id);
		$myProfile = $myProfile->result_array();
		$myProfile = $myProfile[0];
		
		$this->view_data['inProgress_empty'] = false;
		$this->view_data['done_empty'] = false;
		$this->view_data['signoff_empty'] = false;
		$query = $this->stories->get_my_works($user_id,'In progress');
		if($query->num_rows() > 0) {
			$this->view_data['work_list_inProgress'] = $query->result_array();
		}else{
			$this->view_data['inProgress_empty'] = true;
		}

		$query1 = $this->stories->get_my_works($user_id,'Done');
		if($query1->num_rows() > 0) {
			$this->view_data['work_list_done'] = $query1->result_array();
		}else{
			$this->view_data['done_empty'] = true;
		}
		$query2 = $this->stories->get_my_works($user_id,'Signoff');
		if($query2->num_rows() > 0) {
			$this->view_data['work_list_signoff'] = $query2->result_array();
		} else {
			$this->view_data['signoff_empty'] = true;
		}
		
		$this->load->view('Ajax_tab_4', $this->view_data);	
	}
	
	function AjaxTab_tab_5(){
		//History Tab
		$user_id = $this->session->userdata('user_id');
		$me = $this->users_model->get_user($user_id);
		$me = $me->result_array();
		$me = $me[0];
		$myProfile = $this->users_model->get_profile($user_id);
		$myProfile = $myProfile->result_array();
		$myProfile = $myProfile[0];
		
		$this->view_data['history'] = $this->inbox_model->get_history($user_id);
		
		$this->load->view('Ajax_tab_5', $this->view_data);	
	}
	
	function AjaxTab_tab_6(){
		//Leaderboard Tab
		$user_id = $this->session->userdata('user_id');
		$me = $this->users_model->get_user($user_id);
		$me = $me->result_array();
		$me = $me[0];
		$myProfile = $this->users_model->get_profile($user_id);
		$myProfile = $myProfile->result_array();
		$myProfile = $myProfile[0];
		
		$this->view_data['leaderboard_project'] = $this->users_model->leaderboard_projects();
		$this->view_data['leaderboard_points'] = $this->users_model->leaderboard_points();
		$this->view_data['leaderboard_time'] = $this->users_model->leaderboard_time();
		
		$this->load->view('Ajax_tab_6', $this->view_data);	
	}
	
	function AjaxTab_tab_7(){
		//Personal Info Tab
		$user_id = $this->session->userdata('user_id');
		$me = $this->users_model->get_user($user_id);
		$me = $me->result_array();
		$me = $me[0];
		$myProfile = $this->users_model->get_profile($user_id);
		$myProfile = $myProfile->result_array();
		$myProfile = $myProfile[0];
		
		$this->view_data['me'] = $me;
		$this->view_data['profile'] = $myProfile;
		$this->view_data['username'] = $this->session->userdata("username");
		$this->view_data['message'] = $this->session->flashdata('message');
		$this->view_data['works_completed'] = $this->users_model->works_compeleted($user_id);
		$this->view_data['hours_spent']  = $this->users_model->hours_spent($user_id);
		$this->view_data['hours_saved'] = $this->users_model->hours_saved($user_id);
		$this->load->view('Ajax_tab_7', $this->view_data);	
	}
	
	function AjaxTab_tab_8(){
		//Personal Info Tab
		$user_id = $this->session->userdata('user_id');
		$me = $this->users_model->get_user($user_id);
		$me = $me->result_array();
		$me = $me[0];
		$myProfile = $this->users_model->get_profile($user_id);
		$myProfile = $myProfile->result_array();
		$myProfile = $myProfile[0];
		
		$this->view_data['me'] = $me;
		$this->view_data['profile'] = $myProfile;
		$this->view_data['username'] = $this->session->userdata("username");
		$this->view_data['message'] = $this->session->flashdata('message');
		$this->view_data['works_completed'] = $this->users_model->works_compeleted($user_id);
		$this->view_data['hours_spent']  = $this->users_model->hours_spent($user_id);
		$this->view_data['hours_saved'] = $this->users_model->hours_saved($user_id);
		
		$this->view_data['projects'] = $this->projects_model->get_my_projects($user_id);
		
		$this->load->view('Ajax_tab_8', $this->view_data);	
	}
	
}