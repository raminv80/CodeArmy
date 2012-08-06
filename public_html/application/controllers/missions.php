<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Missions extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('users_model');
		$this->load->model('skill_model');
		$this->load->model('message_model');
		$this->load->model('projects_model');
		$this->load->model('work_model');
		$this->load->model('stories_model', 'stories');
		
		$this->view_data['page_is'] = 'Missions';
		$this->view_data['action_is'] = $this->uri->segment(2);
		$controller = $this->uri->segment(1);
		$action = $this->uri->segment(2);
		$param = $this->uri->segment(3);
		$this->view_data['action_is'] = $action;
		
		$this->percision = 0;
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
			$this->view_data['myActiveMessages'] = $this->message_model->num_unread($user_id);
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
		$percision = $this->percision;
		$user_id = $this->view_data['me']['user_id'];
		$works = $this->stories->stories_map($percision);
		$mySkills = $this->skill_model->get_my_skills($user_id);
		$this->view_data['main_category'] = $this->work_model->get_main_category();
		$this->view_data['myLevel'] = $this->gamemech->get_level($this->view_data['me']['exp']);
		$this->view_data['expProgress'] = $this->gamemech->get_progress_bar($this->view_data['me']['exp']);
		$this->view_data['mySkills'] = $mySkills;
		$this->view_data['percision'] = $percision;
		$this->view_data['works'] = $works;
		$this->view_data['window_title'] = "CodeArmy World";
		$this->load->view('po_missions_codearmy_view', $this->view_data);
	}
	
	function index(){
		$percision = $this->percision;
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
	
	function recommended_tallents(){
		$work_id = "044295";
		$this->view_data['recoms'] = $this->work_model->get_tallents($work_id);
		$this->view_data['window_title'] = "CodeArmy World";
		$this->load->view('recom_tal_codearmy_view', $this->view_data);
	}
	
	function mission_confirmation($work_id){
		$user_id = $this->session->userdata('user_id');
		$preview = $this->work_model->previewMission($work_id, $user_id);
		//if(count($preview)!=1)die('die hcker!');
		$this->view_data['preview'] = $preview[0];
		$this->view_data['window_title'] = "CodeArmy World";
		$this->load->view('confirm_mission_codearmy_view', $this->view_data);
	}
	
	function mission_list($lat,$lng){
		$this->view_data['works'] = $this->stories->list_stories_map($this->percision,$lat,$lng);
		$this->view_data['window_title'] = "CodeArmy World";
		$this->load->view('mission_list_codearmy_view', $this->view_data);
	}
	
	//function category(){
		//$category = $this->input->post('mission_category');
		//$this->session->mission_category($category);
		//echo "success";
		//$this->load->view('missions_codearmy_view', $this->view_data);
	//}
	function create_complete(){
		$work_id = $this->input->post('work_id');
		$res = array(
			"status" => 'open'
		);
		$res2 = array(
			'work_id'=>$work_id
		);
		$this->db->update('works', $res, $res2);
		redirect("missions/hq");
	}
	
	function create($cat=''){
		$this->view_data['cat_selected'] = $cat;
		$this->view_data['main_category'] = $this->work_model->get_main_category();
		$this->view_data['class'] = $this->work_model->get_main_class($cat);
		$this->view_data['sub_class'] = $this->work_model->get_sub_class($cat,'');
		$this->view_data['window_title'] = "Mission Create";
		$this->load->view('create_mission_codearmy_view', $this->view_data);
	}
	
	function check_create_mission(){
		$user_id = $this->view_data['me']['user_id'];
		
		$work_id = $this->work_model->_gen_id();
		$check_work_id = $this->work_model->get_work($work_id);
		while($check_work_id->num_rows() > 1) {
			$work_id = $this->work_model->_gen_id();
			$check_work_id = $this->work_model->get_work($work_id);			
		}
		$info = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
		$lat = $info['geoplugin_latitude'];
		$lng = $info['geoplugin_longitude'];
		$res = array(
			"work_id" => $work_id,
			"title" => $this->input->post('mission_title'),
			"sprint" => 0,
			"class" => ($this->input->post('mission_type_class')==0)?NULL:$this->input->post('mission_type_class'),
			"subclass" => ($this->input->post('mission_type_subclass')==0)?NULL:$this->input->post('mission_type_subclass'),
			"category" => $this->input->post('mission_type_main'),
			"description" => $this->input->post('mission_desc'),
			//"points" => calc_points(),
			//"cost" => calc_cost($this->input->post('mission_arrange_hour'),$this->input->post('mission_arrange_month'),$this->input->post('mission_budget')),
			"points" => 0,
			"cost" => '0',
			"status" => 'draft',
			"creator" => $user_id,
			"owner" => $user_id,
			"project_id" => NULL,
			"created_at" => date('Y-m-d H:i:s'),
			"work_horse" => NULL,
			"bid_deadline" => NULL,
			"deadline" => NULL,
			"assigned_at" => NULL,
			"done_at" => NULL,
			"tutorial" => NULL,
			"attach" => NULL,
			"lat" => $lat,
			"lng" => $lng
		);
		if($this->db->insert('works', $res)) {
			//foreach($skill_id as $value):
				//$res = array(
					//"work_id" => $work_id,
					//"skill_id" => $value
				//);
				//$this->db->insert('work_skill', $res);
			//endforeach;
			echo $work_id;
			
			$res = array(
				"work_id" => $work_id,
				"session_id" => ''
			);
			$res2 = array(
				"session_id" => $this->session->userdata('session_id')
			);
			$this->db->update('work_files', $res, $res2);
			
			//echo "success";
		} else {
			//return false;
			echo "error";
		}
	}
	
	private function calc_cost($type,$timeline,$budget){
		//TODO
		return 0;
	}
	
	private function clac_points(){
		//TODO
		return 0;
	}
	
	public function uploadfiles(){
		//$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
		//$targetDir = 'public/uploads/';
		$targetDir = FCPATH.'public/uploads/';
		
		//$cleanupTargetDir = false; // Remove old files
		//$maxFileAge = 60 * 60; // Temp file age in seconds
		
		// 5 minutes execution time
		@set_time_limit(5 * 60);
		
		// Uncomment this one to fake upload time
		// usleep(5000);
		
		// Get parameters
		$chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
		$chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
		$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';
		
		// Clean the fileName for security reasons
		$fileName = preg_replace('/[^\w\._]+/', '', $fileName);
		
		// Make sure the fileName is unique but only if chunking is disabled
		if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)){
			$ext = strrpos($fileName, '.');
			$fileName_a = substr($fileName, 0, $ext);
			$fileName_b = substr($fileName, $ext);
			
			$count = 1;
			while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
			$count++;
			
			$fileName = $fileName_a . '_' . $count . $fileName_b;
		}
		
		// Create target dir
		if (!file_exists($targetDir))
		@mkdir($targetDir);
		
		$contentType = "";
		
		if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
		$contentType = $_SERVER["HTTP_CONTENT_TYPE"];
		
		if (isset($_SERVER["CONTENT_TYPE"]))
		$contentType = $_SERVER["CONTENT_TYPE"];
		
		// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
		if (strpos($contentType, "multipart") !== false){
			if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
				// Open temp file
				$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
				if ($out){
					// Read binary input stream and append it to temp file
					$in = fopen($_FILES['file']['tmp_name'], "rb");
					
					if ($in) {
						while ($buff = fread($in, 4096))
						fwrite($out, $buff);
						$file_id = $this->work_model->_gen_id();
						$res = array(
							"file_id" => $file_id,
							"file_type" => $_FILES['file']['type'],
							"file_name" => $fileName,
							"created_at" => date('Y-m-d H:i:s'),
							"session_id" => $this->session->userdata('session_id')
						);
						$this->db->insert('work_files', $res);
					} else
						die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
						fclose($in);
						fclose($out);
						@unlink($_FILES['file']['tmp_name']);
				} else
					die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
		} else {
			// Open temp file
			$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
			if ($out) {
				// Read binary input stream and append it to temp file
				$in = fopen("php://input", "rb");
				
				if ($in) {
					while ($buff = fread($in, 4096))
					fwrite($out, $buff);
					$file_id = $this->work_model->_gen_id();
					$res = array(
						"file_id" => $file_id,
						"file_type" => $_FILES['file']['type'],
						"file_name" => $fileName,
						"created_at" => date('Y-m-d H:i:s'),
						"session_id" => $this->session->userdata('session_id')
					);
					$this->db->insert('work_files', $res);
				} else
					die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
					
					fclose($in);
					fclose($out);
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}
		// Return JSON-RPC response
		die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
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