<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('projects_model');
		$this->load->model('skill_model');
		
		$this->view_data['page_is'] = 'dashboard';
		
		// - check to verify if user is login...
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
			$this->view_data['user_role'] = $this->session->userdata('role');
		}
		$this->load->model('stories_model', 'stories');
	}
	
	// index page
	function index() {
		$this->load->helper('stories_helper');
		$this->load->helper('user_helper');
		$user_id = $this->session->userdata('user_id');
		
                $this->view_data['open_empty'] = "";
                $this->view_data['progress_empty'] = "";
                $this->view_data['done_empty'] = "";
                $this->view_data['signoff_empty'] = "";
        if(isset($this->session->userdata['project_sel']))$project_sel = $this->session->userdata['project_sel']; else $project_sel = '';
		if(isset($this->session->userdata['skill_sel']))$skill_sel = $this->session->userdata['skill_sel']; else $skill_sel = '';
		if(isset($this->session->userdata['cash_sel']))$cash_sel = $this->session->userdata['cash_sel']; else $cash_sel = '';
		$this->view_data['project_sel'] = $project_sel;
		$this->view_data['skill_sel'] = $skill_sel;
		$this->view_data['cash_sel'] = $cash_sel;
		
		$query = $this->stories->get_works_list('Open', $project_sel, $skill_sel, $cash_sel);    
		if($query->num_rows() > 0) {
			$this->view_data['work_list_open'] = $query->result_array();
		}else {
                    $this->view_data['open_empty'] = true;
        }
        
		$query2 = $this->stories->get_works_list('In progress', $project_sel, $skill_sel, $cash_sel);
		if($query2->num_rows() > 0) {
			$this->view_data['work_list_progress'] = $query2->result_array();
		} 
                 else {
                    $this->view_data['progress_empty'] = true;
                }
                $query3 = $this->stories->get_works_list('Done', $project_sel, $skill_sel, $cash_sel);
		if($query3->num_rows() > 0) {
			$this->view_data['work_list_done'] = $query3->result_array();
		} 
                 else {
                    $this->view_data['done_empty'] = true;
                }
                $query4 = $this->stories->get_works_list('Signoff', $project_sel, $skill_sel, $cash_sel);
		if($query4->num_rows() > 0) {
			$this->view_data['work_list_signoff'] = $query4->result_array();
		} 
                 else {
                    $this->view_data['signoff_empty'] = true;
                }
		$this->view_data['total_users'] = $this->users_model->getNumRegistration();
		$this->view_data['total_active'] = $this->users_model->getActiveUsers();
		$this->view_data['total_online'] = $this->users_model->getNumOnline();
		$this->view_data['total_visitors'] = $this->users_model->getVisitors();
		$this->view_data['total_projects_cur_month'] = $this->projects_model->num_projects_month();
		$this->view_data['leaderboard_project'] = $this->users_model->leaderboard_projects(3);
		$this->view_data['leaderboard_points'] = $this->users_model->leaderboard_points(3);
		$this->view_data['leaderboard_time'] = $this->users_model->leaderboard_time(3);
		
		$this->view_data['projects'] = $this->projects_model->get_all_projects();
		$this->view_data['skills'] = $this->skill_model->get_all_skills();
		
		echo($this->session->userdata('project_sel'));
				
		$this->view_data['have_project'] = $this->users_model->have_project($user_id);
		$this->view_data['window_title'] = 'Workpad';
		$this->load->view('dashboard_view', $this->view_data);
	}	
	
	function feedback(){
		$user_id = $this->session->userdata('user_id');
		$query = $this->users_model->get_user($user_id);
		$user_data = $query->result_array();
		$this->view_data['user_data'] = $user_data;
		$this->view_data['window_title'] = 'Feedback on Workpad';
		$this->load->view('feedback_view', $this->view_data);
	}
	
	function statistics($user_id){
		$this->view_data['window_title'] = 'Statistics';
		$this->load->view('statistics_view', $this->view_data);		
	}
	
	function filter(){
		$project_sel = $this->input->post('projects');
		$skill_sel = $this->input->post('skills');
		$cash_sel = $this->input->post('cash_range');
		$data = array(
				'project_sel' => $project_sel,
				'skill_sel' => $skill_sel,
				'cash_sel' => $cash_sel
			);
		$this->session->set_userdata($data);
		redirect('dashboard');	
	}
}