<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		error_reporting(E_ALL); 
 ini_set("display_errors", 1);
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('work_model');
		$this->load->model('skill_model');
		$this->load->model('projects_model');
		$this->load->model('stories_model', 'stories');
		
		$this->view_data['page_is'] = 'Profile';
		$this->view_data['action_is'] = $this->uri->segment(2);
		$controller = $this->uri->segment(1);
		$action = $this->uri->segment(2);
		$param = $this->uri->segment(3);
		$this->view_data['action_is'] = $action;
		// - check if user is logged in
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
			$this->view_data['username'] = $this->session->userdata('username');
			$this->view_data['myActiveMissions'] = $this->stories->get_num_my_works($user_id, 'in progress');
			$this->view_data['myActiveMessages'] = $this->message_model->num_unread($user_id);
			$this->view_data['myActiveNotifications'] = 0;
		} else if(strpos($action, "AjaxTab")===false){ // - if user not login, redirect to dashboard.
			$referer = $controller;
			if($action)$referer .= '/'.$action;
			if($param)$referer .= "/".$param;
			$this->session->set_userdata('referer', $referer); 
			redirect("login"); 
		}
	}
	
	
	function index(){
		//if user's designation is not set redirect him to job selection window
		$user_id = $this->session->userdata('user_id');
		
		$mySkills = $this->skill_model->get_my_skills($user_id);
		$this->view_data['mySkills'] = $mySkills;
		if($this->view_data['me']['role'] == 'po'){
			$this->view_data['spend'] = $this->work_model->get_po_spend($user_id);
			if(is_null($this->view_data['spend']))$this->view_data['spend']=0;
			$this->view_data['completed'] = $this->work_model->get_po_completed($user_id);
		}else{
			$myWorkBid = $this->users_model->works_bid($user_id);
			$this->view_data['myWorkBid'] = $myWorkBid;
			$myWorkCompleted = $this->users_model->works_compeleted($user_id);
			$this->view_data['myWorkCompleted'] = $myWorkCompleted;
		}
		$this->view_data['log'] = $this->users_model->get_history_log($user_id,3);
		$contact = json_decode($this->view_data['myProfile']["contact"]);
		$this->view_data['myCountry'] = "";
		$countries = config_item('country_list');
		if ($contact != ""){
			$myCountry = $contact->country;
			if($myCountry != ""){
				foreach($countries as $key=>$value) {
					if ($key == $myCountry){
						$this->view_data['myCountry'] = $value;
					}
				}
			} else {
				$this->view_data['myCountry'] = "";
			}
		}
		
		$myBadges = $this->skill_model->get_my_top8_badges($user_id);
		if(!$myBadges){$myBadges=NULL;}
		$this->view_data['myBadges'] = $myBadges;
		if(!in_array($this->view_data['myProfile']['specialization'],array('designer','developer','copywriter','employer','product owner','admin')))redirect("/register");
		//leaderboard
		//$leaderBoard = $this->users_model->leaderboard_points(5);
		$leaderBoard = $this->users_model->leaderboard_centered($user_id);
		$this->view_data['leaderBoard'] = $leaderBoard;
		$this->view_data['last_task'] = $this->users_model->last_task($user_id);
		$this->view_data['working_on'] = $this->users_model->working_on($user_id);
		$this->view_data['myLevel'] = $this->game_model->get_level($this->view_data['me']['exp']);
		$this->view_data['expProgress'] = $this->game_model->get_progress_bar($this->view_data['me']['exp']);
		$this->view_data['window_title'] = $this->session->userdata('username');
		$this->load->view('profile_codearmy_view', $this->view_data);
	}
	
	
	// - profile index function
	function index_old() {
	    /* ver1
		$user_id = $this->session->userdata('user_id');
	    //$query = $this->users_model->get_user();
		$query = $this->users_model->get_profile($user_id);
		//print_r($query);
		$data = $query->result_array();
		$this->view_data['window_title'] = "My Profile | Workpad";
		//$this->view_data['user_id'] = $user_id;
		$this->view_data['profile'] = $data[0];
		$this->view_data['exp'] = $this->stories->get_exp($user_id);
		$this->view_data['rank'] = $this->stories->get_rank($user_id,true);
		$this->view_data['username'] = $this->session->userdata("username");
		$this->load->view('profile_view', $this->view_data);
		*/
		
	}
	
	
	function show($username){
		$me = $this->users_model->get_user($username,'username');
		$me = $me->result_array();
		$me = $me[0];
		$user_id = $me['user_id'];
		$myProfile = $this->users_model->get_profile($user_id);
		$myProfile = $myProfile->result_array();
		$myProfile = $myProfile[0];
		$this->view_data['user'] = $me;
		$this->view_data['user_profile'] = $myProfile;
		
		$mySkills = $this->skill_model->get_my_top5_skills($user_id);
		$this->view_data['mySkills'] = $mySkills;
		$myWorkBid = $this->users_model->works_bid($user_id);
		$this->view_data['myWorkBid'] = $myWorkBid;
		$myWorkCompleted = $this->users_model->works_compeleted($user_id);
		$this->view_data['myWorkCompleted'] = $myWorkCompleted;
		$this->view_data['log'] = $this->users_model->get_history_log($user_id,3);
		$this->view_data['myCountry'] = "";
		$countries = config_item('country_list');
		$contact = json_decode($myProfile["contact"]);
		if ($contact != ""){
			$myCountry = $contact->country;
			foreach($countries as $key=>$value) {
				if ($key == $myCountry){
					$this->view_data['myCountry'] = $value;
				}
			}
		}
		
		$myBadges = $this->skill_model->get_my_top8_badges($user_id);
		if(!$myBadges){$myBadges=NULL;}
		$this->view_data['myBadges'] = $myBadges;
		//leaderboard
		$leaderBoard = $this->users_model->leaderboard_centered($user_id);
		$this->view_data['leaderBoard'] = $leaderBoard;
		$this->view_data['myLevel'] = $this->game_model->get_level($me['exp']);
		$this->view_data['expProgress'] = $this->game_model->get_progress_bar($me['exp']);
		$this->view_data['window_title'] = $me['username'];
		$this->load->view('show_profile_codearmy_view', $this->view_data);
	}
	
	function show_old($user_id){
		$query = $this->users_model->get_profile($user_id);
		$data = $query->result_array();
		$this->view_data['window_title'] = "User Profile | Workpad";
		$this->view_data['profile'] = $data[0];
		$this->view_data['exp'] = $this->stories->get_exp($user_id);
		$this->view_data['rank'] = $this->stories->get_rank($user_id,true);
		$this->view_data['stats'] = $this->stories->get_stats($user_id);
		$this->view_data['badge'] = $this->stories->get_rank_main_badge($user_id);
		$this->view_data['lightspeed_medal'] = $this->stories->points_last_week($user_id)>=20;
		$this->view_data['strength'] = $this->stories->points_inrow($user_id)>=40;
		$this->view_data['username'] = $this->session->userdata("username");
		$this->view_data['message'] = $this->session->flashdata('message');
		$this->load->view('show_profile_view', $this->view_data);
	}
	
	function hide_tutorial(){
		$this->session->set_userdata('tutorial',0);	
	}
	
	// - edit profile page
	function edit() {
		//CodeArmy V1
		$user_id = $this->session->userdata('user_id');
		
		$this->view_data['myLevel'] = $this->game_model->get_level($this->view_data['me']['exp']);
		$allSkills = $this->skill_model->get_all_skills();
		$this->view_data['allSkills'] = $allSkills;
		$mySkills = $this->skill_model->get_my_skills($user_id);
		$this->view_data['mySkills'] = $mySkills;
		$this->view_data['window_title'] = "Edit my Profile | CodeArmy";
		$this->load->view('profile_edit_codearmy_view', $this->view_data);
	}
	
	function edit_profile(){
		//CodeArmy v1
		$user_id = $this->session->userdata('user_id');
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[255]');
		
		if ($this->form_validation->run() == FALSE){
			$this->view_data['form_error'] = true;
			$this->edit();
		} else {
			$this->users_model->update_email($user_id);
			
			$this->form_validation->set_rules('country', 'Country');
			$this->form_validation->set_rules('status-msg', 'max_length[255]');
			$this->form_validation->set_rules('fullname', 'Fullname', 'max_length[60]');
			$this->form_validation->set_rules('address', 'Address');
			$this->form_validation->set_rules('phone', 'Phone');
			$this->form_validation->set_rules('birthday', 'Birthday');
			$this->form_validation->set_rules('skill1','Your Best Skill','required');
			$this->form_validation->set_rules('skill2','Second skill','required');
			$this->form_validation->set_rules('skill3','Third skill','required');
			$this->form_validation->set_rules('skype');
			$this->form_validation->set_rules('facebook');
			$this->form_validation->set_rules('twitter');
			$this->form_validation->set_rules('linkedin');
			$this->form_validation->set_rules('github-address');
			$this->form_validation->set_rules('portfolio-address');
			$this->form_validation->set_rules('blog-address');
			$this->form_validation->set_rules('extra1');
			$this->form_validation->set_rules('extraaddress1');
			$this->form_validation->set_rules('extra2');
			$this->form_validation->set_rules('extraaddress2');
			$this->form_validation->set_rules('paypal-email', 'Paypal Email', 'valid_email|max_length[255]');
			$this->form_validation->set_rules('bank-country', 'Country of Bank');
			$this->form_validation->set_rules('bank-name', 'Bank Name', 'max_length[40]');
			$this->form_validation->set_rules('bank-swift', 'SWIFT Code', 'max_length[40]');
			$this->form_validation->set_rules('bank-lastname', 'Last Name', 'max_length[255]');
			$this->form_validation->set_rules('bank-firstname', 'First Name', 'max_length[255]');
			$this->form_validation->set_rules('bank-accountno', 'Account Number', 'matches[bank-accountno2]');
			$this->form_validation->set_rules('bank-accountno2', 'Re-type Account Number');
			
			if ($this->form_validation->run() == FALSE){
				$this->view_data['form_error'] = true;
				$this->edit();
			} else {
				$this->users_model->update_profile($user_id);
				$this->skill_model->insert_skill($user_id);
				redirect("/profile");
			}
		}

		
		
		//if($this->users_model->update_email($user_id)) {
			//if($this->users_model->update_profile($user_id)) {
				//$this->session->set_flashdata('msg',"Your profie is updated.");
				//redirect (base_url()."profile/edit");
			//} else { // - if there is a problem writing to db
				
				//redirect(base_url()."profile/edit");
			//} 
		//} else { // - if there is a problem writing to db
			//$this->form_validation->set_message('required', '%s custom message here');
			//redirect(base_url()."profile/edit");
		//}
	}
	
	// - Workpad edit profile page
	function edit_old() {
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
		$this->load->helper('country_helper');
		$this->load->library('formdate');
		$user_id = $this->session->userdata('user_id');
		$query = $this->users_model->get_profile($user_id);
		$data = $query->result_array();
		$this->view_data['profile'] = $data[0];
		$formdate_deadline = new FormDate();
		$formdate_deadline->config['prefix']="birth_";
		$formdate_deadline->year['start'] = date('Y')-80;
		$formdate_deadline->year['end'] = date('Y')-7;
		$formdate_deadline->year['selected'] = date('Y',strtotime($this->view_data['profile']['birthdate']));
		$formdate_deadline->month['selected'] = date('m',strtotime($this->view_data['profile']['birthdate']));
		$formdate_deadline->day['selected'] = date('d',strtotime($this->view_data['profile']['birthdate']));
		$this->view_data['formdate_birth'] = $formdate_deadline;
		$this->view_data['window_title'] = "Edit my Profile | Workpad";
		$this->view_data['message'] = $this->session->flashdata('message');
		
		if($this->input->post('submit')) {
			//upload and resize the pic
			$avatar="";
			if($_FILES['user_avatar']['error'] == 0){
				//upload and update the file
				$config['upload_path'] = './public/images/profile';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['overwrite'] = false;
				$config['remove_spaces'] = true;
				$config['max_size']	= '2000';// in KB
				
				$this->load->library('upload', $config);
			
				if ( ! $this->upload->do_upload('user_avatar'))
				{
					$this->session->set_flashdata('message', $this->upload->display_errors('<p class="error">', '</p>'));
					redirect('profile/edit');
				}	
				else
				{
					//Image Resizing
					$config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 60;
					$config['height'] = 60;
			
					$this->load->library('image_lib', $config);
			
					if ( ! $this->image_lib->resize()){
						$this->session->set_flashdata('message', $this->image_lib->display_errors('<p class="error">', '</p>'));				
					}else{
						$avatar = $this->upload->file_name;
						//delete the old avatar pic
						if($this->view_data['profile']['avatar'])unlink('./public/'.$this->view_data['profile']['avatar']);
					}
					
					//$this->MUser->updateProfile($this->input->post('user_id'));
					//Need to update the session information if email was changed
					//$this->session->set_userdata('email', $this->input->xss_clean($this->input->post('user_email')));
					//$this->session->set_flashdata('message', '<p class="message">Your Profile has been Updated!</p>');
					//redirect('profile');
				}
			}

			if($this->users_model->update_profile($user_id,$avatar)) {
				$this->session->set_flashdata('msg',"Your profie is updated.");
				redirect (base_url()."profile/edit");
			} else { // - if there is a problem writing to db
				redirect(base_url()."error");
			} 
		
		}
		
		$this->load->view('profile_edit_view', $this->view_data);
	}
	
	function edit_password() {
		$this->view_data['window_title'] = "Edit Password";
		
		if($this->input->post('submit2')) {
				$this->load->library('form_validation');
				$this->form_validation->set_rules('o_pwd', 'Old Password', 'required|min_length[6]|callback__check_opwd');
				$this->form_validation->set_rules('n_pwd', 'New Password', 'required|min_length[6]|matches[r_pwd]');
				$this->form_validation->set_rules('r_pwd', 'Repeat Password', 'required|min_length[6]');
				if ($this->form_validation->run() == FALSE) {
					$this->view_data['form_error'] = true;
				} else {
					if($this->users_model->update_password($this->session->userdata('user_id'))) {
						$this->session->set_flashdata('msg',"Your password has changed.");
						redirect (base_url()."profile/edit_password");
					} else { // - if there is a problem writing to db
						redirect(base_url()."error");
					} 
				}
		}
		
		$this->load->view('profile_editpwd_view', $this->view_data);
	
	}
	
	function _check_opwd($opwd) {
	$query = $this->users_model->get_user($this->session->userdata('user_id'), 'user_id');
	$data = $query->result_array();
	$opwd = md5($opwd);
		if($opwd != $data[0]['secret']) {
			$this->form_validation->set_message('_check_opwd', 'Wrong Password');
			return false;
		} else { return true; }
	}
	
	function inbox(){
		$user_id = $this->session->userdata("username");
		$this->view_data['messages'] = $this->users_model->inbox_messages($user_id);
		$this->view_data['message_count'] = $this->users_model->inbox_count_unread($user_id);
		$this->view_data['window_title'] = "My Inbox | Workpad";
		$this->load->view('profile_inbox_view', $this->view_data);	
	}
	
	function cashout(){
		$user_id = $this->session->userdata('user_id');
		$me = $this->users_model->get_user($user_id);
		$me = $me->result_array();
		$me = $me[0];
		$myProfile = $this->users_model->get_profile($user_id);
		$myProfile = $myProfile->result_array();
		$myProfile = $myProfile[0];
		$this->view_data['me'] = $me;
		$this->view_data['myProfile'] = $myProfile;
		$this->view_data['window_title'] = "Cashout | Workpad";
		$this->load->view('cashout_view', $this->view_data);
	}
	
	function AjaxTab_tab_1(){
		//Summary Tab
		$user_id = $this->session->userdata('check_id');
		$me = $this->users_model->get_user($user_id);
		$me = $me->result_array();
		$me = $me[0];
		$myProfile = $this->users_model->get_profile($user_id);
		if($myProfile){
			$myProfile = $myProfile->result_array();
			$myProfile = $myProfile[0];
			$this->view_data['myProfile'] = $myProfile;
		}
		$this->view_data['me'] = $me;
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
		$this->load->view('Ajax_tab_1_alt', $this->view_data);	
	}
	
	function AjaxTab_tab_2(){
		//Achievement Tab
		$user_id = $this->session->userdata('check_id');
		$this->view_data['badges'] = $this->skill_model->get_my_badges($user_id);
		$this->load->view('Ajax_tab_2', $this->view_data);	
	}
	
	function AjaxTab_tab_7(){
		//Personal Info Tab
		$user_id = $this->session->userdata('check_id');
		$me = $this->users_model->get_user($user_id);
		$me = $me->result_array();
		$me = $me[0];
		$myProfile = $this->users_model->get_profile($user_id);
		$this->view_data['profile'] = NULL;
		if($myProfile){
			$myProfile = $myProfile->result_array();
			$myProfile = $myProfile[0];
			$this->view_data['profile'] = $myProfile;
		}
		$this->view_data['me'] = $me;
		$this->view_data['username'] = $this->session->userdata("username");
		$this->view_data['message'] = $this->session->flashdata('message');
		$this->view_data['works_completed'] = $this->users_model->works_compeleted($user_id);
		$this->view_data['hours_spent']  = $this->users_model->hours_spent($user_id);
		$this->view_data['hours_saved'] = $this->users_model->hours_saved($user_id);
		$this->load->view('Ajax_tab_7_alt', $this->view_data);	
	}
	
	//Hazwan's temporary page
	function prototype(){
		$this->load->view('prototype_demo', $this->view_data);	
	}

}	