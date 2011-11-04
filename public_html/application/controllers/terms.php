<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Terms extends CI_Controller {
	function __construct() {
		parent::__construct();
		//$this->load->model('users_model');
		
		$this->view_data['page_is'] = 'T&C';
		
		// - check to verify if user is login...
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
		}
	}
	
	// index page
	function index() {
		$this->view_data['window_title'] = 'Terms & Conditions';
		$this->load->view('terms_view', $this->view_data);
	}
}