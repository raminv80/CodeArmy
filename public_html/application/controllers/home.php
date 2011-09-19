<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('projects_model');
		$this->load->model('skill_model');
		$this->load->model('stories_model', 'stories');
		
		$this->view_data['page_is'] = 'Home';
		
		// - check if user is logged in
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
		} else { // - if user not login, redirect to dashboard. 
			//redirect("login"); 
		}	
	}
	
	function index(){
		$this->load->helper('stories_helper');
		$this->load->helper('user_helper');
		$user_id = $this->session->userdata('user_id');
        $project_sel = $this->session->userdata('project_sel'); if($project_sel==NULL) $project_sel = '';
		$category_sel = $this->session->userdata('category_sel'); if($category_sel==NULL) $category_sel = '';
		$story_sel = $this->session->userdata('story_sel'); if($story_sel==NULL) $story_sel = '';
		
		//populate filtering lists
		$this->view_data['projects'] = $this->stories->list_projects();
		if($project_sel=='') $project_sel = $this->view_data['projects'][0]['project_id'];
		$this->view_data['categories'] = $this->stories->list_categories($project_sel);
		$this->view_data['stories'] = $this->stories->list_stories($project_sel, $category_sel);
		
		$this->view_data['project_sel'] = $project_sel;
		$this->view_data['category_sel'] = $category_sel;
		$this->view_data['story_sel'] = $story_sel;
		
		$this->view_data['total_users'] = $this->users_model->getNumRegistration();
		$this->view_data['total_active'] = $this->users_model->getActiveUsers();
		$this->view_data['total_online'] = $this->users_model->getNumOnline();
		$this->view_data['total_visitors'] = $this->users_model->getVisitors();
		$this->view_data['total_contacts'] = $this->users_model->get_contacts();
		$this->view_data['total_projects_cur_month'] = $this->projects_model->num_projects_month();
		$this->view_data['leaderboard_project'] = $this->users_model->leaderboard_projects(3);
		$this->view_data['leaderboard_points'] = $this->users_model->leaderboard_points(3);
		$this->view_data['leaderboard_time'] = $this->users_model->leaderboard_time(3);
				
		$this->view_data['have_project'] = $this->users_model->have_project($user_id);	
		$this->view_data['window_title'] = "Workpad :: Home";
		$this->load->view('home_view', $this->view_data);
	}
	
	function AjaxProjectSel(){
		$project_id = $this->input->post('project_sel');
		$this->session->set_userdata('project_sel', $project_id);
		$category_id = '';//$this->session->userdata('category_sel');
		$this->view_data['categories'] = $this->stories->list_categories($project_id);
		$this->view_data['stories'] = $this->stories->list_stories($project_id, $category_id);
		$this->view_data['project_sel'] = $project_id;
		$this->view_data['category_sel'] = $category_id;;
		$this->load->view('Ajax_project_sel_view', $this->view_data);
	}
	
	function AjaxCategorySel(){
		$category_id = $this->input->post('category_sel');
		$this->session->set_userdata('category_sel', $category_id);
		$project_id = $this->session->userdata('project_sel');
		$this->view_data['stories'] = $this->stories->list_stories($project_id, ($category_id==0)? '': $category_id);
		$this->view_data['project_sel'] = $project_id;
		$this->view_data['category_sel'] = $category_id;;
		$this->load->view('Ajax_category_sel_view', $this->view_data);
	}
}