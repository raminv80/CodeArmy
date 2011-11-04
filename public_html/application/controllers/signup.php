<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		
		$this->view_data['page_is'] = 'signup';
		
		$this->load->model('users_model');
		
		// a user that is already logged in can't signup a new account
		// redirect the user to dashboard
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
			redirect("/");
		}
	}
	
	// index page
	function index() {
		$this->view_data['window_title'] = "Signup page";
		$this->view_data['form_error'] = false;
		// - if signup from is pass, process and add into db
		if($this->input->post('submit')) {
			// verify user input
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', 'Username', 'required|alpha_dash|min_length[2]|max_length[30]|callback__check_username');
			$this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]|min_length[6]');
			$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|min_length[6]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback__check_email');
			if ($this->form_validation->run() == FALSE) {
				$this->view_data['form_error'] = true;
			} else {
				if($this->users_model->create_new_user()) {
					// signup successful
					$this->view_data['signup_success'] = true;
				} else { // - if there is a problem writing to db
					redirect(base_url()."error");
				} 
			}
		} 
		$this->load->view('signup_view', $this->view_data);
	}
	
	/*---------------------------------------------------------------*/
	
	// check for username duplication callback
	function _check_username($username) {
		if($this->users_model->get_user($username, 'username')) {
			$this->form_validation->set_message('_check_username', 'Username already registered');
			return false;
		} else { 
			return true; 
		}
	}
	
	// check for email duplication callback
	function _check_email($email) {
		if($this->users_model->get_user($email, 'email')) {
			$this->form_validation->set_message('_check_email', 'Email already registered');
			return false;
		} else { return true; }
	}
}