<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('users_model');
		$this->view_data['page_is'] = 'login';
	}
	
	// index page
	function index() {
		$data['main_content'] = 'login_form';
		$this->load->view('login_view', $data);
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
				'is_logged_in' => true
			);
			$this->session->set_userdata($data);
			$this->users_model->update_last_login($query_data[0]['user_id']);
			redirect('home');
		}
		else { // incorrect username or password
			$this->view_data['login_error'] = true;
			$this->load->view('login_view', $this->view_data);
		}
	}	
	
	function logout() {
		$this->session->sess_destroy();
		redirect('home');
	}
}