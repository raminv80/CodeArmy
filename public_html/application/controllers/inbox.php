<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inbox extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('projects_model');
		$this->load->model('skill_model');
		$this->load->model('inbox_model');
		$this->load->model('stories_model', 'stories');
		
		$this->view_data['page_is'] = 'Inbox';
		$this->view_data['action_is'] = $this->uri->segment(2);
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
			/*$controller = $this->uri->segment(1);
			$action = $this->uri->segment(2);
			$param = $this->uri->segment(3);
			$referer = $controller;
			if($action)$referer .= '/'.$action;
			if($param)$referer .= "/".$param;
			$this->session->set_userdata('referer', $referer);
			redirect("login"); */
		}	
	}
	
	function update_numbers(){
		if($this->session->userdata('is_logged_in')){
			$bid_inbox=$this->inbox_model->get_bids($this->session->userdata('user_id'));
			$message_inbox=$this->inbox_model->get_messages($this->session->userdata('user_id'));
			$job_inbox=$this->inbox_model->get_jobs($this->session->userdata('user_id'));
			echo json_encode(array($bid_inbox, $message_inbox, $job_inbox));
		}else{echo json_encode(array(array(), array(), array()));}
	}
	
}