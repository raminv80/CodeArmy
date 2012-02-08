<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('projects_model');
		$this->load->model('users_model');
		$this->load->model('stories_model', 'stories');
		
		$this->view_data['page_is'] = 'project';
		$this->view_data['action_is'] = $this->router->fetch_method();
		
		// - check to verify if user is login...
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
			$this->view_data['user_id'] = $this->session->userdata('user_id');
			$this->view_data['user_role'] = $this->session->userdata('role');
			$user_id = $this->session->userdata('user_id');
			$me = $this->users_model->get_user($user_id);
			$me = $me->result_array();
			$me = $me[0];
			$myProfile = $this->users_model->get_profile($user_id);
			$myProfile = $myProfile->result_array();
			$myProfile = $myProfile[0];
			$this->view_data['me'] = $me;
			$this->view_data['myProfile'] = $myProfile;
			$this->view_data['projects'] = $this->projects_model->get_my_projects($user_id);
			$this->view_data['username'] = $this->session->userdata('username');
		}else{
			if(in_array(strtolower($this->view_data['action_is']), array('scrum_board','sprint_planner','AjaxSaveStory','burndown_chart', 'management'))){
				$controller = $this->uri->segment(1);
				$action = $this->uri->segment(2);
				$param = $this->uri->segment(3);
				$referer = $controller;
				if($action)$referer .= '/'.$action;
				if($param)$referer .= "/".$param;
				$this->session->set_userdata('referer', $referer);
				redirect("login"); 	
			}
		}
	}
	
	// index page
	function show($id) {
		$qry = $this->projects_model->get_project_details($id);
		$user_id = $this->session->userdata('user_id');
		if($qry->num_rows>0){
			$qry = $qry->result_array();
			$this->view_data['project'] = $qry[0];
			$this->view_data['percentage'] = $this->projects_model->get_percentage($id);
			$this->view_data['collaborators'] = $this->projects_model->get_collaborators($id);
			$this->view_data['window_title'] = $this->view_data['project']['project_name'].' | Workpad';
			$this->load->view('project_show_view', $this->view_data);
		}
	}
	
	public function remove_comment($id){
		$comment = $this->stories->get_comment($id);
		if(count($comment)>0){
			if(($comment[0]['username']==$this->session->userdata('username'))||($this->session->userdata('role')=='admin')){
				$this->stories->delete_comment($id);
			}
		}
		redirect("/story/".$comment[0]['story_id']);
	}
	
	public function management($id=0){
		$user_id = $this->session->userdata('user_id');
		$this->view_data['project_owner'] = $this->projects_model->is_project_owner($user_id, $id);
		$this->view_data['scrum_master'] = $this->projects_model->is_scrum_master($user_id, $id);
		$this->view_data['window_title'] = 'Project Management | Workpad';
		if($id!=0){
			$qry = $this->projects_model->get_project_details($id);
			if($qry->num_rows>0){
				$qry = $qry->result_array();
				$this->view_data['project'] = $qry[0];
				$this->view_data['percentage'] = $this->projects_model->get_percentage($id);
				$this->view_data['collaborators'] = $this->projects_model->get_collaborators($id);
				$this->view_data['window_title'] = 'Workpad | Manage '.$this->view_data['project']['project_name'];
			}
		}else{
			$list = array();
			$list['DRAFTS'] = $this->stories->get_my_projects_stories_state($user_id,array('draft'));
			$list['OPEN JOBS'] = $this->stories->get_my_projects_stories_state($user_id,array('open','reject'));
			$list['In PROGRESS'] = $this->stories->get_my_projects_stories_state($user_id,array('in progress','redo'));
			$list['DONE'] = $this->stories->get_my_projects_stories_state($user_id,array('done'));
			$list['VERIFIED'] = $this->stories->get_my_projects_stories_state($user_id,array('verify'));
			$list['SIGNED OFF'] = $this->stories->get_my_projects_stories_state($user_id,array('signoff'));
			$this->view_data['stories_list'] = $list;
			$this->view_data['projects'] = $this->projects_model->get_my_projects_detailed($user_id);
		}
		$this->load->view('project_management_view', $this->view_data);
	}
	
	public function story_management($id='0'){
		$user_id = $this->session->userdata('user_id');
		$this->view_data['project_owner'] = $this->projects_model->is_project_owner($user_id, $id);
		$this->view_data['scrum_master'] = $this->projects_model->is_scrum_master($user_id, $id);
		$this->view_data['window_title'] = 'Project Management | Workpad';
		if($id=='0'){
			$list = array();
				$list['DRAFTS'] = $this->stories->get_my_projects_stories_state($user_id,array('draft'));
				$list['OPEN JOBS'] = $this->stories->get_my_projects_stories_state($user_id,array('open','reject'));
				$list['In PROGRESS'] = $this->stories->get_my_projects_stories_state($user_id,array('in progress','redo'));
				$list['DONE'] = $this->stories->get_my_projects_stories_state($user_id,array('done'));
				$list['VERIFIED'] = $this->stories->get_my_projects_stories_state($user_id,array('verify'));
				$list['SIGNED OFF'] = $this->stories->get_my_projects_stories_state($user_id,array('signoff'));
				$this->view_data['stories_list'] = $list;
		}else{
			$list = array();
				$list['DRAFTS'] = $this->stories->get_project_stories_state($id,array('draft'));
				$list['OPEN JOBS'] = $this->stories->get_project_stories_state($id,array('open','reject'));
				$list['In PROGRESS'] = $this->stories->get_project_stories_state($id,array('in progress','redo'));
				$list['DONE'] = $this->stories->get_project_stories_state($id,array('done'));
				$list['VERIFIED'] = $this->stories->get_project_stories_state($id,array('verify'));
				$list['SIGNED OFF'] = $this->stories->get_project_stories_state($id,array('signoff'));
				$this->view_data['stories_list'] = $list;
		}
		$this->view_data['projects'] = $this->projects_model->get_my_projects_detailed($user_id);
		$this->load->view('project_management_view', $this->view_data);
	}
	
	public function sprint_planner($id=0){
		$this->view_data['enable_sprint_locks'] = false;
		$user_id = $this->session->userdata('user_id');
		$this->view_data['project_owner'] = $this->projects_model->is_project_owner($user_id, $id);
		$this->view_data['scrum_master'] = $this->projects_model->is_scrum_master($user_id, $id);
		if(!$this->view_data['project_owner']){
			$this->view_data['modal_message'] = "You don't have permission to edit sprints of this project but still you may preview it.";
			$this->view_data['modal_title'] = "Sprint Preview";
		}
		$this->view_data['project_sel'] = $id;
		if($id>0){
			$this->view_data['works'] = $this->projects_model->get_worklist_sprint($id);
			$this->view_data['first_sprint'] = $this->projects_model->getFirstSprint($id);
			if(count($this->view_data['first_sprint'])>0)
				$this->view_data['first_sprint'] = $this->view_data['first_sprint'][0]['id'];
		}
		$curSprint = $this->projects_model->getCurrentSprint($id);
		$this->view_data['curSprint'] = -1;
		if(count($curSprint)>0)$this->view_data['curSprint'] = $curSprint[0]['id'];
		$this->view_data['project'] = $this->projects_model->get_project_details($id);
		$this->view_data['project'] = $this->view_data['project']->result_array();
		$this->view_data['project'] = $this->view_data['project'][0];
		$this->view_data['window_title'] = 'Sprint Plan of '.$this->view_data['project']['project_name'].' | Workpad';
		$this->load->view('sprint_plan_view', $this->view_data);
	}
	
	public function scrum_board($id=0, $cur_sprint=-1){
		$user_id = $this->session->userdata('user_id');
		$this->view_data['project_owner'] = $this->projects_model->is_project_owner($user_id, $id);
		$this->view_data['scrum_master'] = $this->projects_model->is_scrum_master($user_id, $id);
		$this->view_data['project_sel'] = $id;
		
		if($id>0){
			if($cur_sprint==-1){
				$cur_sprint = $this->projects_model->getCurrentSprint($id);
				if(count($cur_sprint)>0){
					$cur_sprint = $cur_sprint[0]['id'];
				}else $cur_sprint = -1;
			}
			$this->view_data['works_state'] = $this->projects_model->get_worklist_state($id, $cur_sprint);
			$this->view_data['point_state'] = $this->projects_model->get_work_points_state($id, $cur_sprint);
			$sum=0;foreach($this->view_data['point_state'] as $data) $sum+=$data['points'];
			if($sum==0)$this->view_data['modal_message'] = "There is no published user story in current selected sprint.";
		}
		$this->view_data['sprint_sel'] = $cur_sprint;
		$this->view_data['project'] = $this->projects_model->get_project_details($id);
		$this->view_data['project'] = $this->view_data['project']->result_array();
		$this->view_data['project'] = $this->view_data['project'][0];
		
		$this->view_data['sprints'] = $this->projects_model->get_sprints($id);
		$this->view_data['window_title'] = 'Scrumboard of '.$this->view_data['project']['project_name'].' | Workpad';
		$this->load->view('scrum_board_view', $this->view_data);
	}
	
	public function AjaxSaveStory(){
		$user_id = $this->session->userdata('user_id');
		$data = $this->input->post('data');
		$project_id = $this->input->post('project_id');
		$work_id = '0';
		//check if this project is mine
		if($this->projects_model->is_project_owner($user_id, $project_id))
			$work_id = $this->stories->create_draft_story($project_id, $user_id, $data);
		echo $work_id;
	}
	
	public function AjaxUpdateStory(){
		$user_id = $this->session->userdata('user_id');
		$data = $this->input->post('data');
		$project_id = $this->input->post('project_id');
		$id = $this->input->post('work_id');
		$work_id = '0';
		//check if this project is mine
		if($this->projects_model->is_project_owner($user_id, $project_id)){
			$work_id = $this->stories->update_draft_story($project_id, $user_id, $id, $data);
		}
		echo $work_id;
	}
	
	public function AjaxDeleteStory(){
		$user_id = $this->session->userdata('user_id');
		$data = $this->input->post('work_id');
		$project_id = $this->input->post('project_id');
		$work_id = '0';
		//check if this project is mine
		if($this->projects_model->is_project_owner($user_id, $project_id))
			$work_id = $this->stories->delete_story_v4($project_id, $data);
		echo $work_id;
	}
	
	public function AjaxSavePriority(){
		$user_id = $this->session->userdata('user_id');
		$data = $this->input->post('data');
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');
		if(trim($date_from)=='')$date_from=NULL;
		if(trim($date_to)=='')$date_to=NULL;
		$sprint_id = $this->input->post('sprint_id');
		$project_id = $this->input->post('project_id');
		$data = json_decode($data);
		$sprint = '0';
		//check if this project is mine
		if($this->projects_model->is_project_owner($user_id, $project_id))
			$sprint = $this->stories->update_priority($project_id, $user_id, $sprint_id, $data, $date_from, $date_to);
		echo $sprint;	
	}
	
	public function removeSprint($id=0){
		if($id!=0){
			$user_id = $this->session->userdata('user_id');
			$project_id = $this->projects_model->get_project_from_sprint($id);
			if($project_id && $this->projects_model->is_project_owner($user_id, $project_id))
				$this->projects_model->delete_sprint($id);
		}
		redirect('/project/sprint_planner/'.$project_id);	
	}
	
	public function burndown_chart($id=0, $sprint_sel=0){
		$user_id = $this->session->userdata('user_id');
		$this->view_data['project_owner'] = $this->projects_model->is_project_owner($user_id, $id);
		$this->view_data['scrum_master'] = $this->projects_model->is_scrum_master($user_id, $id);
		$this->view_data['project_sel'] = $id;
		$this->view_data['project'] = $this->projects_model->get_project_details($id);
		$this->view_data['project'] = $this->view_data['project']->result_array();
		$this->view_data['project'] = $this->view_data['project'][0];
		$this->view_data['sprints'] = $this->projects_model->get_sprints($id);
		
		if($sprint_sel==0)
			{
				$cur_sprint = $this->projects_model->getCurrentSprint($id);
			}else{
				$cur_sprint = $this->projects_model->get_sprint($sprint_sel);
			}
		if(count($cur_sprint)<1)$cur_sprint = $this->projects_model->getFirstSprint($id);
		if(count($cur_sprint)>0){
			$this->view_data['cur_sprint'] = $cur_sprint[0];
			if($sprint_sel==0 && (count($cur_sprint)>0)) $sprint_sel = $cur_sprint[0]['id'];
		}else{
			$this->view_data['cur_sprint'] = array(); $sprint_sel = 0;
		}
		$this->view_data['sprint_sel'] = $sprint_sel;
		$chart = $this->projects_model->get_chart($id, $sprint_sel);
		$this->view_data['chart'] = $chart;
		$this->view_data['sprint_points'] = $this->projects_model->get_sprint_points($id,$sprint_sel);
		$this->view_data['resource_chart'] = $this->projects_model->get_resource_chart($id,$sprint_sel);
		$this->view_data['window_title'] = 'Burndown Chart of '.$this->view_data['project']['project_name'].'| Workpad';
		$this->load->view('burndown_view', $this->view_data);
	}
	
	public function contact(){
		if($this->input->post('submit') == 'Submit'){
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
			$mail->Body    = "Customer name: ".$this->input->post('name')."<br/> phone number: ".$this->input->post('phone')."<br/> Email: ".$this->input->post('email')."<br/> Message: ".$this->input->post('message')."<br/> Budget: ".$this->input->post('budget')."<br/> Dateline: ".$this->input->post('deadline');
			$mail->AltBody = $this->input->post('message');
			
			if(!$mail->Send())
			{
			   echo "Message could not be sent. <p>";
			   echo "Mailer Error: " . $mail->ErrorInfo;
			   exit;
			}else{
				$this->view_data['email_sent'] = true;	
			}
		}
		redirect("/");
	}
}