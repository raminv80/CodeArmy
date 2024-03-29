<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Story extends CI_Controller {
	
	var $view_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('skill_model');
		$this->load->model('projects_model');
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
		$this->view_data['page_is'] = 'story';
		$this->view_data['action'] = $this->uri->segment(2);
		$this->view_data['action_is'] = $this->uri->segment(2);
		// - check if user is logged in
		$check_login = $this->session->userdata('is_logged_in');
		if($check_login == true) {
			$this->view_data['username'] = $this->session->userdata('username');
			$this->view_data['user_id'] = $this->session->userdata('user_id');
		} 		
		$this->load->model('stories_model', 'stories');
		$this->load->model('users_model', 'users');
		$this->load->helper(array('form', 'url'));
		$this->load->library('email');
	}
	
	// - index 
	function index() {
		redirect('/');
	}
	
	// - show work id
	function show($work_id) {
		//everyone can see the work details
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
		$this->view_data['action_is'] = 'show';
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
			$this->view_data['subscribed'] = $this->stories->subscribed($user_id,$work_id);
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
			if(($this->session->userdata('role')=='admin')||
			  ($this->stories->check_admin($work_id, $user_id)->num_rows() > 0)||
			  ($this->projects_model->is_project_owner($user_id, $this->view_data['work_data']['project_id']))) {
				$this->view_data['show_bid'] = true;
			}else{
				$this->view_data['show_bid'] = false;
			}
			
			$msg = $this->session->flashdata('bid_message');
			if($msg){
				$this->view_data['modal_message'] = $msg;
				$this->view_data['modal_title'] = "Bid on ".$this->view_data['work_data']['title'];
			}
			$this->load->helper('stories_helper');
			$this->load->helper('user_helper');
			$this->view_data['window_title'] = us_dev." '".$this->view_data['work_data']['title']."' | Workpad";
			//$this->load->view('story_page_view', $this->view_data);
			$this->load->view('story_page_v4_view', $this->view_data);
		} 
		
		else {
			$this->view_data['window_title'] = "Error, ".us_dev." (".$work_id.") does not exist.";
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
		$this->view_data['window_title'] = "User Stories Details | Workpad";
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
			$lowest = $this->stories->get_lowest_bid($this->input->post('work_id'));
			$this->stories->make_bid();
			$work = $this->stories->get_work($this->input->post('work_id'));
			$work_data = $work->result_array();
			$title = 'Bid on '.$work_data[0]['title'];
			$product_owner = $this->users_model->get_user($work_data[0]['creator']);
			if($product_owner)$product_owner = $product_owner->result_array();
			$po_name = $product_owner[0]['username'];
			$product_owner_id = $product_owner[0]['user_id'];
			$product_owner = $product_owner[0]['email'];
			$message = '<p>Hello '.$po_name.',</p><p>User <a href="http://'.$_SERVER['HTTP_HOST'].'/user/'.$this->session->userdata('user_id').'">'.$this->session->userdata('username').'</a> placed a bid on '.us_manager.' <a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$work_data[0]['work_id'].'">'.$work_data[0]['title'].'</a> with amount '.$this->input->post('set_cost').' and days '.$this->input->post('set_days').'</p><p>Whenever you want you can refer to the bidding list of this <a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$work_data[0]['work_id'].'">'.us_manager.'</a> to decide on awarding the '.us_manager.'. You may want to study bidder\'s profiles before approving a bid.</p><p>Thank you.</p>';
			$short_message = '<p>User <a href="http://'.$_SERVER['HTTP_HOST'].'/user/'.$this->session->userdata('user_id').'">'.$this->session->userdata('username').'</a> placed a bid on '.us_manager.' <a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$work_data[0]['work_id'].'">'.$work_data[0]['title'].'</a> with amount '.$this->input->post('set_cost').' and days '.$this->input->post('set_days').'</p>';
			$this->notify(noreply_email,email_name.' Bids', $product_owner, admin_cc, $title,$message, 'bid', $product_owner_id, $short_message, $this->session->userdata('user_id'));
			$project_id = $data[0]['project_id'];
			$user_id = $this->session->userdata('user_id');
			$this->stories->log_history($user_id, $project_id, $work_id, 'bid', $this->input->post('set_cost'), $desc = '');
			$this->session->set_flashdata('bid_message',"Thanks for bidding. We will contact you if your bidding is successful. Goodluck!");

			//Outbid notification
			if($lowest)
			if(($this->input->post('set_cost') <  $lowest['bid_cost'] && $this->input->post('set_days') <  $lowest['days']) ||
			   ($this->input->post('set_cost') <  $lowest['bid_cost'] && $this->input->post('set_days') == $lowest['days']) ||
			   ($this->input->post('set_cost') == $lowest['bid_cost'] && $this->input->post('set_days') <  $lowest['days'])) {
	
				if ($lowest['user_id'] != $user_id) {
					$title = 'Outbid on '.$work_data[0]['title'];
					$message = '<p>Your bid on '.us_dev.' \'<a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$work_data[0]['work_id'].'">'.$work_data[0]['title'].'</a>\' has been outbid.</p><p>You may want to adjust your bid by refering to the bidding list of this <a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$work_data[0]['work_id'].'">'.us_dev.'</a>.</p><p>Thank you.</p>';
					$short_message = '<p><a href="http://'.$_SERVER['HTTP_HOST'].'/user/'.$this->session->userdata('user_id').'">'.ucfirst($this->session->userdata('username')).'</a> outbided you on '.us_dev.' \'<a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$work_data[0]['work_id'].'">'.$work_data[0]['title'].'</a>\'.</p>';
					$this->users->notify($lowest['user_id'], $title, $message, 'bid',NULL, $short_message, $this->session->userdata('user_id'));
				}
			};
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
	
	// - The delete view
	function delete($pro_id, $id) {
		$this->check_authentication('admin');
		$this->view_data['window_title'] = "Delete the ".ucwords(us_dev)." | Workpad";

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
		//any logged user can comment
		$path = "";
		if($this->input->post('has_file')=='has_file'){
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'zip|gif|jpeg|png|jpg';
			$config['max_size']	= '10240';
			$config['overwrite'] = false;
			$config['encrypt_name'] = true;
			$config['remove_spaces'] = true;
			$this->load->library('upload', $config);
			if($this->upload->do_upload()){
				$uploaded = $this->upload->data();
				$path = $config['upload_path'].$uploaded['file_name'];
			}else{
				$path = "";
			}
		}
		$this->stories->create_comment($path);
		
		//email all ppl involved.
		$work = $this->stories->get_work($this->input->post('story_id'));
		$work = $work->result_array();
		$wh = $this->stories->get_work_horse($this->input->post('story_id'));
		$po = $this->stories->get_product_owner($this->input->post('story_id'));
		$sm = $this->stories->get_scrum_master($this->input->post('story_id'));
		$cn = $this->stories->get_comment_emails($this->input->post('story_id'), $this->session->userdata('user_id'));
		$target = array();
		$target_ids = array();
		if(count($wh)>0){if($wh[0]['email']!=$this->session->userdata('user_id')){$target[] = $wh[0]['email']; $target_ids[] = $wh[0]['user_id'];}}
		if(count($po)>0){$target[] = $po[0]['email']; $target_ids[] = $po[0]['user_id'];}
		if(count($sm)>0){$target[] = $sm[0]['email']; $target_ids[] = $sm[0]['user_id'];}
		foreach($cn as $usr){ $target[] = $usr['email']; $target_ids[] = $usr['user_id'];}
		$to=array_unique($target);
		$to_id = array_unique($target_ids);
		$cc = admin_email;
		$subject = "Workpad | Comment on ".$work[0]['title'];
		$message = "<p>User <a href='http://".$_SERVER['HTTP_HOST']."/user/".$this->session->userdata('user_id')."'>".$this->session->userdata('username')."</a> placed a comment on ".us_dev." \'<a href='http://".$_SERVER['HTTP_HOST']."/story/".$this->input->post('story_id')."'>".$work[0]['title']."</a>\':</p><p>".substr(strip_tags($this->input->post('comments')),0,500)."<br />(to read more <a href='http://".$_SERVER['HTTP_HOST']."/story/".$this->input->post('story_id')."'>click here</a>)</p>";
		$short_message = "<p><a href='http://".$_SERVER['HTTP_HOST']."/user/".$this->session->userdata('user_id')."'>".ucfirst($this->session->userdata('username'))."</a> commented on <a href='http://".$_SERVER['HTTP_HOST']."/story/".$this->input->post('story_id')."'>".$work[0]['title']."</a>: \"".substr(strip_tags($this->input->post('comments')),0,500)."\"</p>";
		$this->notify(noreply_email,email_name, $to, $cc, $subject, $message, 'message', $to_id, $short_message,$this->session->userdata('user_id'));
		$this->view_data['signup_success'] = true;
		redirect("/story/".$this->input->post('story_id'));
	}
	
	function comments_v5() {
		$this->check_authentication();
		
		//any logged user can comment
		$path = "";
		if($this->input->post('has_file')=='has_file'){
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'zip|gif|jpeg|png|jpg';
			$config['max_size']	= '10240';
			$config['overwrite'] = false;
			$config['encrypt_name'] = true;
			$config['remove_spaces'] = true;
			$this->load->library('upload', $config);
			if($this->upload->do_upload('files')){
				$uploaded = $this->upload->data();
				$path = $config['upload_path'].$uploaded['file_name'];
			}else{
				$path = "";
			}
		}
		$comment_id = $this->stories->create_comment($path);
		
		//email all ppl involved.
		$work = $this->stories->get_work($this->input->post('story_id'));
		$work = $work->result_array();
		$wh = $this->stories->get_work_horse($this->input->post('story_id'));
		$po = $this->stories->get_product_owner($this->input->post('story_id'));
		$sm = $this->stories->get_scrum_master($this->input->post('story_id'));
		$cn = $this->stories->get_comment_emails($this->input->post('story_id'), $this->session->userdata('user_id'));
		$work_id = $this->input->post('story_id');
		$target = array();
		$target_ids = array();
		$inbox_ids = array();
		if(count($wh)>0){
			//work horse
			if($wh[0]['email']!=$this->session->userdata('user_id')){
				if($this->stories->subscribed($wh[0]['user_id'],$work_id)){
					$target[] = $wh[0]['email'];
				}
			}
			$target_ids[] = $wh[0]['user_id'];
		}
		if(count($po)>0){
			//product owner
			if($this->stories->subscribed($po[0]['user_id'],$work_id)){
				$target[] = $po[0]['email'];
			}
			$target_ids[] = $po[0]['user_id'];
		}
		if(count($sm)>0){
			//scrum master
			if($this->stories->subscribed($sm[0]['user_id'],$work_id)){
				$target[] = $sm[0]['email'];
			}
			$target_ids[] = $sm[0]['user_id'];
		}
		foreach($cn as $usr){
			//partcipants
			if($this->stories->subscribed($usr['user_id'],$work_id)){
				$target[] = $usr['email'];
			}
			$target_ids[] = $usr['user_id'];
		}
		$to=array_unique($target);
		$to_id = array_unique($target_ids);
		$subject = "Workpad | Comment on ".$work[0]['title'];
		$message = "User <a href='http://".$_SERVER['HTTP_HOST']."/user/".$this->session->userdata('user_id')."'>".$this->session->userdata('username')."</a> placed a comment on ".us_dev." \'<a href='http://".$_SERVER['HTTP_HOST']."/story/".$this->input->post('story_id')."'>".$work[0]['title']."</a>\':</p><p>".substr(strip_tags($this->input->post('comments')),0,500)."<br />(to read more <a href='http://".$_SERVER['HTTP_HOST']."/story/".$this->input->post('story_id')."'>click here</a>)</p>";
		$short_message = substr(strip_tags($this->input->post('comments')),0,500)."</p>";
		$link = "/story/".$this->input->post('story_id')."#comment-top";
		if(count($to_id)>0)
			$this->email(noreply_email,email_name, $to, $subject, $message);
			$this->inbox($subject, $message, 'message', $to_id, $short_message,$this->session->userdata('user_id'), $link);
		$this->view_data['signup_success'] = true;
		
		//pusher
		require_once(getcwd()."/application/helpers/pusher/Pusher.php");
		$user = $this->users_model->get_user($this->session->userdata('user_id'));
		$user = $user->result_array(); $user = $user[0];
		$pusher = new Pusher('0aacc348a446e96739e2', 'f63f88767155269e4c98', '18954');
		$data = array(
			'comment'=>$this->input->post('comments'), 
			'user_id'=>$this->session->userdata('user_id'), 
			'file' => $path, 
			'date' => date('d m Y'), 
			'avatar'=>$this->users_model->get_avatar($this->session->userdata('user_id')), 
			'username' => $user['username'], 
			'title' => $this->users_model->getWorkTitle($this->session->userdata('user_id'), $this->input->post('story_id')),
			'comment_id' => $comment_id,
			'story_id' => $work[0]['work_id']
		);
		$pusher->trigger('test_channel', 'new_comment_'.$work[0]['work_id'], $data);
	}
        
    function bid_remove($id) {
			   $this->check_authentication();
               $query = $this->stories->get_work_from_bid($id);
               $data = $query->result_array();
               $work_id = $data[0]['work_id'];
			   
			   $query = $this->stories->get_bid($id);
			   $data = $query->result_array();
			   $bid_user_id = $data[0]['user_id'];
               $user_id = $this->session->userdata('user_id');
			   
			   if($user_id == $bid_user_id){
				   //only project owner can accept bids
				   $this->stories->remove_bid($id,$user_id);
			   }
               redirect("/story/$work_id");
        }

	function reopen($work_id){ 
	   $this->check_authentication();
		$story_id = $work_id;
		$work = $this->stories->get_work($story_id);
		$work_data = $work->result_array();
		$user_id = $this->session->userdata('user_id');
		if($this->projects_model->is_project_owner($user_id, $work_data[0]['project_id'])){
			//only product owner can reject the work
			$query = $this->stories->get_user_email($story_id);
			$user_data = $query->result_array();
			$query = $this->stories->reopen($story_id, $work_data[0]['work_horse']);	
			$title = $work_data[0]['title'].' is rejected!';
			$to = $user_data[0]['email'];
			$message = '<p>Hello,</p><p>It seems you have failed to meet expectations of '.po_dev.' for the '.us_dev.' \'<a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$story_id.'">'.$work_data[0]['title'].'</a>\'. Regard to this matter, '.po_dev.' has decided to revoke your assignment and the '.us_dev.' is set to open for bidding once again. For more info please refer to the discussion section of this '.us_dev.'.</p><p>Regards.</p>';
			$short_message = '<p><a href="http://'.$_SERVER['HTTP_HOST'].'/user/'.$this->session->userdata('user_id').'">'.po_dev.'</a> revoked your assignment on '.us_dev.' <a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$story_id.'">'.$work_data[0]['title'].'</a> and the '.us_dev.' is set to open for bidding again.</p>';
			$this->users_model->notify($user_data[0]['user_id'], $title, $message, 'job', $short_message, $this->session->userdata('user_id'));
			
			$project = $this->projects_model->get_project_details($work_data[0]['project_id']);
			$project = $project->result_array();
			$scrum_master = $this->users_model->get_user($project[0]['scrum_master_id']);
			$scrum_master = $scrum_master->result_array();
			$to = $scrum_master[0]['email'];
			$to_id = $scrum_master[0]['user_id'];
			$message = '<p>Hello,</p><p>The '.us_manager.' \'<a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$story_id.'">'.$work_data[0]['title'].'</a>\' is not proceeding according to '.po_manager.' expectations. Regard to this matter, '.po_manager.' has decided to revoke the assignment and the '.us_manager.' is set to open for bidding one again. For more info please refer to the discussion section of this user sotry.</p><p>You are recieving this email because you are assigned as '.sm_manager.' of this '.us_manager.'.</p><p>Regards.</p>';
			$short_message = '<p>The '.us_manager.' \'<a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$story_id.'">'.$work_data[0]['title'].'</a>\' is not proceeding according to '.po_manager.' expectations. Regard to this matter, <a href="http://'.$_SERVER['HTTP_HOST'].'/user/'.$this->session->userdata('user_id').'">'.po_manager.'</a> has decided to revoke the assignment and the '.us_manager.' is set to open for bidding one again.</p>';
			if($user_data[0]['user_id']!=$to) $this->notify(noreply_email,email_name, $to, admin_cc, $title,$message, 'job', $to_id, $short_message, $this->session->userdata('user_id'));
			$project_id = $work_data[0]['project_id'];
			$sprint = $work_data[0]['sprint'];
			$point = $work_data[0]['points'];
			$user_id = $user_data[0]['user_id'];
			$this->stories->log_history($user_id, $project_id, $story_id, 'reject', $point, $desc = '');
		}
		redirect("/project/scrum_board/$project_id/$sprint");
	}

    function bid_accept($id, $ref='') {
			   $this->check_authentication();
               $query = $this->stories->get_work_from_bid($id);
               $data = $query->result_array();
               $work_id = $data[0]['work_id'];
			   
			   $query = $this->stories->get_work($work_id);
			   $data = $query->result_array();
			   $cost = $data[0]['cost'];
			   $project_id = $data[0]['project_id'];
			   $query = $this->stories->get_bid($id);
			   $data = $query->result_array();
			   $to_id = $data[0]['user_id'];
               $user_id = $this->session->userdata('user_id');
			   
			   if($this->projects_model->is_project_owner($user_id, $project_id)){
				   //only project owner can accept bids
				   $this->stories->accept_bid($id, $work_id);
				   $work = $this->stories->get_work($work_id);
				   $work_data = $work->result_array();
				   $title = 'You won the Bid on '.$work_data[0]['title'];
				   $usr = $this->users->get_user($to_id);
				   $usr_data = $usr->result_array();
				   $to = $usr_data[0]['email'];
				   $to_id = $usr_data[0]['user_id'];
				   $message = '<h3>Congratulations!</h3><p>You are the winner! Your bid on '.us_dev.' \'<a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$work_data[0]['work_id'].'">'.$work_data[0]['title'].'</a>\' was successful. Now you may refer to the '.us_dev.' from <a href="http://'.$_SERVER['HTTP_HOST'].'">Workpad</a>&gt;<a href="http://'.$_SERVER['HTTP_HOST'].'/myoffice">MyOffice</a>&gt;MyDesk&gt;In Progress list.</p><p>Next step is to finish the '.us_dev.' as soon as possible and click on '.us_dev.' is done button located in this list, or on <a href="http://'.$_SERVER['HTTP_HOST'].'/project/scrum_board/'.$work_data[0]['project_id'].'/'.$work_data[0]['sprint'].'">'.sb_dev.'</a> or within <a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$work_data[0]['work_id'].'">'.us_dev.' detail</a> page. Here are some tips for you: <ol><li>If you are new to the project, first step is to read about the <a href="http://'.$_SERVER['HTTP_HOST'].'/project/'.$work_data[0]['project_id'].'">project</a> itslef.</li><li>Go through details of the '.us_dev.'. If it\'s not clear or if you need any furthur info, use the \'Discuss\' section to contact the '.po_dev.' and '.sm_dev.'.</li><li>required files might be attached to the '.us_dev.' or be provided later by '.sm_dev.'/'.po_dev.' or be presented as a link within <a href="http://'.$_SERVER['HTTP_HOST'].'/project/'.$work_data[0]['project_id'].'">project detail page</a>.</li><li>Test, test and test. Make sure everything works before submission.</li><li>For submission refer to project submission terms and essentials of this '.us_dev.'. You might be required to eaither use a github repository (forked from main project) or upload the files as a zip or add a remote link to the files.</li></ol></p>';
				   $short_message = '<p>Congradulations! You won the bidding on \'<a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$work_data[0]['work_id'].'">'.$work_data[0]['title'].'</a>\'. Finish the '.us_dev.' before deadline for maximum points.</p>';
				   $this->notify(noreply_email,email_name, $to, admin_cc, $title,$message, 'bid', $to_id, $short_message, $this->session->userdata('user_id'));
				   $data = array(
					"user_id" => $to_id,
					"title" => "Assignment",
					"message" => "<p>".us_dev." <a href='http://".$_SERVER['HTTP_HOST']."/story/".$work_data[0]['work_id']."'>'".$work_data[0]['title']."'</a> is assigned to you.</p>",
					"status" => 'unread',
					"created_at" => date('Y-m-d'),
					"target_id" => $this->session->userdata('user_id'),
					"category" => 'job'
					);
					$this->db->insert('inbox',$data);
				   $project_id =$work_data[0]['project_id'];
				   $user_id = $usr_data[0]['user_id'];
				   $this->stories->log_history($user_id, $project_id, $work_id, 'win', $cost, $desc = '');
			   }
			   if($ref=='story'){
				   redirect("/story/$work_id");
			   }else{
               	   redirect("/project/story_management");
			   }
        }
        
        function edit($id) {
			$this->check_authentication();
			$user_id = $this->session->userdata('user_id');
			$me = $this->users_model->get_user($user_id);
			$me = $me->result_array();
			$me = $me[0];
			$myProfile = $this->users_model->get_profile($user_id);
			$myProfile = $myProfile->result_array();
			$myProfile = $myProfile[0];
			$this->view_data['me'] = $me;
			$this->view_data['myProfile'] = $myProfile;
			
			$this->view_data['window_title'] = "Edit the ".ucfirst(us_dev)." | Workpad";
            $query = $this->stories->get_work_details($id);
            $data = $query->result_array();
            //print_r($data);
			$this->view_data['story_data'] = $data[0];
            $this->view_data['story_id'] = $id;
			
			if($this->projects_model->is_project_owner($user_id, $this->view_data['story_data']['project_id'])){
				//only product owner can edit the job
				$this->load->library('ckeditor');
				$this->load->library('ckFinder');
				//configure base path of ckeditor folder 
				$this->ckeditor->basePath = base_url().'public/scripts/ckeditor/';
				$this->ckeditor-> config['toolbar'] = 'Full';
				$this->ckeditor->config['language'] = 'en';
				//configure ckfinder with ckeditor config 
				$this->ckfinder->SetupCKEditor($this->ckeditor,'/public/js/ckfinder/');
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
										redirect('/project/sprint_planner/'.$this->view_data['story_data']['project_id']);
									} //else { // - if there is a problem writing to db
										//redirect(base_url()."error");
									//}
								}
							}
			}
			$this->load->view('story_edit_view', $this->view_data);
        }
		
		function done(){
			$this->check_authentication();
			$has_upload_error= false;
			if($this->input->post('csrf')==md5('storyDone')){
				$story_id = $this->input->post('id');
				$work = $this->stories->get_work($story_id);
				$work_data = $work->result_array();
				$user_id = $this->session->userdata('user_id');
				if($work_data[0]['work_horse']==$user_id){
					//only work horse can finish the job
					$story_id = $this->input->post('id');
					
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'zip|tgz|tar|gz|gtar';
					$config['max_size']	= '51200';
					$config['overwrite'] = false;
					$config['encrypt_name'] = true;
					$config['remove_spaces'] = true;
					$this->load->library('upload', $config);
					if (strlen($_FILES["file_upload"]["name"])>0) {
						if($this->upload->do_upload("file_upload")){
							$uploaded = $this->upload->data();
							$path = $config['upload_path'].$uploaded['file_name'];
						}else{
							$error = array('error' => $this->upload->display_errors());
							$this->view_data['error'] = $error;
							$path="";
							$has_upload_error= true;
							$this->view_data['modal_title'] = 'Error';
							$this->view_data['modal_message'] = $this->upload->display_errors();
							///////upload error show back submission page
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
								$this->view_data['window_title'] = "Submission | Workpad";
								$this->load->view('story_submission_view', $this->view_data);		
							} else {
								$this->view_data['window_title'] = "Error, ".us_dev." (".$work_id.") does not exist.";
								$this->load->view('story_error_view', $this->view_data);
							}
							///////////////////
						}
					}else{
						$path="";
					}
					if(!$has_upload_error){
						$query = $this->stories->done($story_id,$path);
						$work = $this->stories->get_work($this->input->post('id'));
						$work_data = $work->result_array();
						$title = $work_data[0]['title'].' is completed.';
						$point = $work_data[0]['points'];
						$project = $this->projects_model->get_project_details($work_data[0]['project_id']);
						$project = $project->result_array();
						$project_owner = $this->users_model->get_user($project[0]['project_owner_id']);
						$project_owner = $project_owner->result_array();
						$scrum_master = $this->users_model->get_user($project[0]['scrum_master_id']);
						$scrum_master = $scrum_master->result_array();
						
						$message = '<p>Hello '.$project_owner[0]['username'].',</p><p>User <a href="http://'.$_SERVER['HTTP_HOST'].'/user/'.$this->session->userdata('user_id').'">'.$this->session->userdata('username').'</a> has completed the '.us_manager.' \'<a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$work_data[0]['work_id'].'">'.$work_data[0]['title'].'</a>\'.</p><p>Now <a href="http://'.$_SERVER['HTTP_HOST'].'/user/'.$scrum_master[0]['user_id'].'">'.sm_manager.'</a> or <a href="http://'.$_SERVER['HTTP_HOST'].'/user/'.$project_owner[0]['user_id'].'">'.po_manager.'</a> is required to verify the '.us_manager.'. For furthur actions please refer to the <a href="http://'.$_SERVER['HTTP_HOST'].'/project/scrum_board/'.$work_data[0]['project_id'].'/'.$work_data[0]['sprint'].'">'.sb_manager.'</a> of this project.</p><p>Regards.</p>';
						$short_message = '<p>Story \'<a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$work_data[0]['work_id'].'">'.$work_data[0]['title'].'</a\'> is completed by <a href="http://'.$_SERVER['HTTP_HOST'].'/user/'.$this->session->userdata('user_id').'">'.$this->session->userdata('username').'</a>. Please verify this story on the <a href="http://'.$_SERVER['HTTP_HOST'].'/project/scrum_board/'.$work_data[0]['project_id'].'/'.$work_data[0]['sprint'].'">'.sb_manager.'</a>.</p>';
						$to = array();
						$to_id = array();
						$to[] = $project_owner[0]['email'];
						$to_id[] = $project_owner[0]['user_id'];
						if($project_owner[0]['user_id']!=$scrum_master[0]['user_id']){
							$to[] = $scrum_master[0]['email'];
							$to_id[] = $scrum_master[0]['user_id'];
						}
						$this->notify(noreply_email,email_name, $to, admin_email, $title,$message, 'job', $to_id, $short_message, $this->session->userdata('user_id'));
						
						$title = $work_data[0]['title'].' is submited.';
						$query = $this->stories->get_user_email($story_id);
						$user_data = $query->result_array();
						$to = $user_data[0]['email'];
						$message = '<p>Hi '.$user_data[0]['username'].',</p><p>You have submited the '.us_dev.' \'<a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$work_data[0]['work_id'].'">'.$work_data[0]['title'].'</a>\'. Once the '.us_dev.' is verified by '.sm_dev.' and signed off by '.po_dev.' you will be credited with its value.</p><p>Thanks.</p>';
						$short_message = '<p>Your submission of '.us_dev.' \'<a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$work_data[0]['work_id'].'">'.$work_data[0]['title'].'</a>\' is sent for verification. You will be credited once the '.us_dev.' is verified by '.sm_dev.' and signed off by '.po_dev.'.</p>';
						//$this->notify(admin_email,email_name, $to, admin_cc, $title,$message);
						$this->users_model->notify($user_data[0]['user_id'], $title, $message, 'job', $short_message, $user_id);
						
						$project_id =$work_data[0]['project_id'];
						$user_id = $this->session->userdata('user_id');
						
						$this->stories->log_history($user_id, $project_id, $story_id, 'done', $point, $desc = '');
		
						redirect("/story/".$story_id);
					}
				}
			}
		}
		
		function redo($id){
			$this->check_authentication();
			$story_id = $id;
			$work = $this->stories->get_work($story_id);
			$work_data = $work->result_array();
			$user_id = $this->session->userdata('user_id');
			if($this->projects_model->is_scrum_master($user_id, $work_data[0]['project_id'])){
				//only scrum master can tag as redo
				$query = $this->stories->redo($story_id);
				$title = $work_data[0]['title'].' needs more work.';
				$query = $this->stories->get_user_email($story_id);
				$user_data = $query->result_array();
				$to = $user_data[0]['email'];
				$message = '<p>Hi '.$user_data[0]['username'].',</p><p>The '.us_dev.' \'<a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$work_data[0]['work_id'].'">'.$work_data[0]['title'].'</a>\' needs more work. Please refer to the discussion section of '.us_dev.' and discuss furthur requirements with the '.sm_dev.' or '.po_dev.'.</p><p>Thanks.</p>';
				$short_message = '<p>'.ucwords(us_dev).' \'<a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$work_data[0]['work_id'].'">'.$work_data[0]['title'].'</a>\' needs more work. Please refer to the discussion section of '.us_dev.' and discuss furthur requirements with the '.sm_dev.' or '.po_dev.'.</p>';
				//$this->notify(admin_email,email_name, $to, admin_cc, $title,$message);
				$this->users_model->notify($user_data[0]['user_id'], $title, $message, 'job', $short_message, $this->session->userdata('user_id'));
				$project_id = $work_data[0]['project_id'];
				$sprint = $work_data[0]['sprint'];
				$point = $work_data[0]['points'];
				$user_id = $user_data[0]['user_id'];
				$this->stories->log_history($user_id, $project_id, $story_id, 'redo', $point, $desc = '');
			}
			redirect("/project/scrum_board/$project_id/$sprint");
		}
		
		function verify($id){
			$this->check_authentication();
			$story_id = $id;
			$work = $this->stories->get_work($story_id);
			$work_data = $work->result_array();
			$project = $this->projects_model->get_project_details($work_data[0]['project_id']);
			$project = $project->result_array();
			$project_owner = $this->users_model->get_user($project[0]['project_owner_id']);
			$project_owner = $project_owner->result_array();
			$user_id = $this->session->userdata('user_id');
			if($this->projects_model->is_scrum_master($user_id, $work_data[0]['project_id'])){
				//only scrum master can verify
				$query = $this->stories->verify($story_id);		
				$title = $work_data[0]['title'].' is verified.';
				$query = $this->stories->get_user_email($story_id);
				$user_data = $query->result_array();
				$to = $user_data[0]['email'];
				$message = '<p>Hi '.$user_data[0]['username'].',</p><p>The '.us_dev.' \'<a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$story_id.'">'.$work_data[0]['title'].'</a>\' is verified by '.sm_dev.'. Now this '.us_dev.' is awaiting for approval of '.po_dev.'. The payment will be signed off upon approval of '.po_dev.'.</p><p>Regards.</p>';
				$short_message = '<p>'.ucwords(us_dev).' \'<a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$story_id.'">'.$work_data[0]['title'].'</a>\' is verified by <a href="http://'.$_SERVER['HTTP_HOST'].'/user/'.$this->session->userdata('user_id').'">'.sm_dev.'</a>. Now this '.us_dev.' is awaiting for approval of <a href="http://'.$_SERVER['HTTP_HOST'].'/user/'.$project_owner[0]['user_id'].'">'.po_dev.'</a>.</p>';
				$short_message_for_po = '<p>'.ucwords(us_dev).' \'<a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$story_id.'">'.$work_data[0]['title'].'</a>\' is verified by <a href="http://'.$_SERVER['HTTP_HOST'].'/user/'.$this->session->userdata('user_id').'">'.sm_dev.'</a>. Now this '.us_dev.' is awaiting for approval of you as '.po_manager.'.</p>';
				//$this->notify(admin_email,email_name, $to, admin_cc, $title,$message);
				$this->users_model->notify($user_data[0]['user_id'], $title, $message, 'job', $short_message, $this->session->userdata('user_id'));
				$this->users_model->notify($project_owner[0]['user_id'], $title, $message, 'job', $short_message, $this->session->userdata('user_id'));
				
				$project_id = $work_data[0]['project_id'];
				$sprint = $work_data[0]['sprint'];
				$point = $work_data[0]['points'];
				$user_id = $user_data[0]['user_id'];
				$this->stories->log_history($user_id, $project_id, $story_id, 'verify', $point, $desc = '');
			}
			redirect("/project/scrum_board/$project_id/$sprint");
		}
		
		function signoff($id){
			$this->check_authentication();
			$story_id = $id;
			$work = $this->stories->get_work($story_id);
			$work_data = $work->result_array();
			$user_id = $this->session->userdata('user_id');
			if($this->projects_model->is_project_owner($user_id, $work_data[0]['project_id'])){
				//only product owner can sign off the work
				$query = $this->stories->signoff($story_id);
				$title = $work_data[0]['title'].' is Signedoff.';
				$query = $this->stories->get_user_email($story_id);
				$user_data = $query->result_array();
				$project = $this->projects_model->get_project_details($work_data[0]['project_id']);
				$project = $project->result_array();
				$scrum_master = $this->users_model->get_user($project[0]['scrum_master_id']);
				$scrum_master = $scrum_master->result_array();
				
				$to = array();
				$to_id = array();
				$to[] = $user_data[0]['email'];
				if($scrum_master[0]['email']!=$user_data[0]['email'])
					$to[] = $scrum_master[0]['email'];
				$to_id[] = $user_data[0]['user_id'];
				if($scrum_master[0]['user_id']!=$user_data[0]['user_id'])
					$to_id[] = $scrum_master[0]['user_id'];
				$message = '<p>Hello,</p><p>The '.us_dev.' \'<a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$story_id.'">'.$work_data[0]['title'].'</a>\' is signed off.</p><p>Good job and thanks.</p>';
				$short_message = '<p>The '.us_dev.' \'<a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$story_id.'">'.$work_data[0]['title'].'</a>\' is signed off.</p><p>Good job and thanks.</p>';
				$this->notify(noreply_email,email_name, $to, admin_cc, $title,$message, 'job', $to_id, $short_message, $user_id);
				
				$project_id = $work_data[0]['project_id'];
				$sprint = $work_data[0]['sprint'];
				$point = $work_data[0]['points'];
				$user_id = $user_data[0]['user_id'];
				$this->stories->log_history($user_id, $project_id, $story_id, 'signoff', $point, $desc = '');
			}
			redirect("/project/scrum_board/$project_id/$sprint");		
		}
		
		function reject($id){
			$this->check_authentication();
			$story_id = $id;
			$work = $this->stories->get_work($story_id);
			$work_data = $work->result_array();
			$user_id = $this->session->userdata('user_id');
			if($this->projects_model->is_project_owner($user_id, $work_data[0]['project_id'])){
				//only product owner can reject the work
				$query = $this->stories->get_user_email($story_id);
				$user_data = $query->result_array();
				$query = $this->stories->reject($story_id);	
				$title = $work_data[0]['title'].' is rejected!';
				$to = $user_data[0]['email'];
				$message = '<p>Hello,</p><p>unfortunately the '.us_dev.' \'<a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$story_id.'">'.$work_data[0]['title'].'</a>\' has failed to meet requirements of '.po_dev.' and is rejected. For more info please refer to the discussion section of this user sotry.</p><p>As a result this failure, '.us_dev.' will be set to open for bidding again.</p><p>Regards.</p>';
				$short_message = '<p>unfortunately the '.us_dev.' \'<a href="http://'.$_SERVER['HTTP_HOST'].'/story/'.$story_id.'">'.$work_data[0]['title'].'</a>\' has failed to meet requirements of '.po_dev.' and is rejected.</p>';
				//$this->notify(admin_email,email_name, $to, admin_cc, $title,$message);
				$this->users_model->notify($user_data[0]['user_id'], $title, $message, 'job', $short_message, $user_id);
				
				$project = $this->projects_model->get_project_details($work_data[0]['project_id']);
				$project = $project->result_array();
				$scrum_master = $this->users_model->get_user($project[0]['scrum_master_id']);
				$scrum_master = $scrum_master->result_array();
				$to = $scrum_master[0]['email'];
				$to_id = $scrum_master[0]['user_id'];
				if($user_data[0]['user_id']!=$to) $this->notify(noreply_email,email_name, $to, admin_cc, $title,$message, 'job', $to_id, $short_message);
				$project_id = $work_data[0]['project_id'];
				$sprint = $work_data[0]['sprint'];
				$point = $work_data[0]['points'];
				$user_id = $user_data[0]['user_id'];
				$this->stories->log_history($user_id, $project_id, $story_id, 'reject', $point, $desc = '');
			}
			redirect("/project/scrum_board/$project_id/$sprint");	
		}
		
		function submission(){
			$work_id = $this->input->post('id');
			// get stories 
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
				$this->view_data['window_title'] = "Submission | Workpad";
				$this->load->view('story_submission_view', $this->view_data);		
			} else {
				$this->view_data['window_title'] = "Error, ".us_dev." (".$work_id.") does not exist.";
				$this->load->view('story_error_view', $this->view_data);
			}
		}
		
		function upload_files(){
				
		}
				
		private function notify($from,$fromName, $to, $cc, $subject, $message, $category=NULL, $to_id = NULL, $shor_message = "", $target_id = NULL, $link= NULL){
			$this->inbox($subject, $message, $category, $to_id, $shor_message, $target_id, $link);
			$this->email($from,$fromName, $to, $subject, $message);
		}
		
		private function email($from,$fromName, $to, $subject, $message){
			if(count($to)>0){
				require_once(getcwd()."/application/helpers/phpmailer/class.phpmailer.php");
				$mail = new PHPMailer();
				$mail->IsSMTP();                                      // set mailer to use SMTP
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				//$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
				$mail->Host       = "mail.vakilian.net";      // sets GMAIL as the SMTP server
				//$mail->Port       = 110;                   // set the SMTP port for the GMAIL server
				$mail->Username = "noreply@vakilian.net";  // SMTP username
				$mail->Password = "work123"; // SMTP password
				//$mail->SMTPDebug  = 1;
				$mail->SetFrom($from, $fromName);
				if(is_array($to)){
					foreach($to as $too)$mail->AddAddress($too);
				}else{
					$mail->AddAddress($to);
				}
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
			}
		}
		
		private function inbox($subject, $message, $category=NULL, $to_id = NULL, $shor_message = "", $target_id = NULL, $link = NULL){
			if(is_array($to_id)){
				// send to inbox
				$data = array();
				foreach($to_id as $user_id){
					$data[] = array(
						"user_id" => $user_id,
						"title" => $subject,
						"target_id" => $target_id,
						"link" => $link,
						"message" => ($shor_message=="")?$message:$shor_message,
						"status" => 'unread',
						"created_at" => date('Y-m-d'),
						"category" => $category
					);
				}
				if(count($data)>0)
					$this->db->insert_batch('inbox',$data);
			}elseif(!is_null($to_id)){
				// send to inbox
				$data = array(
					"user_id" => $to_id,
					"target_id" => $target_id,
					"title" => $subject,
					"link" => $link,
					"message" => ($shor_message=="")?$message:$shor_message,
					"status" => 'unread',
					"created_at" => date('Y-m-d'),
					"category" => $category
				);
				$this->db->insert('inbox',$data);
			}
		}
}