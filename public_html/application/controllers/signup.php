<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		
		$this->view_data['page_is'] = 'signup';
		$this->view_data['action_is'] = 'index';
		
		$this->load->model('projects_model');
		$this->load->model('users_model');
		$this->load->model('stories_model', 'stories');
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
		// a user that is already logged in can't signup a new account
		// redirect the user to dashboard
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
			redirect("/");
		}
	}
	
	// index page
	function index() {
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
		$this->view_data['window_title'] = "Signup | Workpad";
		$this->view_data['form_error'] = false;
		// - if signup from is pass, process and add into db
		if($this->input->post('submit')) {
			// verify user input
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', 'Username', 'required|alpha_dash|min_length[2]|max_length[30]|callback__check_username');
			$this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]|min_length[6]');
			$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|min_length[6]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback__check_email');
			if ($this->form_validation->run() == FALSE) {
				$this->view_data['form_error'] = true;
			} else {
				// First, delete old captchas
				$expiration = time()-7200; // Two hour limit
				$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);	
				
				// Then see if a captcha exists:
				$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
				$binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
				$query = $this->db->query($sql, $binds);
				$row = $query->row();
				
				if ($row->count == 0)
				{
					$this->view_data['captcha_error'] = "You must submit the pharase that appears in the image.";
					$this->view_data['form_error'] = true;
				}else{
					if($this->users_model->create_new_user_v5()) {
						// signup successful
						$this->view_data['signup_success'] = true;
						$this->session->unset_userdata('referer');
					} else { // - if there is a problem writing to db
						redirect(base_url()."error");
					} 
				}
			}
		}

		$this->load->helper('captcha');
		$vals = array(
			'img_path'	 => 'public/captcha/',
			'img_url'	 => 'http://'.$_SERVER['HTTP_HOST'].'/public/captcha/',
    		'font_path'	 => 'public/fonts/DIN.ttf'
			);
		
		$cap = create_captcha($vals);

		$data = array(
			'captcha_time'	=> $cap['time'],
			'ip_address'	=> $this->input->ip_address(),
			'word'	 => $cap['word']
			);
		
		$query = $this->db->insert_string('captcha', $data);
		$this->db->query($query);

		$this->view_data['captcha'] = $cap['image'];
		$this->load->view('signup_view', $this->view_data);
	}
	
	/*---------------------------------------------------------------*/
	
	// check for username duplication callback
	function _check_username($username) {
		if($this->users_model->get_user($username, 'username')) {
			$this->form_validation->set_message('_check_username', 'Username already registered');
			return false;
		} else { 
			return true; 
		}
	}
	
	// check for email duplication callback
	function _check_email($email) {
		if($this->users_model->get_user($email, 'email')) {
			$this->form_validation->set_message('_check_email', 'Email already registered');
			return false;
		} else { return true; }
	}
}