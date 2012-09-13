<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Missions extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		//enable for debugging
		//$this->output->enable_profiler(TRUE);
		$this->load->helper('number');
		$this->load->helper('text');
		$this->load->model('users_model');
		$this->load->model('recom_model');
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
			$this->view_data['myActiveNotifications'] = 0;
			$this->view_data['username'] = $this->session->userdata('username');
		} else if(strpos($action, "AjaxTab")===false){ // - if user not login, redirect to dashboard.
			$referer = $controller;
			if($action)$referer .= '/'.$action;
			if($param)$referer .= "/".$param;
			$this->session->set_userdata('referer', $referer); 
			redirect("login");
		}
	}
	
	function apply($work_id){
		$work = $this->work_model->get_work($work_id)->result_array();
		$work = $work[0];
		$this->view_data['work'] = $work;
		$arr = $this->work_model->get_work_arrangement($work_id);
		$this->view_data['arranegement'] = $arr;
		$estimate_time = $this->work_model->get_selected_arrangement_time($work['est_time_frame']);
		if(!$estimate_time){$estimate_time=0;} else {$estimate_time = $estimate_time[0];}
		$this->view_data['estimate_time'] = $estimate_time;
		$estimate_budget = $this->work_model->get_selected_arrangement_budget($work['est_budget']);
		if(!$estimate_budget){$estimate_budget=0;} else {$estimate_budget = $estimate_budget[0];}
		$this->view_data['estimate_budget'] = $estimate_budget;
		$po = $this->users_model->get_user($work['owner'])->result_array();
		$po = $po[0];
		$this->view_data['po'] = $po;
		$poBadges = $this->skill_model->get_my_top8_badges($work['owner']);
		if(!$poBadges){$poBadges=NULL;}
		//was user invited?
		$res = $this->work_model->invited_to_work($this->view_data['me']['user_id'],$work_id);
		if(count($res)){
			$this->work_model->updateInvite($res[0]['invite_id'],'viewed');
		}
		$this->view_data['po_badge'] = $poBadges;
		$this->view_data['work_skills'] = $this->work_model->get_work_skills($work_id);
		$this->view_data['work_files'] = $this->work_model->previewFiles($work_id);
		$this->view_data['bids'] = $this->work_model->get_work_bids($work_id);
		$this->view_data['bidders'] = $this->work_model->get_bidders($work_id);
		$this->view_data['bid_avg'] = $this->work_model->get_bid_avg($work_id);
		$this->view_data['window_title'] = "CodeArmy Apply for mission";
		$this->load->view('mission_apply_codearmy', $this->view_data);
	}
	
	function manage($work_id){
		$this->view_data['work_id'] = $work_id;
		$this->view_data['work'] = $this->work_model->get_work($work_id)->result_array();
		$this->view_data['work'] = $this->view_data['work'][0];
		$work = $this->view_data['work'];
		$this->view_data['work_skills'] = $this->work_model->get_work_skills($work_id);
		$this->view_data['work_files'] = $this->work_model->previewFiles($work_id);
		$arr = $this->work_model->get_work_arrangement($work_id);
		$this->view_data['arranegement'] = $arr;
		$estimate_time = $this->work_model->get_selected_arrangement_time($work['est_time_frame']);
		if(!$estimate_time){$estimate_time=0;} else {$estimate_time = $estimate_time[0];}
		$this->view_data['estimate_time'] = $estimate_time;
		$estimate_budget = $this->work_model->get_selected_arrangement_budget($work['est_budget']);
		if(!$estimate_budget){$estimate_budget=0;} else {$estimate_budget = $estimate_budget[0];}
		$this->view_data['estimate_budget'] = $estimate_budget;
		$this->view_data['bid_avg'] = $this->work_model->get_bid_avg($work_id);
		$this->view_data['bids'] = $this->work_model->get_bids($work_id);
		$this->view_data['invitations'] = $this->work_model->get_pending_invitations($work_id);
		$this->view_data['troops'] = $this->work_model->get_active_bids($work_id);
		$this->view_data['window_title'] = "CodeArmy Apply for mission";
		$this->load->view('po_manage_codearmy', $this->view_data);
	}
	
	function set_bid(){
		if($this->input->post('submit')){
			$this->bid_application();
		}
		redirect("/missions/apply/$work_id");
	}
	
	function Ajax_submit(){
		//user flagged a mission as complete
		
		//check if he is authorised
		$user_id = $this->view_data['me']['user_id'];
		$work_id = $this->input->post('work_id');
		$work = $this->work_model->get_work($work_id)->result_array();
		if(count($work)!=1)die('Error: job is not selected properly!');
		if($work[0]['work_horse']!=$user_id)die('Error: only the contrator of selected job can submit it!');
		if(!in_array(strtolower($work[0]['status']),array('in progress','redo')))die('Error:job status is not right!');
		//update job details
		if($this->work_model->job_completed($work_id)==1){
			//push the submission event
			require_once(getcwd()."/application/helpers/pusher/Pusher.php");
			$pusher = new Pusher('deb0d323940b00c093ee', '9ab20336af22c4e7fa77', '25755');
			
			//trigger mission chanel
			$data = array(
				'user_id' => $user_id,
				'username' => $this->view_data['me']['username'],
				'work_id' => $work_id,
				'work_title' => $work[0]['title'],
				'time' => date('j M Y H:i')
			);
			$pusher->trigger('mission', 'done-mission-'.$work_id, $data );
			
			//save the event in history
			$desc = "finished working";
			$status = '';
			$this->work_model->log_history($user_id,$work_id,'submit',$status,$desc,false);
			$event_id = $this->db->insert_id();
			
			//generate a one time notification for po
			// insert notification
			$intReceiverID = $work[0]['owner'];
			$this->work_model->log_notifications($work_id, $intReceiverID, 'wall');
			
			//push this event in activity channel
			$data = array(
				'user_id' => $user_id,
				'username' => $this->view_data['me']['username'],
				'work_id' => $work_id,
				'work_title'=>$work[0]['title'],
				'Desc' => $desc,
				'event' => 'submit',
				'time' => date('h:ia, d/m/Y'),
				'event_id'=> $event_id
			);
			$pusher->trigger('history', 'new-activity-'.$work_id, $data );
			
			//send a message to user
			$msg = "User ".$this->view_data['me']['username']." flagged mission <a href='/missions/wall/".$work_id."'>".trim($work[0]['title']).'</a> complete. Please <a href="/missions/wall/'.$work_id.'">click here</a> to go to this mission and verify if mission is completed successfully.';
			$this->message_model->send_message($user_id,$work[0]['owner'],'Mission '.trim($work[0]['title']).' completed',$msg);
			echo 'success';
		}
	}
	
	function Ajax_verify_mission(){
		$work_id = $this->input->post('work_id');
		$user_id = $this->view_data['me']['user_id'];
		$work = $this->work_model->get_work($work_id)->result_array();
		//chck if user is po and job is in right mode
		if($work[0]['owner']==$user_id && $work[0]['status']=='Done' || true){
			require_once(getcwd()."/application/helpers/pusher/Pusher.php");
			$pusher = new Pusher('deb0d323940b00c093ee', '9ab20336af22c4e7fa77', '25755');
			//update work data
			$this->work_model->job_verified_and_paid($work_id);
			
			//Award contractor
			//Exp award
			$contractor = $this->users_model->get_user($work[0]['work_horse'])->result_array();
			$difficulty = $this->work_model->get_work_difficulty($work_id);
			$level = $this->game_model->get_level($contractor[0]['exp']);
			$hours = $this->work_model->mission_completed_hours($work_id);
			$award_exp = $this->game_model->mission_accomplished_point($difficulty, $hours, $level);
			$this->users_model->add_exp($contractor[0]['user_id'],$award_exp);
			$contractor = $this->users_model->get_user($work[0]['work_horse'])->result_array();
			$new_level = $this->game_model->get_level($contractor[0]['exp']);
			//Skill award
			$this->work_model->award_user_skills_from($contractor[0]['user_id'],$work_id);
			
			//trigger mission channel for exp up
			$data = array(
				'user_id' => $contractor[0]['user_id'],
				'username' => $contractor[0]['username'],
				'work_id' => $work_id,
				'work_title' => $work[0]['title'],
				'exp' => $award_exp,
				'time' => date('j M Y H:i')
			);
			$pusher->trigger('game-'.$contractor[0]['user_id'], 'exp-up', $data );
			
			if($new_level>$level){
				//trigger mission channel for lvl up
				$data = array(
					'user_id' => $contractor[0]['user_id'],
					'username' => $contractor[0]['username'],
					'work_id' => $work_id,
					'work_title' => $work[0]['title'],
					'level' => $new_level,
					'time' => date('j M Y H:i')
				);
				$pusher->trigger('game-'.$contractor[0]['user_id'], 'lvl-up', $data );
			}
			
			//trigger mission chanel
			$data = array(
				'user_id' => $user_id,
				'username' => $this->view_data['me']['username'],
				'work_id' => $work_id,
				'work_title' => $work[0]['title'],
				'time' => date('j M Y H:i')
			);
			$pusher->trigger('mission', 'verify-mission-'.$work_id, $data );
			
			//save the event in history
			$desc = "verified submited work";
			$status = '';
			$this->work_model->log_history($user_id,$work_id,'verify',$status,$desc,false);
			$event_id = $this->db->insert_id();
			
			//generate a one time notification for po
			// insert notification
			$intReceiverID = $work[0]['work_horse'];
			$this->work_model->log_notifications($work_id, $intReceiverID, 'wall');
			
			//push this event in activity channel
			$data = array(
				'user_id' => $user_id,
				'username' => $this->view_data['me']['username'],
				'work_id' => $work_id,
				'work_title'=>$work[0]['title'],
				'Desc' => $desc,
				'event' => 'verify',
				'time' => date('h:ia, d/m/Y'),
				'event_id'=> $event_id
			);
			$pusher->trigger('history', 'new-activity-'.$work_id, $data );
			
			//send a message to user
			$msg = '<p>Congradulations! Captain <a href="/profile/show/'.$user_id.'">'.$this->view_data['me']['username'].'</a> approved mission <a href="/mission/wall/'.$work_id.'">'.$work[0]['title'].'</a></p>';
			$this->message_model->send_message($user_id,$work[0]['work_horse'],'Mission '.trim($work[0]['title']).' Accomplished!',$msg);
			die('success');
		}else die('Error: wrong user or wrong job is selected.');
	}
	
	function Ajax_redo_mission(){
		$work_id = $this->input->post('work_id');
		$user_id = $this->view_data['me']['user_id'];
		$work = $this->work_model->get_work($work_id)->result_array();
		//chck if user is po and job is in right mode
		if($work[0]['owner']==$user_id && $work[0]['status']=='Done' || true){
			require_once(getcwd()."/application/helpers/pusher/Pusher.php");
			$pusher = new Pusher('deb0d323940b00c093ee', '9ab20336af22c4e7fa77', '25755');
			//update work data
			$this->work_model->job_redo($work_id);
			
			//trigger mission chanel
			$data = array(
				'user_id' => $user_id,
				'username' => $this->view_data['me']['username'],
				'work_id' => $work_id,
				'work_title' => $work[0]['title'],
				'time' => date('j M Y H:i')
			);
			$pusher->trigger('mission', 'redo-mission-'.$work_id, $data );
			
			//save the event in history
			$desc = "asked for revision";
			$status = '';
			$this->work_model->log_history($user_id,$work_id,'redo',$status,$desc,false);
			$event_id = $this->db->insert_id();
			
			//generate a one time notification for po
			// insert notification
			$intReceiverID = $work[0]['work_horse'];
			$this->work_model->log_notifications($work_id, $intReceiverID, 'wall');
			
			//push this event in activity channel
			$data = array(
				'user_id' => $user_id,
				'username' => $this->view_data['me']['username'],
				'work_id' => $work_id,
				'work_title'=>$work[0]['title'],
				'Desc' => $desc,
				'event' => 'redo',
				'time' => date('h:ia, d/m/Y'),
				'event_id'=> $event_id
			);
			$pusher->trigger('history', 'new-activity-'.$work_id, $data );
			
			//send a message to user
			$msg = '<p>Captain <a href="/profile/show/'.$user_id.'">'.$this->view_data['me']['username'].'</a> needs you to revise your work on mission <a href="/mission/wall/'.$work_id.'">'.$work[0]['title'].'</a></p><p>Please use the <a href="/mission/wall/'.$work_id.'">mission wall</a> to discuss requirements in detail.</p><p>Thank you</p>';
			$this->message_model->send_message($user_id,$work[0]['work_horse'],'Mission '.trim($work[0]['title']).' needs more work!',$msg);
			
			die('success');
		}else die('Error: wrong user or wrong job is selected.');
	}
	
	function hq(){
		$percision = $this->percision;
		$user_id = $this->view_data['me']['user_id'];
		$works = $this->stories->stories_map($percision);
		$mySkills = $this->skill_model->get_my_skills($user_id);
		$this->view_data['main_category'] = $this->work_model->get_main_category();
		$this->view_data['myLevel'] = $this->game_model->get_level($this->view_data['me']['exp']);
		$this->view_data['expProgress'] = $this->game_model->get_progress_bar($this->view_data['me']['exp']);
		$this->view_data['mySkills'] = $mySkills;
		$this->view_data['percision'] = $percision;
		$this->view_data['works'] = $works;
		$this->view_data['window_title'] = "CodeArmy World";
		$this->load->view('po_missions_codearmy_view', $this->view_data);
	}
	
	function tallent_map(){
		$percision = $this->percision;
		$user_id = $this->view_data['me']['user_id'];
		$tallents = $this->users_model->tallents_map($percision);
		$mySkills = $this->skill_model->get_my_skills($user_id);
		$this->view_data['main_category'] = $this->work_model->get_main_category();
		$this->view_data['myLevel'] = $this->game_model->get_level($this->view_data['me']['exp']);
		$this->view_data['expProgress'] = $this->game_model->get_progress_bar($this->view_data['me']['exp']);
		$this->view_data['mySkills'] = $mySkills;
		$this->view_data['percision'] = $percision;
		$this->view_data['tallents'] = $tallents;
		$this->view_data['window_title'] = "CodeArmy World";
		$this->load->view('tallent_map_codearmy_view', $this->view_data);
	}
	
	function index(){
		$percision = $this->percision;
		$user_id = $this->view_data['me']['user_id'];
		$works = $this->stories->stories_map($percision);
		$mySkills = $this->skill_model->get_my_skills($user_id);
		$this->view_data['myLevel'] = $this->game_model->get_level($this->view_data['me']['exp']);
		$this->view_data['expProgress'] = $this->game_model->get_progress_bar($this->view_data['me']['exp']);
		$this->view_data['mySkills'] = $mySkills;
		$this->view_data['percision'] = $percision;
		$this->view_data['works'] = $works;
		$this->view_data['window_title'] = "CodeArmy World";
		$this->load->view('missions_codearmy_view', $this->view_data);
	}
	
	function recommended_tallents($work_id){
		//$work_id = "044295";
		$this->view_data['page'] = 0;
		$this->view_data['num_per_page'] = 6;
		$this->view_data['work_id'] = $work_id;
		//Check if is po
		$user_id = $this->session->userdata('user_id');
		$work = $this->work_model->get_work($work_id);
		$work=$work->result_array();
		$work = $work[0];
		if($work['creator'] == $user_id || $work['owner'] == $user_id){
			$this->load->model('recom_model');
			$this->view_data['recoms'] = $this->recom_model->get_tallents($work_id);
			if($this->view_data['recoms'])
				$this->load->view('recom_tal_codearmy_view', $this->view_data);
			//else redirect('/missions/hq');
			else echo "<script type=\"text/javascript\">parent.$.fancybox.close();</script>";
		}else{
			die('Error: Either you might be logged out or you are not creator of this job');
		}
	}
	
	function mission_confirmation($work_id){
		$user_id = $this->session->userdata('user_id');
		$preview = $this->work_model->previewMission($work_id, $user_id);
		//if(count($preview)!=1)die('die hcker!');
		$this->view_data['preview'] = $preview[0];
		
		$preview_skills = $this->work_model->previewSkills($work_id);
		$this->view_data['preview_skills'] = $preview_skills;
		
		$preview_files = $this->work_model->previewFiles($work_id);
		$this->view_data['preview_files'] = $preview_files;
		
		$type = $preview[0]['est_arrangement'];
		if($type != ""){
			$arrangement = $this->work_model->get_selected_arrangement_type($type);
			$this->view_data['arrangement'] = $arrangement[0];
			
			$time = $preview[0]['est_time_frame'];
			$duration = $this->work_model->get_selected_arrangement_time($time);
			$this->view_data['duration'] = $duration[0];
			
			$budget = $preview[0]['est_budget'];
			$budget = $this->work_model->get_selected_arrangement_budget($budget);
			$this->view_data['budget'] = $budget[0];
		} else {
			$this->view_data['arrangement'] = "";
			$this->view_data['duration'] = "";
			$this->view_data['budget'] = "";
		}
		
		$this->view_data['window_title'] = "CodeArmy World";
		$this->load->view('confirm_mission_codearmy_view', $this->view_data);
	}
	
	function mission_list($lat,$lng){
		$this->load->helper('text');
		$this->view_data['works'] = $this->stories->list_stories_map($this->percision,$lat,$lng);
		$this->view_data['window_title'] = "CodeArmy World";
		$this->load->view('mission_list_codearmy_view', $this->view_data);
	}
	
	function create_complete(){
		$user_id = $this->view_data['me']['user_id'];
		$work_id = $this->input->post('work_id');
		$work = $this->work_model->get_work($work_id)->result_array();
		$res = array(
			"status" => 'open'
		);
		$res2 = array(
			'work_id'=>$work_id,
			'owner'=> $user_id,
			'creator' => $user_id
		);
		$this->db->update('works', $res, $res2);
		$event = 'create';
		$status = json_encode(array(
				'work_id' => $work_id));
		$desc = "created";
		$this->work_model->log_history($user_id,$work_id,$event,$status,$desc);
		require_once(getcwd()."/application/helpers/pusher/Pusher.php");
		$pusher = new Pusher('deb0d323940b00c093ee', '9ab20336af22c4e7fa77', '25755');
		$data = array(
			'event' => 'new',
			'user_id' => $user_id,
			'username' => $this->view_data['me']['username'],
			'work_id' => $work_id,
			'work_title'=>$work[0]['title'],
			'lat' => round($work[0]['lat'],$this->percision),
			'lng' => round($work[0]['lng'],$this->percision),
			'time' => date('h:ia, d/m/Y'),
		);
		$pusher->trigger('map-channel', 'map-new', $data );
		if($this->db->affected_rows()==1){ echo 'success';}else{echo 'Error: can not complete creation of the mission.';}
	}
	
	function create($cat=''){
		$this->session->sess_update();
		$this->view_data['cat_selected'] = $cat;
		$this->view_data['main_category'] = $this->work_model->get_main_category();
		$this->view_data['class'] = $this->work_model->get_main_class($cat);
		$this->view_data['sub_class'] = $this->work_model->get_sub_class($cat,'');
		$this->view_data['arrangement_type'] = $this->work_model->get_arrangement_type();

		$this->view_data['skills'] = $this->skill_model->get_filter_skill();
		$this->view_data['skillsonly'] = $this->skill_model->get_all_skills();

		$this->view_data['window_title'] = "Mission Create";
		$this->load->view('create_mission_codearmy_view', $this->view_data);
	}
	
	function check_create_mission(){
		$user_id = $this->view_data['me']['user_id'];
		$this->load->helper('htmlpurifier');
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
			"title" => html_purify($this->input->post('mission_title')),
			"sprint" => 0,
			"class" => ($this->input->post('mission_type_class')==0)?NULL:$this->input->post('mission_type_class'),
			"subclass" => ($this->input->post('mission_type_subclass')==0)?NULL:$this->input->post('mission_type_subclass'),
			"category" => $this->input->post('mission_type_main'),
			"description" => html_purify($this->input->post('mission_desc')),
			"points" => 0,
			"cost" => $this->calc_cost($this->input->post('mission_arrange_type'),$this->input->post('mission_arrange_duration'),$this->input->post('mission_budget')),
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
			"tutorial" => html_purify($this->input->post('mission_video')),
			"attach" => NULL,
			"lat" => $lat,
			"lng" => $lng,
			"est_arrangement" => $this->input->post('mission_arrange_type'),
			"est_time_frame" => $this->input->post('mission_arrange_duration'),
			"est_budget" => $this->input->post('mission_budget')
		);
		if($this->db->insert('works', $res)) {
			echo $work_id;
			
			$res = array(
				"work_id" => $work_id,
				"session_id" => ''
			);
			$res2 = array(
				"session_id" => $this->session->userdata('session_id')
			);
			$this->db->update('work_files', $res, $res2);
			
			if($this->input->post('mission_skills') != ""){
				$skills = $this->input->post('mission_skills');
				$skills_array = explode(",", $skills);
				foreach($skills_array as $value){
					$skills_res = $this->work_model->store_skill_model($value);
					
					$level_res = $this->work_model->store_level_model($value);
					
					if (count($skills_res)>0){
						if(count($level_res)==0){
							$res = array(
								"work_id" => $work_id,
								"skill_id" => $skills_res[0]['id'],
								"skill_level" => 1,
								"point" => 1
							);
						} else {
							$res = array(
								"work_id" => $work_id,
								"skill_id" => $skills_res[0]['id'],
								"skill_level" => $level_res[0]['id'],
								"point" => $level_res[0]['skill_point']
							);
						}
						$this->db->insert('work_skill', $res);
					}
					
				}
			}
		} else {
			//return false;
			echo "error";
		}
	}
	
	function check_edit_mission(){
		$user_id = $this->view_data['me']['user_id'];
		$this->load->helper('htmlpurifier');
		$work_id = $this->input->post('work_id');
		$info = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
		$lat = $info['geoplugin_latitude'];
		$lng = $info['geoplugin_longitude'];
		$res = array(
			"title" => html_purify($this->input->post('mission_title')),
			"sprint" => 0,
			"class" => ($this->input->post('mission_type_class')==0)?NULL:$this->input->post('mission_type_class'),
			"subclass" => ($this->input->post('mission_type_subclass')==0)?NULL:$this->input->post('mission_type_subclass'),
			"category" => $this->input->post('mission_type_main'),
			"description" => html_purify($this->input->post('mission_desc')),
			"points" => 0,
			"cost" => $this->calc_cost($this->input->post('mission_arrange_type'),$this->input->post('mission_arrange_duration'),$this->input->post('mission_budget')),
			"creator" => $user_id,
			"owner" => $user_id,
			"project_id" => NULL,
			"created_at" => date('Y-m-d H:i:s'),
			"work_horse" => NULL,
			"bid_deadline" => NULL,
			"deadline" => NULL,
			"assigned_at" => NULL,
			"done_at" => NULL,
			"tutorial" => $this->input->post('mission_video'),
			"attach" => NULL,
			"lat" => $lat,
			"lng" => $lng,
			"est_arrangement" => $this->input->post('mission_arrange_type'),
			"est_time_frame" => $this->input->post('mission_arrange_duration'),
			"est_budget" => $this->input->post('mission_budget')
		);
		if($this->db->update('works', $res, array("work_id" => $work_id))) {
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
			
			if($this->input->post('mission_skills') != ""){
				$this->db->delete('work_skill', array("work_id" => $work_id));
				$skills = $this->input->post('mission_skills');
				$skills_array = explode(",", $skills);
				foreach($skills_array as $value){
					$skills_res = $this->work_model->store_skill_model($value);
					
					$level_res = $this->work_model->store_level_model($value);
					
					if (count($skills_res)>0){
						if(count($level_res)==0){
							$res = array(
								"work_id" => $work_id,
								"skill_id" => $skills_res[0]['id'],
								"skill_level" => 1,
								"point" => 1
							);
						} else {
							$res = array(
								"work_id" => $work_id,
								"skill_id" => $skills_res[0]['id'],
								"skill_level" => $level_res[0]['id'],
								"point" => $level_res[0]['skill_point']
							);
						}
						$this->db->insert('work_skill', $res);
					}
					
				}
			}
			//echo "success";
			$status = json_encode(array(
				'work_id' => $work_id));
			$desc = "Updated";
			$this->work_model->log_history($user_id,$work_id,'update',$status,$desc);
		} else {
			//return false;
			echo "error";
		}
	}
	
	function edit_mission($work_id){
		$user_id = $this->session->userdata('user_id');
		$preview = $this->work_model->previewMission($work_id, $user_id);
		$this->view_data['preview'] = $preview[0];
		$this->view_data['work_id'] = $work_id;
		
		$preview_skills = $this->work_model->previewSkills($work_id);
		$this->view_data['preview_skills'] = $preview_skills;
		
		$preview_files = $this->work_model->previewFiles($work_id);
		$this->view_data['preview_files'] = $preview_files;
		
		$this->view_data['main_category'] = $this->work_model->get_main_category();
		$this->view_data['class'] = $this->work_model->get_main_class();
		$this->view_data['sub_class'] = $this->work_model->get_sub_class();
		
		$this->view_data['arrangement_type'] = $this->work_model->get_arrangement_type();
		$type = $preview[0]['est_arrangement'];
		$this->view_data['arrangement_duration'] = $this->work_model->get_duration($type);
		$this->view_data['arrangement_budget'] = $this->work_model->get_budget($type);
		
		$this->view_data['skills'] = $this->skill_model->get_filter_skill();
		$this->view_data['skillsonly'] = $this->skill_model->get_all_skills();
		
		$this->view_data['window_title'] = "CodeArmy World";
		$this->load->view('edit_mission_codearmy_view', $this->view_data);
	}
	
	function ajax_delete_file(){
		$user_id = $this->view_data['me']['user_id'];
		$work_id = $this->input->post('work_id');
		$file_id = $this->input->post('file_id');
		$session_id = $this->session->userdata('session_id');
		
		$get_file = $this->work_model->check_file($file_id, $work_id, $session_id);
		$getfile = $get_file[0];
		if($getfile != ""){
			unlink('public/uploads/'.$getfile["file_name"]);
			$this->db->delete('work_files', array("file_id" => $file_id));
			echo "success";
		} else {
			echo "error";
		}
	}
	
	public function calc_cost($type,$timeline,$budget){
		if($type!="" || $type !=0){
			$type = $this->work_model->get_selected_arrangement_type($type);
			$duration = $this->work_model->get_selected_arrangement_time($timeline);
			$budget = $this->work_model->get_selected_arrangement_budget($budget);
			
			$type = $type[0]['type'];
			$timeline = $duration[0]['time_cal'];
			$budget = $budget[0]['amount_cal'];
					
			$cost = $timeline*$budget;
		} else {
			$cost=0;
		}
		return $cost;
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
							"file_size" => $this->input->post('filesize'),
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
						"file_size" => $this->input->post('filesize'),
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
		die('{"jsonrpc" : "2.0", "result" : "success", "id" : "'.$file_id.'"}');
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
	
	function ajax_tallent_map_search(){
		$percision = 0;
		$search = trim($this->input->post('search'));
		$type = $this->input->post('type');
		if($search == 'all'|| (!$search)){
			switch($type){
				case 'po': $works = $this->users_model->tallents_map_po($percision);break;
				case 'allusers': $works = $this->users_model->tallents_map_all($percision);break;
				case 'classification': $works = $this->users_model->tallents_map_division($percision);break;
				case 'skills': $works = $this->users_model->tallents_map_skill($percision);break;
				default: $works = $this->users_model->tallents_map($percision);break;
			}
		}else{
			switch($type){
				case 'po': $works = $this->users_model->tallents_map_search_po($percision, $search);break;
				case 'allusers': $works = $this->users_model->tallents_map_search_all($percision, $search);break;
				case 'classification': $works = $this->users_model->tallents_map_search_division($percision, $search);break;
				case 'skills': $works = $this->users_model->tallents_map_search_skill($percision, $search);break;
				default: $works = $this->users_model->tallents_map_search_contactors($percision, $search);break;
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
	
	function my_missions($status='All'){
		$this->view_data['status'] = $status;
		$user_id = $this->view_data['me']['user_id'];
		$this->view_data['myPendingList'] = $this->work_model->get_pending_works($user_id)->result_array();
		$this->view_data['myWorkList'] = $this->work_model->get_my_works($user_id, 'active')->result_array();
		if($status=='Pending')$status = array('assigned','open','done','verify','reject');
		if($status=='In_Progress')$status = 'in progress';
		$this->view_data['myMissions'] = $this->work_model->get_owner_works($user_id,$status);
		$this->view_data['window_title'] = "My Missions";
		$this->load->view('mymissions_codearmy_view', $this->view_data);
	}
	
	function bid(){
		$user_id = $this->view_data['me']['user_id'];
		$this->view_data['bids'] = $this->work_model->get_my_bids($user_id);
		$this->view_data['troops'] = $this->work_model->list_troopers($user_id);
		$this->view_data['window_title'] = "Mission Bid";
		$this->load->view('mybids_codearmy_view', $this->view_data);
	}
	
	function completed(){
		$user_id = $this->view_data['me']['user_id'];
		if($this->view_data['me']['role']=='po' || $this->view_data['me']['role']=='admin'){
			$missions = $this->work_model->po_completed($user_id);
		}else{
			$missions = $this->work_model->contractor_completed($user_id);
		}
		$this->view_data['missions'] = $missions;
		$this->view_data['window_title'] = "Missions Completed";
		$this->load->view('completed_codearmy_view', $this->view_data);
	}
	
	function wall($work_id){
		//only po and workhorse can access this page:
		$user_id = $this->view_data['me']['user_id'];
		$po = $this->work_model->is_po($user_id,$work_id);
		$wh = $this->work_model->is_workhorse($user_id,$work_id);
		if(!$po&&!$wh)die('Unauthorised access!');
		$this->view_data['work'] = $this->work_model->get_detail_work($work_id)->result_array();
		if(count($this->view_data['work'])!=1)die('This job is not assigned through bidding process.');
		$this->view_data['work'] = $this->view_data['work'][0];
		if(!in_array(strtolower($this->view_data['work']['status']),array('in prgress','done','redo','verify','signoff')))redirect('/missions/my_missions');
		$this->view_data['po'] = $this->users_model->get_user($this->view_data['work']['owner'])->result_array();
		$this->view_data['po'] = $this->view_data['po'][0];
		$this->view_data['contractor'] = $this->users_model->get_user($this->view_data['work']['work_horse'])->result_array();
		if(count($this->view_data['contractor'])>0) $this->view_data['contractor'] = $this->view_data['contractor'][0];
		$this->view_data['activities'] = $this->work_model->get_recent_activities($work_id);
		$this->view_data['comments'] = $this->work_model->get_comments($work_id);
		//delete wall notification for user
		$this->work_model->clear_notifications($work_id, $user_id, 'wall');
		$this->view_data['window_title'] = "Wall";
		$this->load->view('wall_codearmy_view', $this->view_data);
	}
	
	//Tasks Page for PO
	function task($work_id){
		//only po and workhorse can access this page:
		$user_id = $this->view_data['me']['user_id'];
		$po = $this->work_model->is_po($user_id,$work_id);
		$wh = $this->work_model->is_workhorse($user_id,$work_id);
		if(!$po&&!$wh)die('Unauthorised access!');
		$this->view_data['work'] = $this->work_model->get_detail_work($work_id)->result_array();
		$this->view_data['work'] = $this->view_data['work'][0];
		if(!in_array(strtolower($this->view_data['work']['status']),array('in prgress','done','redo','verify','signoff')))redirect('/missions/my_missions');
		$this->view_data['po'] = $this->users_model->get_user($this->view_data['work']['owner'])->result_array();
		$this->view_data['po'] = $this->view_data['po'][0];
		$this->view_data['mission_task'] = $this->work_model->get_mission_task($work_id)->result_array();
		//delete wall notification for user
		$this->work_model->clear_notifications($work_id, $user_id, 'tasks');
		$this->view_data['window_title'] = "Task";
		$this->load->view('task_codearmy_view', $this->view_data);
		
	}
	
	//Documents Page for PO
	function documents($work_id){
		//only po and workhorse can access this page:
		$user_id = $this->view_data['me']['user_id'];
		$po = $this->work_model->is_po($user_id,$work_id);
		$wh = $this->work_model->is_workhorse($user_id,$work_id);
		if(!$po&&!$wh)die('Unauthorised access!');
		$this->view_data['work'] = $this->work_model->get_detail_work($work_id)->result_array();
		$this->view_data['work'] = $this->view_data['work'][0];
		if(!in_array(strtolower($this->view_data['work']['status']),array('in prgress','done','redo','verify','signoff')))redirect('/missions/my_missions');
		$this->view_data['po'] = $this->users_model->get_user($this->view_data['work']['owner'])->result_array();
		$this->view_data['po'] = $this->view_data['po'][0];
		$docList = $this->work_model->getDocList($work_id);
		$this->view_data['docList'] = $docList;
		//delete wall notification for user
		$this->work_model->clear_notifications($work_id, $user_id, 'documents');
		$this->view_data['window_title'] = "Documents";
		$this->load->view('documents_codearmy_view', $this->view_data);
		
	}
	
	//Date Page for PO
	function dates($work_id){
		//only po and workhorse can access this page:
		$user_id = $this->view_data['me']['user_id'];
		$po = $this->work_model->is_po($user_id,$work_id);
		$wh = $this->work_model->is_workhorse($user_id,$work_id);
		if(!$po&&!$wh)die('Unauthorised access!');
		$this->view_data['work'] = $this->work_model->get_detail_work($work_id)->result_array();
		$this->view_data['work'] = $this->view_data['work'][0];
		if(!in_array(strtolower($this->view_data['work']['status']),array('in prgress','done','redo','verify','signoff')))redirect('/missions/my_missions');
		$this->view_data['po'] = $this->users_model->get_user($this->view_data['work']['owner'])->result_array();
		$this->view_data['po'] = $this->view_data['po'][0];
		$this->view_data['dates'] = $this->work_model->get_all_calendar_events($work_id);
		$this->view_data['window_title'] = "Date";
		$this->load->view('date_codearmy_view', $this->view_data);
		
	}
	
	function applicants($work_id){
		//only po can access this page:
		$user_id = $this->view_data['me']['user_id'];
		$po = $this->work_model->is_po($user_id,$work_id);
		if(!$po)die('Unauthorised access!');

		$work = $this->work_model->get_work($work_id)->result_array();
		$this->view_data['work_id'] = $work_id;
		$this->view_data['arrangement'] = $this->work_model->get_work_arrangement($work_id);
		$this->view_data['work'] = $work[0];
		$this->view_data['bids'] = $this->work_model->get_bids($work_id);
		$this->view_data['invitations'] = $this->work_model->get_pending_invitations($work_id);
		$this->view_data['troops'] = $this->work_model->get_active_bids($work_id);
		$this->view_data['window_title'] = "Applicants for job ".$work[0]['title'];
		$this->load->view('applicants_codearmy_view',$this->view_data);
	}
	
	function recommendFrame($user_id){
		$me = $this->users_model->get_user($user_id,'user_id');
		$me = $me->result_array();
		$me = $me[0];
		$user_id = $me['user_id'];
		$userProfile = $this->users_model->get_profile($user_id);
		$userProfile = $userProfile->result_array();
		$userProfile = $userProfile[0];
		$this->view_data['user'] = $me;
		$this->view_data['user_profile'] = $userProfile;
		
		$this->view_data['myCountry'] = "";
		$countries = config_item('country_list');
		$contact = json_decode($userProfile["contact"]);
		if ($contact != ""){
			$myCountry = $contact->country;
			foreach($countries as $key=>$value) {
				if ($key == $myCountry){
					$this->view_data['myCountry'] = $value;
				}
			}
		}
		
		$completed = $this->users_model->works_compeleted($user_id);
		$this->view_data['completed'] = $completed;
		
		$this->view_data['myLevel'] = $this->game_model->get_level($me['exp']);
		$this->view_data['expProgress'] = $this->game_model->get_progress_bar($me['exp']);
		
		$mySkills = $this->skill_model->get_my_top5_skills($user_id);
		$this->view_data['mySkills'] = $mySkills;
		$myBadges = $this->skill_model->get_my_top8_badges($user_id);
		if(!$myBadges){$myBadges=NULL;}
		$this->view_data['myBadges'] = $myBadges;
		
		$this->load->view('recom_frame_codearmy_view',$this->view_data);
	}
	
	function getSkills(){
		$q = $this->input->post('searchword');
		//$q = $_REQUEST["searchword"];
		$q = str_replace("@","",$q);
		$q = str_replace(" ","%",$q);
		$skills = $this->skill_model->get_filter_skill($q);
		foreach($skills as $value):
			echo "<a href=\"#\" title=\"".$value["skills"]."\">".$value["skills"]."</a>";
		endforeach;
	}
	
	function Ajax_get_class(){
		$q = $this->input->post('category');
		$class = $this->work_model->get_main_class($q);
		echo json_encode($class);
	}
	
	function Ajax_get_subclass(){
		$q = $this->input->post('category');
		$q1 = $this->input->post('class');
		$subclass = $this->work_model->get_sub_class($q,$q1);
		echo json_encode($subclass);
	}
	
	function Ajax_get_duration(){
		$q = $this->input->post('type');
		$duration = $this->work_model->get_duration($q);
		echo json_encode($duration);
	}

	function Ajax_get_budget(){
		$q = $this->input->post('type');
		$budget = $this->work_model->get_budget($q);
		echo json_encode($budget);
	}
	
	function Ajax_send_invites(){
		$ids = $this->input->post('ids');
		$work_id = $this->input->post('work_id');
		
		//only po can access this page:
		$user_id = $this->view_data['me']['user_id'];
		$po = $this->work_model->is_po($user_id,$work_id);
		if(!$po)die('Unauthorised access!');
	
		$work = $this->work_model->get_work($work_id)->result_array();
		if(count($work)==1){
			//Send message
			$subject = "Invitation to mission";
			$msg = "You are invited to work on Mission '<a class='fancybox' href='/missions/apply/$work_id'>".$work[0]['title']."</a>'. You may <a class='fancybox' href='/missions/apply/$work_id'>click here to view mission details</a> and to apply/bid on the mission.";
			foreach($ids as $invited_user_id){
				$this->message_model->send_message($user_id,$invited_user_id,$subject,$msg);
			}
			//Log in history
			$status = json_encode(array(
				'work_id' => $work_id));
			$desc = "sent invitation to talents";
			$this->work_model->log_history($user_id,$work_id,'invite',$status,$desc);
			//Save in invite list
			$this->work_model->invite($user_id,$work_id);
			echo "success";
		}else{
			echo "error";
		}
	}
	
	function Ajax_comment(){
		$user_id = $this->session->userdata('user_id');
		$user = $this->view_data['me'];
		$message = htmlentities($this->input->post('message'));
		$attach = $this->input->post('attach');
		$work_id = $this->input->post('work_id');
		$work = $this->work_model->get_work($work_id)->result_array();
		$work = $work[0];
		$work_id = $work['work_id'];
		//only po and workhorse can access this page:
		$user_id = $this->view_data['me']['user_id'];
		$po = $this->work_model->is_po($user_id,$work_id);
		$wh = $this->work_model->is_workhorse($user_id,$work_id);
		if(!$po&&!$wh)die('Unauthorised access!');
		//only workhorse and po can comment
		if($work['work_horse']==$user_id || $work['owner']==$user_id || $work['creator']==$user_id){	
			//save comment in database 		
			$comment_id = $this->work_model->create_comment($work_id, $this->view_data['me']['username'], $message, $attach);
			
			//save this event in history
			$status = json_encode(array(
				'comment_id' => $comment_id,
				'work_id' => $work_id));
			$desc = "commented";
			$this->work_model->log_history($user_id,$work_id,'comment',$status,$desc,false);
			$event_id = $this->db->insert_id();
			
			//generate one time notification for other party in DB
			// insert notification
			if($po){
				$intReceiverID = $work['work_horse'];
			} else {
				$intReceiverID = $work['creator'];
			}
			$this->work_model->log_notifications($work_id, $intReceiverID, 'wall');
			
			//now push events
			require_once(getcwd()."/application/helpers/pusher/Pusher.php");
			$pusher = new Pusher('deb0d323940b00c093ee', '9ab20336af22c4e7fa77', '25755');
			
			//trigger event channel
			$data = array(
				'message' => $message,
				'user_id' => $user_id,
				'user_level' => $this->game_model->get_level($user['exp']),
				'username' => $user['username'],
				'work_id' => $work_id,
				'time' => date('j M Y H:i'),
				'comment_id' => $comment_id
			);
			$pusher->trigger('comments', 'new-comment-'.$work_id, $data );
			
			//trigger history channel
			$data = array(
				'user_id' => $user_id,
				'username' => $user['username'],
				'work_id' => $work_id,
				'work_title'=>$work['title'],
				'Desc' => $desc,
				'event' => 'comment',
				'time' => date('h:ia, d/m/Y'),
				'status' => $status,
				'event_id'=> $event_id
			);
			$pusher->trigger('history', 'new-activity-'.$work_id, $data );
			die('success');
		}
		die('error');
	}
	
	function Ajax_approve_bid(){
		$user_id = $this->view_data['me']['user_id'];
		$bid_id = $this->input->post('bid_id');
		$bid = $this->work_model->get_bid($bid_id);
		$bid = $this->work_model->get_bid($bid_id);
		if($this->work_model->approve_bid($bid_id)){
			//send message to tallent
			$subject = "Bid approved";
			$msg = "Your bid is approved. Harry up and pick up the mission.";
			$from = $user_id;
			$to = $bid[0]['user_id'];
			$this->message_model->send_message($from,$to,$subject,$msg);
			//push this event
			require_once(getcwd()."/application/helpers/pusher/Pusher.php");
			$bidpusher = new Pusher('deb0d323940b00c093ee', '9ab20336af22c4e7fa77', '25755');
			$data = array(
				'user_id' => $user_id,
				'username' => $this->view_data['me']['username'],
				'bidder_id' => $bid[0]['user_id'],
				'bid_id' => $bid_id,
			);
			$bidpusher->trigger('bid', 'accept-bid-'.$bid_id, $data );
			die($bid_id);
		}else die('error');
	}
	
	
	function Ajax_cancel_bid(){
		$user_id = $this->session->userdata('user_id');
		$bid_id = $this->input->post('bid_id');
		if($this->work_model->cancel_my_bid($bid_id, $user_id)){
			//push this event
			require_once(getcwd()."/application/helpers/pusher/Pusher.php");
			$bidpusher = new Pusher('deb0d323940b00c093ee', '9ab20336af22c4e7fa77', '25755');
			$data = array(
				'user_id' => $user_id,
				'username' => $this->view_data['me']['username'],
				'bid_id' => $bid_id,
			);
			$bidpusher->trigger('bid', 'cancel-bid-'.$bid_id, $data );
			echo "success";	
		}else echo "error removing bid ".$bid_id;
	}
	
	function Ajax_add_sub_task(){
		//only po and workhorse can access this page:
		$user_id = $this->view_data['me']['user_id'];
		$work_id = $this->input->post('work_id');
		$po = $this->work_model->is_po($user_id,$work_id);
		$wh = $this->work_model->is_workhorse($user_id,$work_id);
		if(!$po&&!$wh)die('Unauthorised access!');
			$work = $this->work_model->get_work($work_id)->result_array();
			$work = $work[0];
			if($po){
				$intReceiverID = $work['work_horse'];
			} else {
				$intReceiverID = $work['creator'];
			}
			$this->work_model->log_notifications($work_id, $intReceiverID, 'tasks');
		
		$sub_task = $this->input->post('sub_task');
		$res = array(
			"work_id" => $work_id,
			"user_id" => $user_id,
			"task_name" => $sub_task
		);
		if($this->db->insert('mission_task', $res)){
			// insert notification
			
			$insert_id = $this->db->insert_id();
			echo $insert_id;
		} else {
			echo "error";
		}
	}
	
	function Ajax_remove_bid(){
		//only po and workhorse can access this page:
		$bid_id = $this->input->post('bid_id');
		$bid = $this->work_model->get_bid($bid_id);
		$work_id = $bid[0]['work_id'];
		$user_id = $this->view_data['me']['user_id'];
		$po = $this->work_model->is_po($user_id,$work_id);
		$wh = $this->work_model->is_workhorse($user_id,$work_id);
		if(!$po&&!$wh)die('Unauthorised access!');
		
		//was user invited?
		$res = $this->work_model->invited_to_work($user_id,$work_id);
		if(count($res)){
			$this->work_model->updateInvite($res[0]['invite_id'],'rejected');
		}
		if($this->work_model->remove_bid($bid_id, $user_id)) echo "success";
		else echo "error removing bid ".$bid_id;
	}
	
	function Ajax_reject_bid(){
		$user_id = $this->session->userdata('user_id');
		$bid_id = $this->input->post('bid_id');
		$bid = $this->work_model->get_bid($bid_id);
		if($this->work_model->remove_bid($bid_id, $user_id)){
			$work = $this->work_model->get_work($bid[0]['work_id'])->result_array();
			//send message to tallent
			$subject = "Bid rejected";
			$msg = "Your bid on mission '".$work[0]['title']."' is rejected.";
			$to = $bid[0]['user_id'];
			$from = $user_id;
			$this->message_model->send_message($from,$to,$subject,$msg);
			//push this event
			require_once(getcwd()."/application/helpers/pusher/Pusher.php");
			$bidpusher = new Pusher('deb0d323940b00c093ee', '9ab20336af22c4e7fa77', '25755');
			$data = array(
				'user_id' => $user_id,
				'username' => $this->view_data['me']['username'],
				'bid_id' => $bid_id,
			);
			$bidpusher->trigger('bid', 'reject-bid-'.$bid_id, $data );
			echo $bid_id;	
		}else echo "error";
	}
	
	function Ajax_update_task_priority(){
		$task_id = $this->input->post('task_id');
		$task_priority = $this->input->post('task_priority');
		$res = array("task_priority" => $task_priority);
		$where = array("task_id" => $task_id);
		$this->db->update('mission_task', $res, $where);
	}
	
	function Ajax_update_task_hours(){
		$task_id = $this->input->post('task_id');
		$task_hours = $this->input->post('task_hours');
		$res = array("task_hours" => $task_hours);
		$where = array("task_id" => $task_id);
		$this->db->update('mission_task', $res, $where);
	}
	
	function Ajax_update_task_percent(){
		$task_id = $this->input->post('task_id');
		$task_percent = $this->input->post('task_percent');
		$res = array("task_percentage" => $task_percent);
		$where = array("task_id" => $task_id);
		$this->db->update('mission_task', $res, $where);
	}
	
	function Ajax_update_task_status(){
		$task_id = $this->input->post('task_id');
		$task_status = $this->input->post('task_status');
		$res = array("task_status" => $task_status);
		$where = array("task_id" => $task_id);
		$this->db->update('mission_task', $res, $where);
	}
	
	function Ajax_delete_task(){
		$task_id = $this->input->post('task_id');
		$where = array("task_id" => $task_id);
		if($this->db->delete('mission_task', $where)){
			echo $task_id;
		} else {
			echo "error";
		}
	}
	
	function doc_uploadfiles(){
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
							"file_size" => $this->input->post('filesize'),
							"username" => $this->view_data['me']['username'],
							"created_at" => date('Y-m-d H:i:s'),
							"work_id" => $this->input->post('work_id')
						);
						$this->db->insert('work_files', $res);
						
						$user_id = $this->view_data['me']['user_id'];
						$work_id = $this->input->post('work_id');
						$po = $this->work_model->is_po($user_id,$work_id);
						$wh = $this->work_model->is_workhorse($user_id,$work_id);
						$work = $this->work_model->get_work($work_id)->result_array();
						$work = $work[0];
						// insert notification
						if($po){
							$intReceiverID = $work['work_horse'];
						} else {
							$intReceiverID = $work['creator'];
						}
						$this->work_model->log_notifications($work_id, $intReceiverID, 'documents');
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
						"file_size" => $this->input->post('filesize'),
						"created_at" => date('Y-m-d H:i:s'),
						"session_id" => $this->session->userdata('session_id')
					);
					$this->db->insert('work_files', $res);
					
					$user_id = $this->view_data['me']['user_id'];
					$work_id = $this->input->post('work_id');
					$po = $this->work_model->is_po($user_id,$work_id);
					$wh = $this->work_model->is_workhorse($user_id,$work_id);
					$work = $this->work_model->get_work($work_id)->result_array();
					$work = $work[0];
					// insert notification
					if($po){
						$intReceiverID = $work['work_horse'];
					} else {
						$intReceiverID = $work['creator'];
					}
					$this->work_model->log_notifications($work_id, $intReceiverID, 'documents');
				} else
					die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
					
					fclose($in);
					fclose($out);
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}
		// Return JSON-RPC response
		die('{"jsonrpc" : "2.0", "result" : "success", "id" : "'.$file_id.'"}');
	}
	
	function delete_doc_file(){
		$file_id = $this->input->post('file_id');
		$work_id = $this->input->post('work_id');
		
		$get_file = $this->work_model->check_file($file_id, $work_id);
		$getfile = $get_file[0];
		if($getfile != ""){
			unlink('public/uploads/'.$getfile["file_name"]);
			$this->db->delete('work_files', array("file_id" => $file_id));
			echo "success";
		} else {
			echo "error";
		}
	}

	function delete_doc_link(){
		$link_id = $this->input->post('link_id');
		$work_id = $this->input->post('work_id');
		
		if($this->db->delete('work_links', array("link_id" => $link_id))){
			echo "success";
		} else {
			echo "error";
		}
	}
	
	function Ajax_save_link(){
		$work_id = $this->input->post('work_id');
		$link = $this->input->post('link');
		$user_id = $this->session->userdata('user_id');
		
		if($this->db->insert('work_links', array('work_id'=>$work_id, 'upload_by'=>$user_id, 'link'=>$link, 'username'=>$this->view_data['me']['username']))) echo "success";
		else echo "error";
	}
	
	function Ajax_accept_work(){
		$work_id = $this->input->post('work_id');
		$work = $this->work_model->get_work($work_id)->result_array();
		$user_id = $this->session->userdata('user_id');
		if($this->work_model->accept_work($user_id,$work_id)){
			//send message to po
			$subject = "Invitation to mission";
			$msg = "An approved proposal is accepted. For more information visit <a href='/missions/my_missions'>your my mission page</a>.";
			$from = $user_id;
			$to = $work[0]['owner'];
			$this->message_model->send_message($from,$to,$subject,$msg);
			//push this event
			require_once(getcwd()."/application/helpers/pusher/Pusher.php");
			$bidpusher = new Pusher('deb0d323940b00c093ee', '9ab20336af22c4e7fa77', '25755');
			$data = array(
				'user_id' => $user_id,
				'username' => $this->view_data['me']['username'],
				'work_id' => $work_id,
				'work_title' => $work[0]['title'],
				'time' => date('j M Y H:i')
			);
			$bidpusher->trigger('mission', 'accept-mission-'.$work_id, $data );
			echo $work_id;
		}else die('error');
	}
	
	function Ajax_reject_work(){
		$work_id = $this->input->post('work_id');
		$work = $this->work_model->get_work($work_id);
		$user_id = $this->session->userdata('user_id');
		
		if($this->work_model->decline_work($user_id,$work_id)){
			//send message to po
			$subject = "Invitation to mission";
			$msg = "An approved proposal just got declined. For more information visit <a href='/missions/bid'>mission>bids</a>.";
			$from = $user_id;
			$to = $work[0]['owner'];
			$this->message_model->send_message($from,$to,$subject,$msg);
			//push this event
			require_once(getcwd()."/application/helpers/pusher/Pusher.php");
			$bidpusher = new Pusher('deb0d323940b00c093ee', '9ab20336af22c4e7fa77', '25755');
			$data = array(
				'user_id' => $user_id,
				'username' => $this->view_data['me']['username'],
				'work_id' => $work_id,
			);
			$bidpusher->trigger('mission', 'decline-mission-'.$work_id, $data );
			echo $work_id;
		}else die('error');
	}
	
	function Ajax_add_calendar_event(){
		$user_id = $this->session->userdata('user_id');
		$work_id = $this->input->post('work_id');
		$eventname = $this->input->post('eventname');
		$startDateTime = $this->input->post('startDateTime');
		$endDateTime = $this->input->post('endDateTime');
		$data = array(
			'title' => $eventname,
			'startDate' => $startDateTime,
			'endDate' => $endDateTime,
			'work_id' => $work_id,
			'user_id' => $user_id
		);
		if($this->db->insert('calendar', $data)) echo "success";
		else echo "error";
	}
	
	function Ajax_udpate_calendar_event(){
		$eventname = $this->input->post('eventname');
		$startDateTime = $this->input->post('startDateTime');
		$endDateTime = $this->input->post('endDateTime');
		$calendar_id = $this->input->post('calendar_id');
		$data = array(
			'title' => $eventname,
			'startDate' => $startDateTime,
			'endDate' => $endDateTime
		);
		if($this->db->update('calendar', $data, array("calendar_id" => $calendar_id))) echo "success";
		else echo "error";
	}
	
	function Ajax_get_calendar_event(){
		$calendarID = $this->input->get('calendarID');
		$events = $this->work_model->get_calendar_event($calendarID);
		echo json_encode($events);
	}
	
	function Ajax_delete_calendar_event(){
		$calendarID = $this->input->post('calendarID');
		if($this->db->delete('calendar', array('calendar_id' => $calendarID))) echo "success";
		else echo "error";
	}
	
	function Ajax_remove_sample(){
		$user_id = $this->session->userdata('user_id');
		$res = array(
			"hidesample" => "true"
		);
		$res = json_encode($res);
		$doc = array(
			"params" => $res
		);
		$where = array("user_id" => $user_id);
		$this->db->update('user_profiles', $doc, $where);
	}
	
	function Ajax_remove_mission(){
		$user_id = $this->session->userdata('user_id');
		$work_id = $this->input->post('work_id');
		$work = $this->work_model->get_work($work_id)->result_array();
		if($work[0]['owner']==$user_id) $this->work_model->delete_work($work_id);
	}
	
	function Ajax_bid(){
		echo json_encode($this->bid_application());
	}
	
	private function bid_application(){
		$this->load->helper('htmlpurifier');
		$user_id = $this->session->userdata('user_id');
		$time = $this->input->post('time');
		$work_id = $this->input->post('work_id');
		$budget = $this->input->post('budget');
		$desc = html_purify($this->input->post('desc'));
		$arrangement = $this->work_model->get_work_arrangement($work_id);
		if(trim($desc)=="Ask a question or place your comment")$desc="";
		//save the bid in db
		$this->work_model->setBid($work_id,$user_id,$budget,$time,$desc);
		
		//save it in history
		$bid_id = $this->db->insert_id();
		$event='bid';
		$status = json_encode(array('bid_cost' => $budget,
			'bid_time' => $time,
			'bid_desc' => $desc,
			'work_id' => $work_id));
		$desc = "placed a bid";
		$this->work_model->log_history($user_id,$work_id,$event,$status,$desc);
		
		//push this event
		require_once(getcwd()."/application/helpers/pusher/Pusher.php");
		$bidpusher = new Pusher('deb0d323940b00c093ee', '9ab20336af22c4e7fa77', '25755');
		$data = array(
			'user_id' => $user_id,
			'user_level' => $this->game_model->get_level($this->view_data['me']['exp']),
			'username' => $this->view_data['me']['username'],
			'work_id' => $work_id,
			'time' => date('j M Y H:i'),
			'bid_id' => $bid_id,
			'bidget' => $budget,
			'time' => $time,
			'arrangement' => $arrangement
		);
		$bidpusher->trigger('bid', 'new-bid-'.$work_id, $data );
		
		//was user invited?
		$res = $this->work_model->invited_to_work($this->view_data['me']['user_id'],$work_id);
		if(count($res)){
			$this->work_model->updateInvite($res[0]['invite_id'],'accepted');
		}
		
		$res = array(
			'budget' => $budget,
			'time' => $time,
			'desc' => $desc,
			'username' => $this->view_data['me']['username'],
			'level' => $this->game_model->get_level($this->view_data['me']['exp']),
			'created_at' => date('Y-m-d H:i:s')
		);
		return $res;
	}
	
	function Ajax_myMissions(){
		$user_id = $this->session->userdata('user_id');
		$res = $this->work_model->get_owner_works($user_id,'All');
		echo json_encode($res);
	}
	
	function Ajax_completedMissions(){
		$user_id = $this->session->userdata('user_id');
		$res = $this->work_model->get_owner_works($user_id,'signoff');
		echo json_encode($res);
	}
}