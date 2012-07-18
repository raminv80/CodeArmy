<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PreController extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('stories_model', 'stories');
		$this->load->model('users_model');
	}
	
	public function start(){
		$check_login = $this->users_model->is_authorised();
		if($check_login == true) {
			$user_id = $this->session->userdata('user_id');
			$user_id = $this->session->set_userdata(array(
				'myActiveMissions' => $this->stories->get_num_my_works($user_id, 'in progress')
			));
			//$this->view_data['myNumWorkList'] = $this->stories->get_num_my_works($user_id, 'in progress');
		}
	}
}