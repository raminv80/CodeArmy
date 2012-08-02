<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Missions extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('users_model');
		$this->load->model('skill_model');
		$this->load->model('message_model');
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
	
	function hq(){
		$percision = 0;
		$user_id = $this->view_data['me']['user_id'];
		$works = $this->stories->stories_map($percision);
		$mySkills = $this->skill_model->get_my_skills($user_id);
		$this->view_data['myLevel'] = $this->gamemech->get_level($this->view_data['me']['exp']);
		$this->view_data['expProgress'] = $this->gamemech->get_progress_bar($this->view_data['me']['exp']);
		$this->view_data['mySkills'] = $mySkills;
		$this->view_data['percision'] = $percision;
		$this->view_data['works'] = $works;
		$this->view_data['window_title'] = "CodeArmy World";
		$this->load->view('po_missions_codearmy_view', $this->view_data);
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
		$this->view_data['window_title'] = "CodeArmy World";
		$this->load->view('missions_codearmy_view', $this->view_data);
	}
	
	//function category(){
		//$category = $this->input->post('mission_category');
		//$this->session->mission_category($category);
		//echo "success";
		//$this->load->view('missions_codearmy_view', $this->view_data);
	//}
	
	function create(){
		/*$work_id = $this->_gen_id();
		$check_work_id = $this->get_work($work_id);
		while($check_work_id->num_rows() > 1) {
			$work_id = $this->_gen_id();
			$check_work_id = $this->get_work($work_id);			
		}
		$res = array(
			"work_id" => $work_id,
			"title" => $title,
			"subclass" => $subclass,
			"category" => $category,
			"description" => $description,
			"points" => $points,
			"cost" => $cost,
			"status" => 'open',
			"creator" => $user_id,
			"owner" => $pm_id,
			"project_id" => $project_id,
			"created_at" => date('Y-m-d H:i:s'),
			"work_horse" => $horse_id,
			"bid_deadline" => $bid_deadline,
			"deadline" => $deadline,
			"assigned_at" => $assigned_at,
			"done_at" => $done_at,
			"tutorial" => $tutorial,
			"attach" => $file_id,
			"lat" => $lat,
			"lng" => $lng
		);
		if($this->db->insert('works', $res)) {
			foreach($skill_id as $value):
				$res = array(
					"work_id" => $work_id,
					"skill_id" => $value
				);
				$this->db->insert('work_skill', $res);
			endforeach;
			
			return $work_id;
		} else {
			return false;
		}*/
		//$this->view_data['mission_category'] = $this->input->post('mission_category');
		$this->view_data['window_title'] = "Mission Create";
		$this->load->view('create_mission_codearmy_view', $this->view_data);
	}
	
	function upload_mission_file(){
		$file_id = $this->_gen_id();
		$check_file_id = $this->get_file($file_id);
		while($check_file_id->num_rows() > 1) {
			$file_id = $this->_gen_id();
			$check_file_id = $this->get_file($file_id);			
		}
		
		// file storing
		
		// end of file storing
		
		$res = array(
			"file_id" => $file_id,
			"file_type" => $file_type,
			"file_name" => $file_name,
			"file_title" => $file_title,
			"file_description" => $file_description,
			"created_at" => date('Y-m-d H:i:s')
		);
		if($this->db->insert('work_files', $res)) {
			return $file_id;
		} else {
			return false;
		}
	}
	
	function _gen_id() {
		$work_id = '';
		list($usec, $sec) = explode(' ', microtime());
		$rand_seed = (float)$sec + ((float)$usec * 100000);
		mt_srand($rand_seed);
		for ($r = 0; $r<13; $r++) { $work_id .= mt_rand(0,9); }
		return $work_id;
	}
	
	function get_work($work_id) {
		return $this->db->get_where('works', array('work_id' => $work_id));
	}
	
	function get_file($file_id) {
		return $this->db->get_where('work_files', array('file_id' => $file_id));
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