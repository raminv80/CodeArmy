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
		$this->view_data['action_is'] = $this->uri->segment(2);
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
		}
		// - check if user is logged in
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
		} else { // - if user not login, redirect to dashboard. 
			//redirect("login"); 
		}	
	}
	
	function index(){
		$this->view_data['action_is'] = 'index';
		$this->load->helper('stories_helper');
		$this->load->helper('user_helper');
		$user_id = $this->session->userdata('user_id');
        //$project_sel = $this->session->userdata('project_sel'); if($project_sel==NULL) $project_sel = '';
		//$category_sel = $this->session->userdata('category_sel'); if($category_sel==NULL) $category_sel = '';
		//$story_sel = $this->session->userdata('story_sel'); if($story_sel==NULL) $story_sel = '';
		
		/*
		//used in ver 3
		//to populate filtering lists
		$this->view_data['projects'] = $this->stories->list_projects();
		if($project_sel=='') $project_sel = $this->view_data['projects'][0]['project_id'];
		$this->view_data['categories'] = $this->stories->list_categories($project_sel);
		$this->view_data['stories'] = $this->stories->list_stories($project_sel, $category_sel);
		
		$this->view_data['project_sel'] = $project_sel;
		$this->view_data['category_sel'] = $category_sel;
		$this->view_data['story_sel'] = $story_sel;
		
		$this->view_data['total_users'] = $this->users_model->getNumRegistration();
		$this->view_data['total_visitors'] = $this->users_model->getVisitors();
		$this->view_data['total_projects_cur_month'] = $this->projects_model->num_projects_month();
		*/
		
		//ver4
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
		
		$this->view_data['featherlight'] = $this->stories->featherlight();
		$this->view_data['lightweight'] = $this->stories->lightweight();
		$this->view_data['heavyweight'] = $this->stories->heavyweight();
		$this->view_data['num_page']=6;
		$user_id = $this->session->userdata('user_id');

		if($user_id){		
			$my_bids = array();
			$bids = $this->stories->get_user_bids($user_id);
			foreach ($bids as $bid) {
				array_push($my_bids, $bid['work_id']);
			}
			$this->view_data['my_bids'] = $my_bids;
		}

		if($this->input->post('action')=='contact'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('description', 'Description', 'required');
			if ($this->form_validation->run() == FALSE) {
				$this->view_data['form_error'] = true;
				$this->view_data['modal_title'] = "Add Project Request";
				$this->view_data['modal_message'] = validation_errors();
			} else {
				$this->view_data['modal_title'] = "Add Project Request";
				$this->view_data['modal_message'] = "Your request is recieved. We will contact you once your application is processed. Thank you.";
				if($this->contact())$this->session->set_flashdata('contact','Your request is recieved. We will contact you once your application is processed. Thank you.');
			}
		}
		//
		
		$this->view_data['stories'] = $this->stories->list_some_stories();
		
		$this->view_data['total_active'] = $this->users_model->getActiveUsers();
		$this->view_data['total_online'] = $this->users_model->getNumOnline();
		
		$this->view_data['total_contacts'] = $this->users_model->get_contacts();
		$this->view_data['total_projects_cash_loaded'] = $this->projects_model->cash_loaded();
		$this->view_data['leaderboard_project'] = $this->users_model->leaderboard_projects(3);
		$this->view_data['leaderboard_points'] = $this->users_model->leaderboard_points(3);
		$this->view_data['leaderboard_time'] = $this->users_model->leaderboard_time(3);
				
		$this->view_data['have_project'] = $this->users_model->have_project($user_id);
		$this->view_data['window_title'] = "Workpad | Home";
		//$this->load->view('home_view', $this->view_data);
		$this->load->view('home_v4_view', $this->view_data);
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
	
	public function feedback(){
		if($this->input->post('action')=='feedback'){
			$this->load->library('form_validation');
			//$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('desc', 'Description', 'required|min_length[5]');
			if ($this->form_validation->run() == FALSE) {
				$this->view_data['form_error'] = true;
			} else {
				if($this->sendfeedback())redirect("/");
				//if($this->sendfeedback())$this->session->set_flashdata('feedback','Your feedback is recieved. Thank you.');
			}
		}
	}
	
	private function contact(){
		require(getcwd()."/application/helpers/phpmailer/class.phpmailer.php");

		$mail = new PHPMailer();
		$to = admin_email;
		
		$mail->IsSMTP();                                      // set mailer to use SMTP
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		//$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
		$mail->Host       = "mail.vakilian.net";      // sets GMAIL as the SMTP server
		//$mail->Port       = 110;                   // set the SMTP port for the GMAIL server
		$mail->Username = "noreply@vakilian.net";  // SMTP username
		$mail->Password = "work123"; // SMTP password
		//$mail->SMTPDebug  = 1;
		
		$mail->SetFrom($this->input->post('email'), "Project's voice");
		$mail->AddAddress($to);
		//$mail->AddAddress("ellen@example.com");                  // name is optional
		//$mail->AddReplyTo("info@example.com", "Information");
		
		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
		//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
		$mail->IsHTML(true);                                  // set email format to HTML
		
		$mail->Subject = 'contract: '.$this->input->post('title');
		$mail->Body    = "Customer name: ".$this->input->post('name')."<br/> phone number: ".$this->input->post('contact')."<br/> Email: ".$this->input->post('email')."<br/> Message: ".$this->input->post('desc')."<br/> Budget: ".$this->input->post('budget')."<br/> Dateline: ".$this->input->post('dateline');
		$mail->AltBody = $this->input->post('desc');
		
		if(!$mail->Send())
		{
		   echo "Message could not be sent. <p>";
		   echo "Mailer Error: " . $mail->ErrorInfo;
		   exit;
		}else{
			return true;
		}
	}
	
	private function sendfeedback(){
		require(getcwd()."/application/helpers/phpmailer/class.phpmailer.php");

		$mail = new PHPMailer();
		$to = admin_email;
		
		$mail->IsSMTP();                                      // set mailer to use SMTP
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		//$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
		$mail->Host       = "mail.vakilian.net";      // sets GMAIL as the SMTP server
		//$mail->Port       = 110;                   // set the SMTP port for the GMAIL server
		$mail->Username = "noreply@vakilian.net";  // SMTP username
		$mail->Password = "work123"; // SMTP password
		//$mail->SMTPDebug  = 1;
		
		$mail->SetFrom(($this->input->post('email'))? $this->input->post('email'): 'anonymous@workpad.my' , "Feedback");
		$mail->AddAddress($to);
		//$mail->AddAddress("ellen@example.com");                  // name is optional
		//$mail->AddReplyTo("info@example.com", "Information");
		
		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
		//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
		$mail->IsHTML(true);                                  // set email format to HTML
		
		$mail->Subject = 'Feedback';
		$mail->Body    = "Customer name: ".$this->input->post('name')."<br/> Email: ".$this->input->post('email')."<br/> Message: ".$this->input->post('desc');
		$mail->AltBody = $this->input->post('desc');
		
		if(!$mail->Send())
		{
		   echo "Message could not be sent. <p>";
		   echo "Mailer Error: " . $mail->ErrorInfo;
		   exit;
		}else{
			return true;
		}
	}

}