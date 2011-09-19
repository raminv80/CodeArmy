<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Story extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('skill_model');
		$this->load->model('projects_model');
		
		$this->view_data['page_is'] = 'story';
		
		// - check if user is logged in
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
		} 		
		$this->load->model('stories_model', 'stories');
		$this->load->model('users_model', 'users');
		$this->load->library('email');
	}
	
	// - index 
	function index() {
		redirect('/');
	}
	
	// - show work id
	function show($work_id) {
		// get stories 
		$this->view_data['is_my_work'] = false;
		$user_id = $this->session->userdata('user_id');
		$this->view_data['userid'] = $this->session->userdata('user_id');
		$query = $this->stories->get_work_details($work_id);
		$user_query = $this->stories->get_user_email($work_id);
		$work_horse = $this->stories->get_work_horse($work_id);
		$this->view_data['work_horse'] = NULL;
		if(count($work_horse)>0){
			$this->view_data['work_horse'] = $work_horse[0];
		}
		
		if($query->num_rows() > 0) {
			$data = $query->result_array();
			$user_data = $user_query->result_array();
	
			if($user_query->num_rows() > 0)
			if($user_data[0]['user_id']==$this->session->userdata('user_id'))
			$this->view_data['is_my_work'] = true;
	
			$this->view_data['work_data'] = $data[0];
			
			// get project
			//$q_pid = $this->stories->get_project_name($data[0]['project_id']);
			//$r_pid = $q_pid->result_array();
			//print_r($r_pid);
			
			//$this->view_data['project'] = $r_pid[0];
			
			// get any uploaded files
			$query = $this->stories->get_uploaded_files($work_id);
			if($query->num_rows() > 0) {
				$data = $query->result_array();
				$this->view_data['files_data'] = $data; 
			}
			
			//get comments
			$query2 = $this->stories->get_comments($work_id);
			if($query2->num_rows() > 0) {
				$data2 = $query2->result_array();
				$this->view_data['comments'] = $data2;
			}
			
			//get bids
			$query3 = $this->stories->get_bids($work_id);
			$data = $query3->result_array();
			$this->view_data['bid_data'] = $data;
			
			//get skills
			$query4 = $this->skill_model->get_work_skills($work_id);
			$this->view_data['skills'] = $query4;
			
			//if owner
			if($this->stories->check_admin($work_id, $user_id)->num_rows() > 0) {
				$this->view_data['show_bid'] = true;
			}
			else {
				$this->view_data['show_bid'] = false;
			}
			
			$this->load->helper('stories_helper');
			$this->load->helper('user_helper');
			$this->view_data['window_title'] = "Workpad :: User Stories Details";
			$this->load->view('story_page_view', $this->view_data);		
		} 
		
		else {
			$this->view_data['window_title'] = "Error, user story (".$work_id.") does not exist.";
			$this->load->view('story_error_view', $this->view_data);
		}
	}
	
	
	// - do upload
	function do_upload() {
		$this->check_authentication();
		$config['upload_path'] = './tmp/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|txt|sql|zip';
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload()){
			$error = array('error' => $this->upload->display_errors());
			$this->view_data['file_upload_error'] = $error;
			//$this->load->view('upload_form', $error);
		} else {
			// upload successfull rename file
			$upload_data = $this->upload->data();
			$new_file_name = $this->input->post('work_id')."_".$this->session->userdata('user_id')."_".time().$upload_data['file_ext'];
			$new_path = "./uploads/".$new_file_name;
			rename($upload_data['full_path'], $new_path);
			$upload_data['file_name_new'] = $new_file_name;
			
			$file_data = array(
				"file_type" => $upload_data['file_ext'],
				"file_name" => $new_file_name,
				"file_title" => $this->input->post('file_title'),
				"file_description" => $this->input->post('file_description'),
				"work_id" => $this->input->post('work_id')
			);
			
			$this->stories->store_uploaded_file($file_data);
			redirect("/story/".$this->input->post('work_id'));
		}
		
		$query = $this->stories->get_work_details($this->input->post('work_id'));
		if($query->num_rows() > 0) {
			$data = $query->result_array();
			$this->view_data['work_data'] = $data[0];
			
			// get any uploaded files
			$query = $this->stories->get_uploaded_files($this->input->post('work_id'));
			if($query->num_rows() > 0) {
				$data = $query->result_array();
				$this->view_data['files_data'] = $data; 
			}
		} 
				
		$this->load->helper('stories_helper');
		$this->load->helper('user_helper');
		$this->view_data['window_title'] = "Workpad :: User Stories Details";
		$this->load->view('story_page_view', $this->view_data);
	}
	
	// - delete uploaded file operation
	function file_delete($file_id) {
		echo $file_id;
	}
	
	// - bid on work
	function setbid()
	{
		$this->check_authentication();
		$work_id = $this->input->post('work_id');
		$query = $this->stories->get_work_details($work_id);
		if($query->num_rows() > 0) {
			$data = $query->result_array();
		}
		if($this->input->post('work_id') && ($data[0]['status']=='open' || $data[0]['status']=='Reject')) {
			$this->stories->make_bid();
			$work = $this->stories->get_work($this->input->post('work_id'));
			$work_data = $work->result_array();
			$title = 'Bid on '.$work_data[0]['title'];
			
			$message = 'User '.$this->session->userdata('username').' placed a bid on story '.$work_data[0]['title'].' with amount '.$this->input->post('set_cost').' and days '.$this->input->post('set_days');
			$this->notify(noreply_email,email_name, admin_email, admin_cc, $title,$message);
			$project_id = $data[0]['project_id'];
			$user_id = $this->session->userdata('user_id');
			$this->stories->log_history($user_id, $project_id, $work_id, 'bid', $this->input->post('set_cost'), $desc = '');
			$this->session->set_flashdata('bid_message',"Thanks for bidding. We will contact you if your bidding is successful. Goodluck!");
		}
		
		redirect("/story/".$work_id);
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
	
	function bid($work_id) {
		$this->check_authentication();
		$this->load->helper('stories_helper');
		$query = $this->stories->get_work_details($work_id);
		if($query->num_rows() > 0) {
			$data = $query->result_array();
		}
		// process bid submission
		if($this->input->post('submit') && ($data[0]['status']=='open' || $data[0]['status']=='Reject')) {
			//print_r($_POST);
			
			$this->stories->make_bid();
			$work = $this->stories->get_work($this->input->post('work_id'));
			$work_data = $work->result_array();
			$title = 'Bid on '.$work_data[0]['title'];
			
			$message = 'User '.$this->session->userdata('username').' placed a bid on story '.$work_data[0]['title'].' with amount '.$this->input->post('set_cost').' and days '.$this->input->post('set_days');
			$this->notify(noreply_email,email_name, admin_email, admin_cc, $title,$message);
			$project_id = $data[0]['project_id'];
			$user_id = $this->session->userdata('user_id');
			$this->stories->log_history($user_id, $project_id, $work_id, 'bid', $this->input->post('set_cost'), $desc = '');
			redirect("/story/".$work_id);
		} 
		
		// get work details
		if($query->num_rows() > 0) {
			$this->view_data['work_data'] = $data[0];
		} else {
			redirect("error");
		}
		
		$this->view_data['window_title'] = "bid for this work";
		$this->load->view('story_bid_view', $this->view_data);
	}
	
	// - The delete view
	function delete($pro_id, $id) {
		$this->check_authentication('admin');
		$this->view_data['window_title'] = "Delete the Story";

		//$this->view_data['type'] = $type;
		$this->view_data['id'] = $id;
		$this->view_data['pro_id'] = $pro_id;
		$this->load->view('story_delete_view', $this->view_data);
	}
	
	// - The confirm delete
	function delete_confirm($pro_id, $id) {
		$this->check_authentication('admin');
		if($this->stories->delete_confirm($id)) { 
			redirect("/projects/view/".$pro_id);
		}
		else {
			echo "Error";
		}
	}
	
	function comments() {	
		$this->check_authentication();	
		$this->stories->create_comment();	
		$this->view_data['signup_success'] = true;
		redirect("/story/".$this->input->post('story_id'));
	}
        
        function bid_accept($id) {
			   $this->check_authentication();
               $query = $this->stories->get_work_from_bid($id);
               $data = $query->result_array();
               $work_id = $data[0]['work_id'];
			   $query = $this->stories->get_work($work_id);
			   $data = $query->result_array();
			   $cost = $data[0]['cost'];
			   $query = $this->stories->get_bid($id);
			   $data = $query->result_array();
			   $to_id = $data[0]['user_id'];
                              
               $this->stories->accept_bid($id, $work_id);
			   $work = $this->stories->get_work($work_id);
			   $work_data = $work->result_array();
			   $title = 'Bid on '.$work_data[0]['title'];
			   $usr = $this->users->get_user($to_id);
			   $usr_data = $usr->result_array();
			   $to = $usr_data[0]['email'];
			   $message = 'Your bid on story '.$work_data[0]['title'].' was successful';
			   $this->notify(admin_email,email_name, $to, admin_cc, $title,$message);
			   
			   $project_id =$work_data[0]['project_id'];
			   $user_id = $usr_data[0]['user_id'];
			   $this->stories->log_history($user_id, $project_id, $work_id, 'win', $cost, $desc = '');
               redirect("/story/".$this->input->post('story_id'));
        }
        
        function edit($id) {
			$this->check_authentication('admin');
			$this->view_data['window_title'] = "Edit the Story";
            $query = $this->stories->get_work_details($id);
            $data = $query->result_array();
            //print_r($data);
			$this->view_data['story_data'] = $data[0];
            $this->view_data['story_id'] = $id;
            
			$this->load->library('formdate');
			$formdate_deadline = new FormDate();
			$formdate_deadline->config['prefix']="deadline_";
			$formdate_deadline->year['start'] = date('Y');
			$formdate_deadline->year['end'] = date('Y')+5;
			$formdate_deadline->year['selected'] = date('Y',strtotime($this->view_data['story_data']['deadline']));
			$formdate_deadline->month['selected'] = date('m',strtotime($this->view_data['story_data']['deadline']));
			$formdate_deadline->day['selected'] = date('d',strtotime($this->view_data['story_data']['deadline']));
			$this->view_data['formdate_deadline'] = $formdate_deadline;
			$formdate_biddead = new FormDate();
			$formdate_biddead->config['prefix']="biddead_";
			$formdate_biddead->year['start'] = date('Y');
			$formdate_biddead->year['selected'] = date('Y',strtotime($this->view_data['story_data']['bid_deadline']));
			$formdate_biddead->month['selected'] = date('m',strtotime($this->view_data['story_data']['bid_deadline']));
			$formdate_biddead->day['selected'] = date('d',strtotime($this->view_data['story_data']['bid_deadline']));
			$formdate_biddead->year['end'] = date('Y')+5;		
			$this->view_data['formdate_biddead'] = $formdate_biddead;
			$data = $this->projects_model->get_categories($data[0]['project_id']);
			$data = $data->result_array();
			$this->view_data['categories'] = $data;
			$this->view_data['skills'] = $this->skill_model->get_all_skills_with_select($id);
			
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
								$work_id = $this->stories->edit_user_story($id);
								if($work_id != false) {
									// signup successful
									$this->view_data['success'] = true;
									$this->view_data['work_id'] = $work_id;
								} //else { // - if there is a problem writing to db
									//redirect(base_url()."error");
								//}
							}
						}
						
			$this->load->view('story_edit_view', $this->view_data);
        }
		
		function done(){
			$this->check_authentication();
			ini_set('display_error',1);
			error_reporting('E_ALL');
			if($this->input->post('csrf')==md5('storyDone')){
				$story_id = $this->input->post('id');
				$query = $this->stories->done($story_id);
				$work = $this->stories->get_work($this->input->post('id'));
				$work_data = $work->result_array();
				$title = $work_data[0]['title'].' is completed.';
				$point = $work_data[0]['points'];
			
				$message = 'User '.$this->session->userdata('username').' has completed the user story '.$work_data[0]['title'];
				$this->notify(noreply_email,email_name, admin_email, admin_cc, $title,$message);
				
			    $project_id =$work_data[0]['project_id'];
			    $user_id = $this->session->userdata('user_id');
				
			    $this->stories->log_history($user_id, $project_id, $story_id, 'done', $point, $desc = '');

				redirect("/story/".$story_id);
			}
		}
		
		function redo($id){
			$this->check_authentication('admin');
			$story_id = $id;
			$query = $this->stories->redo($story_id);
			$work = $this->stories->get_work($story_id);
			$work_data = $work->result_array();
			$title = $work_data[0]['title'].' is completed.';
			$query = $this->stories->get_user_email($story_id);
			$user_data = $query->result_array();
			$to = $user_data[0]['email'];
			$message = 'The story '.$work_data[0]['title'].' needs to be redo.';
			$this->notify(admin_email,email_name, $to, admin_cc, $title,$message);

			$project_id = $work_data[0]['project_id'];
			$point = $work_data[0]['points'];
			$user_id = $user_data[0]['user_id'];
			$this->stories->log_history($user_id, $project_id, $story_id, 'redo', $point, $desc = '');
							
			redirect("/");
		}
		
		function verify($id){
			$this->check_authentication('admin');
			$story_id = $id;
			$query = $this->stories->verify($story_id);		
			$work = $this->stories->get_work($story_id);
			$work_data = $work->result_array();
			$title = $work_data[0]['title'].' is completed.';
			$query = $this->stories->get_user_email($story_id);
			$user_data = $query->result_array();
			$to = $user_data[0]['email'];
			$message = 'The story '.$work_data[0]['title'].' is verified.';
			$this->notify(admin_email,email_name, $to, admin_cc, $title,$message);
			
			$project_id = $work_data[0]['project_id'];
			$point = $work_data[0]['points'];
			$user_id = $user_data[0]['user_id'];
			$this->stories->log_history($user_id, $project_id, $story_id, 'verify', $point, $desc = '');
			
			redirect("/");
		}
		
		function signoff($id){
			$this->check_authentication('admin');
			$story_id = $id;
			$query = $this->stories->signoff($story_id);
			$work = $this->stories->get_work($story_id);
			$work_data = $work->result_array();
			$title = $work_data[0]['title'].' is completed.';
			$query = $this->stories->get_user_email($story_id);
			$user_data = $query->result_array();
			$to = $user_data[0]['email'];
			$message = 'The story '.$work_data[0]['title'].' is signed off.';
			$this->notify(admin_email,email_name, $to, admin_cc, $title,$message);
			
			$project_id = $work_data[0]['project_id'];
			$point = $work_data[0]['points'];
			$user_id = $user_data[0]['user_id'];
			$this->stories->log_history($user_id, $project_id, $story_id, 'signoff', $point, $desc = '');
			
			redirect("/");		
		}
		
		function reject($id){
			$this->check_authentication('admin');
			$story_id = $id;
			$query = $this->stories->reject($story_id);	
			$work = $this->stories->get_work($story_id);
			$work_data = $work->result_array();
			$title = $work_data[0]['title'].' is completed.';
			$query = $this->stories->get_user_email($story_id);
			$user_data = $query->result_array();
			$to = $user_data[0]['email'];
			$message = 'The story '.$work_data[0]['title'].' is rejected. As a result this story will be set to open for bidding again.';
			$this->notify(admin_email,email_name, $to, admin_cc, $title,$message);
			
			$project_id = $work_data[0]['project_id'];
			$point = $work_data[0]['points'];
			$user_id = $user_data[0]['user_id'];
			$this->stories->log_history($user_id, $project_id, $story_id, 'reject', $point, $desc = '');
			
			redirect("/");	
		}
		
		function submission(){
			$work_id = $this->input->post('id');
			// get stories 
			$user_id = $this->session->userdata('user_id');
			$this->view_data['userid'] = $this->session->userdata('user_id');
			$query = $this->stories->get_work_details($work_id);
		
			if($query->num_rows() > 0) {
				$data = $query->result_array();
				$this->view_data['work_data'] = $data[0];
				// get any uploaded files
				$query = $this->stories->get_uploaded_files($work_id);
				if($query->num_rows() > 0) {
					$data = $query->result_array();
					$this->view_data['files_data'] = $data; 
				}
				
				$this->view_data['project_ppl'] = $this->stories->get_project_ppl($this->view_data['work_data']['project_id']);
			
				//get skills
				$query4 = $this->skill_model->get_work_skills($work_id);
				$this->view_data['skills'] = $query4;
				
				$this->load->helper('stories_helper');
				$this->load->helper('user_helper');
				$this->view_data['window_title'] = "Workpad :: Submission";
				$this->load->view('story_submission_view', $this->view_data);		
			} else {
				$this->view_data['window_title'] = "Error, user story (".$work_id.") does not exist.";
				$this->load->view('story_error_view', $this->view_data);
			}
		}
				
		private function notify($from,$fromName, $to, $cc, $subject, $message){
			/*$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'mail.aseanialangkawi.com.my',
				'smtp_user' => 'mworks@aseanialangkawi.com.my',
				'smtp_pass' => 'mworks123',
			);
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from($from, $fromName);
			$this->email->to($to); 
			$this->email->cc($cc); 
			//$this->email->bcc('them@their-example.com'); 
			
			$this->email->subject($subject);
			$this->email->message($message);	
			
			$this->email->send();
			
			echo $this->email->print_debugger();*/
			
			ini_set('display_error',0);
			error_reporting('E_ALL');
			/*echo '1';
			$this->ci->load->helper('phpmailer');
			echo '2';
            send_email($from, $to, $subject, $message);
			echo '3';*/
//die(getcwd()."\application\helpers\phpmailer\class.phpmailer.php");			
			require(getcwd()."/application/helpers/phpmailer/class.phpmailer.php");

			$mail = new PHPMailer();
			
			$mail->IsSMTP();                                      // set mailer to use SMTP
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			//$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
			$mail->Host       = "mail.vakilian.net";      // sets GMAIL as the SMTP server
			//$mail->Port       = 110;                   // set the SMTP port for the GMAIL server
			$mail->Username = "noreply@vakilian.net";  // SMTP username
			$mail->Password = "work123"; // SMTP password
			//$mail->SMTPDebug  = 1;
			
			$mail->SetFrom('noreply@motionworks.com.my', 'Workpad Alerts');
			$mail->AddAddress($to);
			//$mail->AddAddress("ellen@example.com");                  // name is optional
			//$mail->AddReplyTo("info@example.com", "Information");
			
			$mail->WordWrap = 50;                                 // set word wrap to 50 characters
			//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
			//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
			$mail->IsHTML(true);                                  // set email format to HTML
			
			$mail->Subject = $subject;
			$mail->Body    = $message;
			$mail->AltBody = $message;
			
			if(!$mail->Send())
			{
			   echo "Message could not be sent. <p>";
			   echo "Mailer Error: " . $mail->ErrorInfo;
			   exit;
			}
			
			//echo "Message has been sent";
		}
}