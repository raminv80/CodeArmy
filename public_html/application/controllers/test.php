<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {
	function __construct() {
		parent::__construct();
		//$this->load->model('users_model');
		
		$this->view_data['page_is'] = 'Test';
		
		// - check to verify if user is login...
		$check_login = $this->session->userdata('is_logged_in');
		$controller = $this->uri->segment(1);
		$action = $this->uri->segment(2);
		$param = $this->uri->segment(3);
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
		}else{
			$referer = $controller;
			if($action)$referer .= '/'.$action;
			if($param)$referer .= "/".$param;
			$this->session->set_userdata('referer', $referer); 
			redirect("login");
		}
	}
	
	// index page
	function index() {
		$this->view_data['window_title'] = 'Terms & Conditions';
		$this->load->view('terms_view', $this->view_data);
	}
	
	function scrumboard(){
		$this->view_data['window_title'] = 'Scrumboard';
		$this->load->view('scrumboard_view', $this->view_data);
	}
}