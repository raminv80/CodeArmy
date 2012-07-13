<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stories extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('skill_model');
		$this->load->model('projects_model');
		$this->load->model('users_model');
		$this->load->model('stories_model', 'stories');
		
		$this->view_data['page_is'] = 'stories';
		$this->view_data['action_is'] = 'browse';
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
			}
		// - check if user is logged in
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
		} else { // - if user not login, redirect to dashboard. 
			if(!in_array(strtolower($this->uri->segment(2)),array('browse','ajax_get_project_cat')))redirect("login"); 
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
						
						$this->view_data['window_title'] = "Create User Stories | Workpad";
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
					
					$this->view_data['window_title'] = "Create User Stories | Workpad";
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
	
	function Ajaxdoupload(){
		$uploadFile = uri_assoc('fld',2);
		$config['upload_path'] = './public/uploads/';
		//$config['allowed_types'] = 'gif|jpg|png';
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload($uploadFile)){
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('upload_form', $error);
		}else{
			$data = array('upload_data' => $this->upload->data());
			$this->load->view('upload_success');
		}
	}
	
	/*
	//version 2
	function browse(){
		//$project_sel, $cat_sel, $skill_sel, $cash_from, $cash_to, $point, $type, $status, $work_horse
		$project_sel = $this->input->post('project_sel');
		$cat_sel = $this->input->post('category_sel');
		$skill_sel = $this->input->post('skill_sel');
		$cash_from = $this->input->post('cash_from');
		$cash_to = $this->input->post('cash_to');
		$point = $this->input->post('point');
		$type = $this->input->post('type');
		$status = $this->input->post('status');
		$search = $this->input->post('search');
		$work_horse = $this->input->post('work_horse');
		if(!$project_sel)$project_sel=0;
		if(!$cat_sel)$cat_sel=0;
		if(!$skill_sel)$skill_sel=0;
		if(!$cash_from)$cash_from='';
		if(!$cash_to)$cash_to='';
		if(!$point)$point=0;
		if(!$type)$type=0;
		if(!$status)$status=0;
		if(!$work_horse)$work_horse='';
		if(!$search)$search='';
		$this->view_data['stories'] = 
			$this->stories->browse_stories($project_sel, $cat_sel, $skill_sel, $cash_from, $cash_to, $point, $type, $status, $work_horse, $search);
		$this->view_data['projects'] = $this->projects_model->get_all_projects();
		$this->view_data['categories'] = $this->projects_model->get_all_categories();
		$this->view_data['skills'] = $this->skill_model->get_all_skills();
		$this->view_data['page_is'] = 'Browse';
		$this->view_data['window_title'] = "Workpad :: Browse Jobs";
		$this->load->view('browse_view', $this->view_data);
	}*/
	
	//version 4
	function browse($subject=''){
		//$project_sel, $cat_sel, $skill_sel, $cash_from, $cash_to, $point, $type, $status, $work_horse
		$project_sel = $this->input->post('project_sel');
		$cat_sel = $this->input->post('category_sel');
		$skill_sel = $this->input->post('skill_sel');
		$cash_from = $this->input->post('cash_from');
		$cash_to = $this->input->post('cash_to');
		$point = $this->input->post('point');
		$type = $this->input->post('type');
		$status = $this->input->post('status');
		$search = $this->input->post('search');
		$time = $this->input->post('time');
		$work_horse = $this->input->post('work_horse');
		$order = $this->input->post('order');
		$this->view_data['inputs'] = array(
			'project_sel' => $this->input->post('project_sel'),
			'cat_sel' => $this->input->post('category_sel'),
			'skill_sel' => $this->input->post('skill_sel'),
			'cash_from' => $this->input->post('cash_from'),
			'cash_to' => $this->input->post('cash_to'),
			'point' => $this->input->post('point'),
			'type' => $this->input->post('type'),
			'status' => $this->input->post('status'),
			'search' => $this->input->post('search'),
			'time' => $this->input->post('time'),
			'work_horse' => $this->input->post('work_horse'),
			'order' => $this->input->post('order'),
		);
		if(!$project_sel)$project_sel=0;
		if(!$cat_sel)$cat_sel=0;
		if(!$skill_sel)$skill_sel=0;
		if(!$cash_from)$cash_from='';
		if(!$cash_to)$cash_to='';
		if(!$point)$point=0;
		if(!$type)$type=0;
		if(!$status)$status=0;
		if(!$work_horse)$work_horse='';
		if(!$search)$search='';
		if($search=='Type and press ENTER')$search='';
		if(!$time)$time=0;
		if(!$order)$order='';
		switch($time){
			case '0': $timeS=-1;$timeE=-1;break;
			case '1': $timeS=-1;$timeE=1;break;
			case '2': $timeS=1;$timeE=4;break;
			case '3': $timeS=4;$timeE=12;break;
			case '4': $timeS=12;$timeE=24;break;
			case '5': $timeS=24;$timeE=3*24;break;
			case '6': $timeS=3*24;$timeE=7*24;break;
			case '7': $timeS=7*24;$timeE=-1;break;
		}
		
		//ver4
		$this->view_data['featherlight'] = $this->stories->featherlight($type);
		$this->view_data['lightweight'] = $this->stories->lightweight($type);
		$this->view_data['heavyweight'] = $this->stories->heavyweight($type);
		$this->view_data['num_page']=6;
		$user_id = $this->session->userdata('user_id');
		if($user_id){
			$myProfile = $this->users_model->get_profile($user_id);
			$myProfile = $myProfile->result_array();
			$myProfile = $myProfile[0];
			$me = $this->users_model->get_user($user_id);
			$me = $me->result_array();
			$me = $me[0];
			$this->view_data['myProfile'] = $myProfile;
			$this->view_data['me'] = $me;
						
			$my_bids = array();
			$bids = $this->stories->get_user_bids($user_id);
			foreach ($bids as $bid) {
				array_push($my_bids, $bid['work_id']);
			}
			$this->view_data['my_bids'] = $my_bids;
		}
		//
		
		$this->view_data['stories'] = 
			$this->stories->browse_stories_v5($subject, $project_sel, $cat_sel, $type, $skill_sel, $cash_from, $cash_to, $point, $search, $timeS, $timeE, $order);
		$this->view_data['projects'] = $this->projects_model->get_all_projects();
		$this->view_data['categories'] = $this->projects_model->get_all_categories();
		$this->view_data['skills'] = $this->skill_model->get_all_skills();
		$this->view_data['page_is'] = 'Browse';
		$this->view_data['window_title'] = "Browse Jobs on Workpad";
		$this->load->view('browse_view_v4', $this->view_data);
	}
	
	function Ajax_get_project_cat(){
		$id = $this->input->post('id');
		$categories = $this->projects_model->get_categories($id);
		$categories = $categories->result_array();
		$c = count($categories);
		foreach($categories as $i=>$cat):
			echo $cat['id'];
			echo ';';
			echo $cat['name'];
			if($i<$c-1)echo '~';
		endforeach;
	}
}