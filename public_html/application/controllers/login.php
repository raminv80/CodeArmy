<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('projects_model');
		$this->load->model('users_model');
		$this->load->model('stories_model', 'stories');
		$this->view_data['page_is'] = 'login';
		$this->view_data['action_is'] = $this->uri->segment(2);
		
		$user_id = $this->session->userdata('user_id');
			if($user_id){
				$me = $this->users_model->get_user($user_id);
				if($me){
					$me = $me->result_array();
					$me = $me[0];
					$myProfile = $this->users_model->get_profile($user_id);
					$myProfile = $myProfile->result_array();
					$myProfile = $myProfile[0];
					$this->view_data['me'] = $me;
					$this->view_data['myProfile'] = $myProfile;
				}
			}
		// - check if user is logged in
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true && $this->uri->segment(2)!= 'Ajax_checkUser' && $this->uri->segment(2)!= 'Ajax_checkPass') {
			$this->view_data['username'] = $this->session->userdata('username');
			if(strtolower($this->uri->segment(2))!='logout')redirect("home"); 
		} else { // - if user not login, redirect to dashboard. 

		}	
	}
	
	// index page
	function index() {
		$this->view_data['main_content'] = 'login_form';
		$this->view_data['window_title'] = "Login to Workpad";
		$this->load->view('login_codearmy_view', $this->view_data);
	}	
	
	function validate_credentials() {
		$this->view_data['window_title'] = "Login to Worpad";
		$query = $this->users_model->validate();
		
		if($query != false) { // if the user's credentials validated...
			// get user details
			$query_data = $query->result_array();
			$data = array(
				'username' => $this->input->post('username'),
				'user_id' => $query_data[0]['user_id'],
				'role' => $query_data[0]['role'],
				'level' => $this->gamemech->get_level($query_data[0]['exp']),
				'tutorial' => $query_data[0]['show_tutorial'],
				'is_logged_in' => true
			);
			$this->session->set_userdata($data);
			//if first time login...
			if(!$query_data[0]['last_login'])
				$this->session->set_flashdata('bidding_tutorial',true);
			$this->users_model->update_last_login($query_data[0]['user_id']);
			if($this->session->userdata('referer')){
				redirect($this->session->userdata('referer'));
			}else{
				redirect('my-profile');
			}
		}
		else { // incorrect username or password
			$this->view_data['login_error'] = true;
			$this->view_data['window_title'] = "Login to Workpad";
			$this->load->view('login_view', $this->view_data);
		}
	}	
	
	function logout() {
		$this->users_model->reset_attempt($this->session->userdata("user_id"));
		$this->session->sess_destroy();		
		$cookie = array(
					'name'   => 'remember_me_token',
					'value'  => null,
					'expire' => '0',  // Two weeks
					'domain' => $_SERVER['HTTP_HOST'],
					'path'   => '/'
		);
		delete_cookie($cookie);
		redirect('home');
	}
	
	function recovery_old($code=""){
		if($this->input->post('submit')){
			$this->view_data['login_error'] = $this->users_model->reset_pass_notify($this->input->post('username'));	
		}else{
			if(isset($code) && $code!=""){
				$this->view_data['login_error'] = $this->users_model->reset_pass($code);	
			}
		}
		$this->view_data['window_title'] = "Reset my Password";
		$this->load->view('recovery_view', $this->view_data);
	}
	
	function recovery($code=""){
		if($this->input->post('email')){
			$this->view_data['login_error'] = $this->users_model->reset_pass_notify_codearmy($this->input->post('email'));	
		}else{
			if(isset($code) && $code!=""){
				$this->view_data['login_error'] = $this->users_model->reset_pass($code);	
			}
		}
		$this->view_data['window_title'] = "Reset my Password";
		$this->load->view('recovery_codearmy_view', $this->view_data);
	}
	
	function brush(){
		$this->view_data['window_title'] = "Brush my balls!";
		$this->load->view('brush_view', $this->view_data);
	}
	
	function Ajax_checkUser(){
		if($this->input->post('user')){
			$user = $this->input->post('user');
			$a = $this->users_model->get_user($user, 'email');
			$b = $this->users_model->get_user($user, 'username');
			if($a || $b)echo 'success';else echo 'invalid';
		}
	}
	
	function Ajax_checkPass(){
		if($this->input->post('password')){	
			$a = $this->users_model->validate();
			if($a)echo 'success';else echo 'invalid';
		}
	}
}