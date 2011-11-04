<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('projects_model');
		
		$this->view_data['page_is'] = 'project';
		
		// - check to verify if user is login...
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
			$this->view_data['user_role'] = $this->session->userdata('role');
		}
	}
	
	// index page
	function show($id) {
		$qry = $this->projects_model->get_project_details($id);
		if($qry->num_rows>0){
			$qry = $qry->result_array();
			$this->view_data['project'] = $qry[0];
			$this->view_data['window_title'] = 'Workpad :: '.$this->view_data['project']['project_name'];
			$this->load->view('project_show_view', $this->view_data);
		}
	}
}