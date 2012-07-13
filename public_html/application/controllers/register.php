<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		
		$this->view_data['page_is'] = 'signup';
		$this->view_data['action_is'] = 'index';
		
		$this->load->model('projects_model');
		$this->load->model('users_model');
		$this->load->model('stories_model', 'stories');
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
		// a user that is already logged in can't signup a new account
		// redirect the user to dashboard
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
			//redirect("/");
		}
	}
	//****************************CodeArmy v1**********************************//
	function index(){
		if($this->session->userdata('username')){
			if(!$this->session->userdata('division')){
				$this->view_data['window_title'] = 'Register division';
				$this->load->view('register_devision_view', $this->view_data);
			}else{
				echo 'Error: Division already set.';	
			}
		}else{
			echo "Error: unauthorised access.";
		}
	}
	
	function designer(){
		if($this->session->userdata('username')){
			if(!$this->session->userdata('division')){
				$this->view_data['window_title'] = 'Prove your skill designer!';
				$this->load->view('register_designer_view', $this->view_data);
			}else{
				echo 'Error: Division already set.';	
			}
		}else{
			echo "Error: unauthorised access.";
		}
	}
	
	function developer(){
		if($this->session->userdata('username')){
			if(!$this->session->userdata('division')){
				$this->view_data['window_title'] = 'Prove your skill developer!';
				$this->load->view('register_developer_view', $this->view_data);
			}else{
				echo 'Error: Division already set.';	
			}
		}else{
			echo "Error: unauthorised access.";
		}
	}
	
	function copywriter(){
		if($this->session->userdata('username')){
			if(!$this->session->userdata('division')){
				$this->view_data['window_title'] = 'Prove your skill copywriter!';
				$this->load->view('register_copywriter_view', $this->view_data);
			}else{
				echo 'Error: Division already set.';
			}
		}else{
			echo "Error: unauthorised access.";
		}
	}
	
	function productowner(){
		$this->view_data['window_title'] = 'Authorised as CodeArmy General?';
		$this->load->view('register_productowner_view', $this->view_data);
	}
	
	function request_productowner(){
		$this->view_data['window_title'] = 'Wana be a CodeArmy General?';
		$this->load->view('register_request_productowner_view', $this->view_data);
	}
	
	function Ajax_voucher(){
		if($this->input->post('code')){
			$code = $this->input->post('code');
			$user_id = $this->session->userdata('user_id');
			if($this->projects_model->consume_voucher($code, $user_id)){
				$this->users_model->promote_to_po($user_id);
				$this->users_model->reg_division('employer');
				$res = 'You have successfully added project management capabilities to your profile.';
				echo 'success'.'~'.$res;
			}else{
				$res = 'Sorry, We couldn\'t verify your voucher number.';
				echo 'invalid'.'~'.$res;
			}
		}	
	}
	
	function Ajax_req_voucher(){
		if($this->input->post('email')){
			$from = $this->input->post('email');
			$to = admin_email;
			$subject = "Request for PO";
			$message = "<p>User '".$this->session->userdata('username')."' is requesting for product owner voucher code to upgrade his/her account to general.</p> <p>This allows him to create missions on system.</p>";
			$this->users_model->send_mail();
			$res="";
			echo 'success'.'~'.$res;
		}else{
			$res="";
			echo 'invalid'.'~'.$res;
		}
	}
	
	function Ajax_checkEmail(){
		if($this->input->post('email')){
			if($this->users_model->get_user($this->input->post('email'),'email')){
				echo 'taken';
			}else{
				echo 'success';
			}
		}
	}
	
	function Ajax_checkUsername(){
		if($this->input->post('username')){
			if($this->users_model->get_user($this->input->post('username'),'username')){
				echo 'taken';
			}else{
				echo 'success';
			}
		}
	}
	
	function Ajax_signup(){
		if($this->input->post('username')) {
			// verify user input
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback__check_email');
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			} else {
				$user_id = $this->users_model->create_new_user_codearmy();
				if($user_id) {
						// signup successful
						echo 'success';
				}
			}
		}
	}
	
	function Ajax_reg_div_designer(){
		if($this->users_model->reg_division('designer')){
			echo 'success';
		}
	}
	
	function Ajax_reg_div_developer(){
		if($this->users_model->reg_division('developer')){
			echo 'success';
		}
	}
	
	function Ajax_reg_div_copywriter(){
		if($this->users_model->reg_division('copywriter')){
			echo 'success';
		}
	}
	//****************************End of CodeArmy v1***************************//
	
}