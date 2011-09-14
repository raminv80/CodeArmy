<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stories extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('projects_model');
		$this->load->model('skill_model');
		
		$this->view_data['page_is'] = 'stories';
		
		// - check if user is logged in
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
		} else { // - if user not login, redirect to dashboard. 
			redirect("dashboard"); 
		}	
		$this->load->model('stories_model', 'stories');
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
	
	// - stories index page
	function index() {
		echo "stories index page";
	}
	
	
	// - add stories 
	function create($id="") {
		$user_id = $this->session->userdata('user_id');
		$this->load->library('formdate');
		$formdate_deadline = new FormDate();
		$formdate_deadline->config['prefix']="deadline_";
		$formdate_deadline->year['start'] = date('Y');
		$formdate_deadline->year['end'] = date('Y')+5;
		$this->view_data['formdate_deadline'] = $formdate_deadline;
		$formdate_biddead = new FormDate();
		$formdate_biddead->config['prefix']="biddead_";
		$formdate_biddead->year['start'] = date('Y');
		$formdate_biddead->year['end'] = date('Y')+5;		
		$this->view_data['formdate_biddead'] = $formdate_biddead;
		
		if($this->check_authentication('admin') == true) {
				$this->view_data['skills'] = $this->skill_model->get_all_skills();
				//check if there is argument
				if($id != "") {
					if($this->stories->check_owner($id, $user_id)->num_rows() > 0) {
						//echo $this->stories->check_owner($id, $user_id)->num_rows();
						$query4 = $this->stories->get_project_name($id);
						$this->view_data['project'] = $query4->result_array();
						$this->view_data['projects'] = "";
						$this->view_data['with_ajax'] = false;
						$data = $this->projects_model->get_categories($id);
						$data = $data->result_array();
						$this->view_data['categories'] = $data;
						if($this->input->post('submit')) {
							$this->load->library('form_validation');
		
							$this->form_validation->set_rules('title', 'Title', 'required');
							$this->form_validation->set_rules('type', 'Type', 'required');
							$this->form_validation->set_rules('description', 'Description', 'required');
							$this->form_validation->set_rules('points', 'Complexity Points', 'required');
							$this->form_validation->set_rules('cost', 'Cost', 'required');
							
							if ($this->form_validation->run() == FALSE) {
								$this->view_data['form_error'] = true;
							} else {
								$work_id = $this->stories->create_user_story($this->session->userdata('user_id'));
								if($work_id != false) {
									// signup successful
									$this->view_data['success'] = true;
									$this->view_data['work_id'] = $work_id;
								} else { // - if there is a problem writing to db
									redirect(base_url()."error");
								}
							}
						}
						
						$this->view_data['window_title'] = "Workpad :: Create User Stories";
						$this->load->view('stories_new_view', $this->view_data);
					
					}
					else {
						echo "Error";
					}
				}
				//else { echo "No argument"; }
			else {
				$this->view_data['with_ajax'] = true;
				$query1 = $this->projects_model->get_projects($user_id);
				$this->view_data['projects'] = $query1->result_array();
				$this->view_data['project'] = "";
				$this->view_data['categories'] = NULL;
				if($this->input->post('submit')) {
						$this->load->library('form_validation');

						$this->form_validation->set_rules('project', 'Project', 'required');
						$this->form_validation->set_rules('title', 'Title', 'required');
						$this->form_validation->set_rules('type', 'Type', 'required');
						$this->form_validation->set_rules('description', 'Description', 'required');
						$this->form_validation->set_rules('points', 'Complexity Points', 'required');
						$this->form_validation->set_rules('cost', 'Cost', 'required');
						
						if ($this->form_validation->run() == FALSE) {
							$this->view_data['form_error'] = true;
						} else {
							$work_id = $this->stories->create_user_story($this->session->userdata('user_id'));
							if($work_id != false) {
								// signup successful
								$this->view_data['success'] = true;
								$this->view_data['work_id'] = $work_id;
							} else { // - if there is a problem writing to db
								redirect(base_url()."error");
							}
						}
					}
					
					$this->view_data['window_title'] = "Workpad :: Create User Stories";
					$this->load->view('stories_new_view', $this->view_data);
			}
		}
	}
	
	function AjaxCategories(){
		$project_id = $this->input->post('project_id');
		print_r($project_id);
		$data = $this->projects_model->get_categories($project_id);
		$data = $data->result_array();
		
		$categories = $data;
		echo "<option value='0'>General</option>";
		foreach($categories as $category):
			echo "<option value='".$category['id']."'>".$category['name']."</option>";
		endforeach;
	}
}