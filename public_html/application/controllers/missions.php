<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Missions extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('users_model');
		$this->load->model('skill_model');
		$this->load->model('projects_model');
		$this->load->model('stories_model', 'stories');
		
		$this->view_data['page_is'] = 'Missions';
		$this->view_data['action_is'] = $this->uri->segment(2);
		$controller = $this->uri->segment(1);
		$action = $this->uri->segment(2);
		$param = $this->uri->segment(3);
		$this->view_data['action_is'] = $action;
		// - check if user is logged in
		
		$user_id = $this->session->userdata('user_id');
		
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
			$this->view_data['username'] = $this->session->userdata('username');
		} else if(strpos($action, "AjaxTab")===false){ // - if user not login, redirect to dashboard.
			$referer = $controller;
			if($action)$referer .= '/'.$action;
			if($param)$referer .= "/".$param;
			$this->session->set_userdata('referer', $referer); 
			redirect("login");
		}
	}
	
	function find(){
		$this->view_data['window_title'] = "Find Missions";
		$this->load->view('find_missions_codearmy_view', $this->view_data);
	}
	
	function index(){
		$percision = 0;
		$user_id = $this->view_data['me']['user_id'];
		$works = $this->stories->stories_map($percision);
		$mySkills = $this->skill_model->get_my_skills($user_id);
		$this->view_data['myLevel'] = $this->gamemech->get_level($this->view_data['me']['exp']);
		$this->view_data['expProgress'] = $this->gamemech->get_progress_bar($this->view_data['me']['exp']);
		$this->view_data['mySkills'] = $mySkills;
		$this->view_data['percision'] = $percision;
		$this->view_data['works'] = $works;
		$this->view_data['window_title'] = "My Missions";
		$this->load->view('missions_codearmy_view', $this->view_data);
	}
	
	function ajax_mission_map_search(){
		$percision = 0;
		$search = $this->input->post('search');
		$type = $this->input->post('type');
		if($search == 'all'|| (!$search)){
			switch($type){
				case 'latest': $works = $this->stories->stories_map($percision);break;
				case 'classification': $works = $this->stories->stories_map_class($percision);break;
				case 'estimation': $works = $this->stories->stories_map_estimation($percision);break;
				case 'payout': $works = $this->stories->stories_map_payout($percision);break;
				default: $works = $this->stories->stories_map($percision);break;
			}
		}else{
			switch($type){
				case 'latest': $works = $this->stories->search_stories_map($percision, $search);break;
				case 'classification': $works = $this->stories->search_stories_map_class($percision, $search);break;
				case 'estimation': $works = $this->stories->search_stories_map_estimation($percision, $search);break;
				case 'payout': $works = $this->stories->search_stories_map_payout($percision, $search);break;
				default: $works = $this->stories->search_stories_map($percision, $search);break;
			}
		}
		echo json_encode($works);
	}
	
	function ajax_mission_map_classification(){
		$percision = 0;
		$works = $this->stories->stories_map_class($percision);
		echo json_encode($works);
	}
	
	function ajax_mission_map_skills(){
		$percision = 0;
		$works = $this->stories->stories_map_skills($percision);
		echo json_encode($works);
	}
	
	function ajax_mission_map_estimation(){
		$percision = 0;
		$works = $this->stories->stories_map_estimation($percision);
		echo json_encode($works);
	}
	
	function ajax_mission_map_payout(){
		$percision = 0;
		$works = $this->stories->stories_map_payout($percision);
		echo json_encode($works);
	}
	
	function my_missions(){
		$user_id = $this->view_data['me']['user_id'];
		$this->view_data['myWorkList'] = $this->stories->get_my_works($user_id, 'in progress')->result_array();
		$this->view_data['window_title'] = "My Missions";
		$this->load->view('mymissions_codearmy_view', $this->view_data);
	}
	
	function bid(){
		$this->view_data['window_title'] = "Mission Bid";
		$this->load->view('mybids_codearmy_view', $this->view_data);
	}
	
	function completed(){
		$this->view_data['window_title'] = "Missions Completed";
		$this->load->view('completed_codearmy_view', $this->view_data);
	}
}