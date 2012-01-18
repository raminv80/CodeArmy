<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Works extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('projects_model');
		$this->load->model('users_model');
		$this->load->model('stories_model', 'stories');
		
		$this->view_data['page_is'] = 'works';
		
		// - check to verify if user is login...
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
		}
		$this->load->model('stories_model', 'stories');
	}
	
	// index page
	function index() {
		$this->view_data['inProgress_empty'] = false;
		$this->view_data['done_empty'] = false;
		$this->view_data['signoff_empty'] = false;
		$user_id = $this->session->userdata('user_id');

		error_reporting(E_ALL);
		ini_set('display_errors',1);
		$query = $this->stories->get_my_works($user_id,'In progress');
		if($query->num_rows() > 0) {
			$this->view_data['work_list_inProgress'] = $query->result_array();
		}else{
			$this->view_data['inProgress_empty'] = true;
		}

		$query1 = $this->stories->get_my_works($user_id,'Done');
		if($query1->num_rows() > 0) {
			$this->view_data['work_list_done'] = $query1->result_array();
		}else{
			$this->view_data['done_empty'] = true;
		}
		$query2 = $this->stories->get_my_works($user_id,'Sign Off');
		if($query2->num_rows() > 0) {
			$this->view_data['work_list_signoff'] = $query2->result_array();
		} else {
			$this->view_data['signoff_empty'] = true;
		}
		
		$this->view_data['have_project'] = $this->users_model->have_project($user_id);
		$this->view_data['window_title'] = 'My Works';
		$this->load->view('works_view', $this->view_data);
	}
}