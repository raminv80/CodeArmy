<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help extends CI_Controller {
	var $view_data = array();
	var $check_login =false;
	
	function __construct() {
		parent::__construct();
		//$this->load->model('users_model');
		
		$this->view_data['page_is'] = 'Help';
		
		// - check if user is logged in
		$check_login = $this->session->userdata('is_logged_in');
	}
	
	function index(){
		$this->view_data['window_title'] = 'Help';
		$this->load->view('help_view', $this->view_data);
	}
}