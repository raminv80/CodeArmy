<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('inbox_model');
		
		// a user that is already logged in can't signup a new account
		// redirect the user to dashboard
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
			redirect("/");
		}
	}
	
	public function start(){
		//to do
		$this->inbo_model->getNum_notification($this->session->userdata('username'));
	}
}