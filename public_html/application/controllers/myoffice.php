<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Myoffice extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('projects_model');
		$this->load->model('skill_model');
		$this->load->model('stories_model', 'stories');
		
		$this->view_data['page_is'] = 'Myoffice';
		
		// - check if user is logged in
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
		} else { // - if user not login, redirect to dashboard. 
			redirect("login"); 
		}	
	}
	
	function index(){
		$user_id = $this->session->userdata('user_id');
		$me = $this->users_model->get_user($user_id);
		$me = $me->result_array();
		$me = $me[0];
		$myProfile = $this->users_model->get_profile($user_id);
		$myProfile = $myProfile->result_array();
		$myProfile = $myProfile[0];
		
		$this->view_data['me'] = $me;
		$this->view_data['myProfile'] = $myProfile;
		$this->view_data['works_completed'] = $this->users_model->works_compeleted($user_id);
		$this->view_data['hours_spent']  = $this->users_model->hours_spent($user_id);
		$this->view_data['hours_saved'] = $this->users_model->hours_saved($user_id);
		$this->view_data['last_task'] = $this->users_model->last_task($user_id);
		$this->view_data['working_on'] = $this->users_model->working_on($user_id);
		$this->view_data['leaderboard_project'] = $this->users_model->leaderboard_projects(3);
		$this->view_data['leaderboard_points'] = $this->users_model->leaderboard_points(3);
		$this->view_data['leaderboard_time'] = $this->users_model->leaderboard_time(3);
		$this->view_data['collaborators'] = $this->users_model->collaborators($user_id);
	
		$this->view_data['window_title'] = "Workpad :: MyOffice";
		$this->load->view('my_office_view', $this->view_data);	
	}
	
	function exp_chart($exp){
		//create the images
		$imageOne = ImageCreateFromPNG("http://workpad.local/public/images/bg-level.png");
		imagealphablending($imageOne, true); // setting alpha blending on
		imagesavealpha($imageOne, true);
		imagesetthickness($imageOne, 10);
		imageantialias($imageOne, true);
		$white = ImageColorAllocate($imageOne, 255, 255, 255);
		$black = ImageColorAllocate($imageOne, 0, 0, 0);
		$red = ImageColorAllocate($imageOne, 255, 0, 0);
		//$blue = ImageColorAllocate($imageOne, 0, 0, 255);
		$green = ImageColorAllocate($imageOne, 0, 255, 0);
		//imagecolortransparent($imageOne, $black);
		ImageArc($imageOne, 85, 78, 140, 140, -90, 180, $red);
		header('Content-Type: image/png'); 
		ImagePNG($imageOne);
		ImageDestroy($imageOne); 
		///////////////////
	}
}