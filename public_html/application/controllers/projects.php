<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends CI_Controller {
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('projects_model');
		$this->load->model('stories_model', 'stories');
		
		$this->view_data['page_is'] = 'signup';
		
		// - check if user is logged in
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
		} else { // - if user not login, redirect to dashboard. 
			redirect("dashboard"); 
		}
	}
	
	private function check_authentication($role = NULL){
		if($role == NULL || $role == ''){
			if(!$this->session->userdata('is_logged_in')){
				redirect(login_error);
				return false;
			}
		}else{
			if($this->session->userdata('role')!=$role){
				redirect(role_error);
				return false;
			}
		}
		return true;
	}		
	
	function index() {
		$this->check_authentication('admin');
		$user_id = $this->session->userdata('user_id');
		$this->view_data['window_title'] = "Workpad :: Projects Created";
		
		//get projects created
		$q_projects = $this->projects_model->get_projects($user_id);
		if($q_projects->num_rows() > 0) {
			$this->view_data['projects'] = $q_projects->result_array();
		} 
		else {
			$this->view_data['error'] = "You did not have any projects created yet";
		}
		
		//show the page
		$this->load->view('projects_view', $this->view_data);

	}
	
	function view($project_id) {
		$this->check_authentication('admin');
		$user_id = $this->session->userdata('user_id');
		$this->view_data['window_title'] = "Workpad :: Project";
		$this->view_data['pro_id'] = $project_id;
		//$query = $this->projects_model->priority_sort()
		
		if($this->stories->check_owner($project_id, $user_id)->num_rows() > 0) {
			$this->view_data['create_button'] = true;
		}
		else {
			$this->view_data['create_button'] = false;
		}
		
		$q_worklist = $this->projects_model->get_worklists($project_id);
		if($q_worklist->num_rows() > 0) {
			$this->view_data['worklist'] = $q_worklist->result_array();
		} 
		
		$this->load->view('project_view', $this->view_data);
	}
	
	function priority() {
		$this->check_authentication('admin');
		$this->projects_model->save_priority();
		redirect("/projects/view/".$this->input->post('project_id'));
	}
	
	function create(){
		$this->check_authentication('admin');
		$user_id = $this->session->userdata('user_id');
		
		if($this->input->post('submit')) {
			$this->load->library('form_validation');

			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');
		
			if ($this->form_validation->run() == FALSE) {
				$this->view_data['form_error'] = true;
			} else {
				$project_id = $this->projects_model->create_project($this->session->userdata('user_id'));
				if($project_id != false) {
					// signup successful
					$this->view_data['success'] = true;
					$this->view_data['project_id'] = $project_id;
				} else { // - if there is a problem writing to db
					redirect(base_url()."error");
				}
			}
		}
		
		$this->view_data['window_title'] = "Workpad :: Create Project";
		$this->load->view('project_new_view', $this->view_data);
	}
	
	function delete(){
		$this->check_authentication('admin');
	}
	
	function edit($id){
		$this->check_authentication('admin');
		$this->view_data['window_title'] = "Workpad :: Edit Project";
		
		$query = $this->projects_model->get_project_details($id);
		$data = $query->result_array();
		//print_r($data);
		$this->view_data['project_data'] = $data[0];
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
								// signup successful
								$this->view_data['success'] = true;
								$this->view_data['project_id'] = $project_id;
							} //else { // - if there is a problem writing to db
								//redirect(base_url()."error");
							//}
						}
					}
		
		$this->load->view('project_edit_view', $this->view_data);		
	}

}