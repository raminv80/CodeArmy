<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		
		$this->view_data['page_is'] = 'Admin';
		$this->view_data['action_is'] = $this->uri->segment(2);
		$controller = $this->uri->segment(1);
		$action = $this->uri->segment(2);
		$param = $this->uri->segment(3);
		$this->view_data['action_is'] = $action;
		
		$this->load->model('users_model');
		$this->load->model('projects_model');
		$this->load->model('stories_model', 'stories');
		
		$check_login = $this->session->userdata('role');
		if($check_login == 'admin') {
			$this->view_data['username'] = $this->session->userdata('username');
			$user_id = $this->session->userdata('user_id');
			if($user_id){
				$me = $this->users_model->get_user($user_id);
				$me = $me->result_array();
				$me = $me[0];
				$myProfile = $this->users_model->get_profile($user_id);
				$myProfile = $myProfile->result_array();
				$myProfile = $myProfile[0];
				$this->view_data['me'] = $me;
				$this->view_data['myProfile'] = $myProfile;
				$this->view_data['username'] = $this->session->userdata('username');
			}
		} else if(strpos($action, "AjaxTab")===false){ // - if user not login, redirect to dashboard.
			$referer = $controller;
			if($action)$referer .= '/'.$action;
			if($param)$referer .= "/".$param;
			$this->session->set_userdata('referer', $referer); 
			redirect("login"); 
		}
	}
	
	// index page
	function index($order=NULL) {
		//get projects created
		$q_projects = $this->projects_model->get_projects();
		$this->view_data['projects'] = $q_projects->result_array();
		$this->view_data['users'] = $this->users_model->get_all_users($order);
		$this->view_data['window_title'] = "Administration page";
		$this->load->view('admin_view', $this->view_data);
	}
	
	function promote($user_id){
		$this->users_model->promote($user_id);
		redirect('/admin/index/#user_'.$user_id);	
	}
	
	function demote($user_id){
		$this->users_model->demote($user_id);
		redirect('/admin/index/#user_'.$user_id);	
	}
	
	function new_project(){
		$user_id = $this->session->userdata('user_id');
		$this->load->library('ckeditor');
		$this->load->library('ckFinder');
		//configure base path of ckeditor folder 
		  $this->ckeditor->basePath = base_url().'public/scripts/ckeditor/';
		  $this->ckeditor-> config['toolbar'] = 'Full';
		  $this->ckeditor->config['language'] = 'en';
		  //configure ckfinder with ckeditor config 
		  $this->ckfinder->SetupCKEditor($this->ckeditor,'/public/js/ckfinder/');
		$this->view_data['users'] = $this->users_model->list_users();
		if($this->input->post('submit')) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');
			if ($this->form_validation->run() == FALSE) {
				$this->view_data['form_error'] = true;
			} else {
				$project_id = $this->projects_model->create_project($this->session->userdata('user_id'));
				if($project_id != false) {
					redirect('admin');
				} else { // - if there is a problem writing to db
					redirect(base_url()."error");
				}
			}
		}
		
		$this->view_data['window_title'] = "Create Project";
		$this->load->view('project_new_view', $this->view_data);	
	}
	
	function edit_project($id){
		$this->view_data['users'] = $this->users_model->list_users();
		$query = $this->projects_model->get_project_details($id);
		$data = $query->result_array();
		//print_r($data);
		$this->view_data['project_data'] = $data[0];
		$this->view_data['window_title'] = "Edit Project ".$data[0]['project_name'];
		$this->view_data['project_id'] = $id;
		$this->load->library('ckeditor');
        $this->load->library('ckFinder');
		//configure base path of ckeditor folder 
		  $this->ckeditor->basePath = base_url().'public/scripts/ckeditor/';
		  $this->ckeditor-> config['toolbar'] = 'Full';
		  $this->ckeditor->config['language'] = 'en';
		  //configure ckfinder with ckeditor config 
		  $this->ckfinder->SetupCKEditor($this->ckeditor,'/public/js/ckfinder/');
		if($this->input->post('submit')) {
			$this->load->library('form_validation');

			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');
		
			if ($this->form_validation->run() == FALSE) {
				$this->view_data['form_error'] = true;
			} else {
				$project_id = $this->projects_model->edit_project($id);
				if($project_id != false) {
					redirect('admin');
				} else { // - if there is a problem writing to db
					redirect(base_url()."error");
				}
			}
		}
		
		$this->load->view('project_edit_view', $this->view_data);	
	}
}