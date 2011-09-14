<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model { 
	var $data = '';
	
	function __construct() {
		parent::__construct();
	}
	
	// create new user 
	public function create_new_user() {
	    $user_id = md5(microtime());
		$doc = array(
			"user_id" => $user_id,
			"username" => strtolower($this->input->post('username')),
			"secret" => md5($this->input->post('password')),
			"email" => strtolower($this->input->post('email')),
			"created_at" => date('Y-m-d H:i:s')
		); 
		$this->create_new_profile($user_id);
		return $this->db->insert('users', $doc);
	}
	
	// create new profiles
	public function create_new_profile($user_id) {
		$doc = array(
			"user_id" => $user_id
		); 
		return $this->db->insert('user_profiles', $doc);
	}
	
	// get user data
	public function get_user($q = '', $request_type = 'user_id') {
		switch($request_type) {
			case 'user_id':
				$query = $this->db->get_where('users', array('user_id' => $q));
				break;
			
			case 'email': 
				$query = $this->db->get_where('users', array('email' => $q));
				break;
				
			case 'username':
				$query = $this->db->get_where('users', array('username' => $q));
				break;
				
			default: 
				$query = false;
				break;
		}
		
		if($query) {
			if($query->num_rows() > 0) {
				$result = $query; 
			} else { $result = false; }
		} else { $result = false; }
		
		return $result;
 	}
	
	//validate login
	function validate() {
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('secret', md5($this->input->post('password')));
		$query = $this->db->get('users');
		if($query->num_rows == 1) {
			return $query;
		}
		else {
			return false;
		}
	}
		
	//get profile	
	function get_profile($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('user_profiles');
		if($query->num_rows == 1) {
				return $query;
			}
			else {
				return false;
			}		
	}
	
	//update profile
	function update_profile($user_id,$avatar) {
		//structure the profile data
		$contact = array(
			"mobile_no" => $this->input->post('mobile_no'),
			"city" => $this->input->post('city'),
			"country" => $this->input->post('country')
			);
		
		$urls = array(
			"facebook" => $this->input->post('fb_url'),
			"twitter" => $this->input->post('twit'),
			"linkedin" => $this->input->post('linkedin'),
			"github" => $this->input->post('github'),
			"portfolio" => $this->input->post('portfolio')						
		);
		
		$contact = json_encode($contact);
		$urls = json_encode($urls);
		
		$doc = array(
			"full_name" => $this->input->post('full_name'),
			"bank_name" => $this->input->post('bank_name'),
			"bank_acc" => $this->input->post('bank_acc'),
			"paypal_acc" => $this->input->post('paypal'),
			"contact" => $contact,
			"urls" => $urls,
			"lan_speak" => $this->input->post('lan_speak'),
			"lan_rw" => $this->input->post('lan_rw')
		);
		
		if($avatar!=""){
			//assign the new avatar
	        $relative_url = 'images/profile/'.$avatar;
    	    $doc['avatar'] = $relative_url;
    	}

		//update profile
		return $this->db->update('user_profiles', $doc, array('user_id' => $user_id));
	}
	
	function update_last_login($user_id){
		$doc2 = array(
			"last_login" => date('Y-m-d H:i:s')
		);
		return $this->db->update('users', $doc2, array('user_id' => $user_id));	
	}
	
	function update_password($user_id) {
		$secret = md5($this->input->post('n_pwd'));
		$doc2 = array(
			"secret" => $secret
		);
		
		return $this->db->update('users', $doc2, array('user_id' => $user_id));
	}
	
	function have_project($user_id) {
		$query = "SELECT * FROM project WHERE project_owner_id = ?";
		$result = $this->db->query($query, array($user_id));
		
		if($result->num_rows() > 0) {
			return true;
		}
	}
	
	function getNumOnline(){
		$query = "select count(*) as num from ci_sessions where user_data!='' and last_activity> ?";
		$result = $this->db->query($query, array(time()-2*60*60));
		$data = $result->result_array();
		return $data[0]['num'];
	}
	
	function getNumRegistration(){
		$query = "select count(*) as num from users";
		$result = $this->db->query($query, array());
		$data = $result->result_array();
		return $data[0]['num'];
	}
	
	function getVisitors(){
		$query = "select count(*) as num from ci_sessions where last_activity> ?";
		$result = $this->db->query($query, array(time()-2*60*60));
		$data = $result->result_array();
		return $data[0]['num'];	
	}
	
	function getActiveUsers(){
		$query = "select count(*)as num from users where last_login > ?";
		$result = $this->db->query($query,array(date('Y-m-d H:i:s', strtotime('-3 month'))));
		$data = $result->result_array();
		return $data[0]['num'];
	}
	
	function leaderboard_projects($limit=0){
		if($limit>0){
			$query = "select users.user_id, users.username, count(*) as num from users, works, user_profiles where users.user_id = works.work_horse and works.status in ('Verify', 'Signoff') group by users.user_id order by num desc limit 0,".$limit;	
		}else{
			$query = "select users.user_id, users.username, count(*) as num from users, works where users.user_id = works.work_horse and works.status in ('Verify', 'Signoff') group by users.user_id order by num desc";
		}
		$result = $this->db->query($query,array());
		$data = $result->result_array();
		return $data;
	}
	
	function leaderboard_points($limit=0){
		if($limit>0){
			$query = "select user_id, username, exp from users order by exp desc limit 0,".$limit;
		}else{
			$query = "select user_id, username, exp from users order by exp desc";
		}
		$result = $this->db->query($query);
		$data = $result->result_array();
		return $data;
	}
	
	function leaderboard_time($limit=0){
		if($limit>0){
			$query = "select user_id, username, sum(hour(timediff(deadline, done_at))) as exp from users,works where works.work_horse = users.user_id group by user_id, username having exp>0 order by exp desc limit 0,".$limit;
		}else{
			$query = "select user_id, username, sum(hour(timediff(deadline, done_at))) as exp from users,works where works.work_horse = users.user_id group by user_id, username having exp>0 order by exp desc";
		}
		$result = $this->db->query($query);
		$data = $result->result_array();
		return $data;
	}
	
	function inbox_messages($user_id){
		$query = "SELECT * from inbox where user_id = ? order by id DESC";
		$data = $this->db->query($query, array($user_id));
		$data = $data->result_array();	
		return $data;
	}
	
	function inbox_count_unread($user_id){
		$query = "SELECT count(*) as num from inbox where user_id = ? and status = 'unread'";
		$data = $this->db->query($query, array($user_id));
		$data = $data->result_array();	
		return $data[0]['num'];
	}
	
	function notify($user_id, $subject, $message){		
			ini_set('display_error',0);
			error_reporting('E_ALL');
			$query = $this->db->get_where('users', array('user_id' => $q));
			if($query.num_rows>0){
				$query = $query.result_array();
				$to = $query[0]['email'];
			}
			
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
			
			// send to inbox
			$data = array(
				"user_id" => $user_id,
				"title" => $subject,
				"message" => $message,
				"status" => 'unread',
				"created_at" => date('Y-m-d')
			);
			$this->db->insert('inbox',$data);
			
			if(!$mail->Send())
			{
			   echo "Message could not be sent. <p>";
			   echo "Mailer Error: " . $mail->ErrorInfo;
			   exit;
			}
			
		}
}