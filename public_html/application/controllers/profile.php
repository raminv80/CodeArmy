<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('skill_model');
		$this->load->model('stories_model','story');
		
		$this->view_data['page_is'] = 'signup';
		$controller = $this->uri->segment(1);
		$action = $this->uri->segment(2);
		$param = $this->uri->segment(3);
		// - check if user is logged in
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
		} else if(strpos($action, "AjaxTab")===false){ // - if user not login, redirect to dashboard.
			$referer = $controller;
			if($action)$referer .= '/'.$action;
			if($param)$referer .= "/".$param;
			$this->session->set_userdata('referer', $referer); 
			redirect("login"); 
		}
	}
	
	
	// - profile index function
	function index() {
	    $user_id = $this->session->userdata('user_id');
	    //$query = $this->users_model->get_user();
		$query = $this->users_model->get_profile($user_id);
		//print_r($query);
		$data = $query->result_array();
		$this->view_data['window_title'] = "Workpad :: user profile";
		//$this->view_data['user_id'] = $user_id;
		$this->view_data['profile'] = $data[0];
		$this->view_data['exp'] = $this->story->get_exp($user_id);
		$this->view_data['rank'] = $this->story->get_rank($user_id,true);
		$this->view_data['username'] = $this->session->userdata("username");
		$this->load->view('profile_view', $this->view_data);
	}
	
	function show($user_id){
		$query = $this->users_model->get_profile($user_id);
		$data = $query->result_array();
		$this->view_data['window_title'] = "Workpad :: user profile";
		$this->view_data['profile'] = $data[0];
		$this->view_data['exp'] = $this->story->get_exp($user_id);
		$this->view_data['rank'] = $this->story->get_rank($user_id,true);
		$this->view_data['stats'] = $this->story->get_stats($user_id);
		$this->view_data['badge'] = $this->story->get_rank_main_badge($user_id);
		$this->view_data['lightspeed_medal'] = $this->story->points_last_week($user_id)>=20;
		$this->view_data['strength'] = $this->story->points_inrow($user_id)>=40;
		$this->view_data['username'] = $this->session->userdata("username");
		$this->view_data['message'] = $this->session->flashdata('message');
		$this->load->view('show_profile_view', $this->view_data);
	}
	
	// - edit profile page
	function edit() {
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
		$this->view_data['window_title'] = "Workpad :: edit user profile";
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
		$this->view_data['window_title'] = "Workpad :: edit user password";
		
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
		$this->view_data['window_title'] = "Workpad :: Inbox";
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
		$this->view_data['window_title'] = "cashout";
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
	
}	