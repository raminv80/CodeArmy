<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('users_model');
		$this->view_data['page_is'] = 'login';
		$this->view_data['action_is'] = $this->uri->segment(2);
		// - check if user is logged in
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
			if(strtolower($this->uri->segment(2))!='logout')redirect("home"); 
		} else { // - if user not login, redirect to dashboard. 

		}	
	}
	
	// index page
	function index() {
		$this->view_data['main_content'] = 'login_form';
		$this->view_data['window_title'] = "Workpad :: Login";
		$this->load->view('login_view', $this->view_data);
	}	
	
	function validate_credentials() {
		$this->view_data['window_title'] = "Workpad :: Login";
		$query = $this->users_model->validate();
		
		if($query != false) { // if the user's credentials validated...
			// get user details
			$query_data = $query->result_array();
			$data = array(
				'username' => $this->input->post('username'),
				'user_id' => $query_data[0]['user_id'],
				'role' => $query_data[0]['role'],
				'level' => min(floor($query_data[0]['exp'] / points_per_level)+1, 99),
				'tutorial' => $query_data[0]['show_tutorial'],
				'is_logged_in' => true
			);
			$this->session->set_userdata($data);
			$this->users_model->update_last_login($query_data[0]['user_id']);
			if($this->session->userdata('referer')){
				redirect($this->session->userdata('referer'));
			}else{
				redirect('home');
			}
		}
		else { // incorrect username or password
			$this->view_data['login_error'] = true;
			$this->view_data['window_title'] = "Workpad :: Login";
			$this->load->view('login_view', $this->view_data);
		}
	}	
	
	function logout() {
		$this->session->sess_destroy();
		redirect('home');
	}
	
	function recovery($code=""){
		if($this->input->post('submit')){
			$this->view_data['login_error'] = $this->users_model->reset_pass_notify($this->input->post('username'));	
		}else{
			if(isset($code) && $code!=""){
				$this->view_data['login_error'] = $this->users_model->reset_pass($code);	
			}
		}
		$this->view_data['window_title'] = "Workpad :: Password Reset";
		$this->load->view('recovery_view', $this->view_data);
	}
}