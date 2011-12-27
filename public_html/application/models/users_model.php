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
			"created_at" => date('Y-m-d H:i:s'),
			"role" => 'user',
			"user_status" => 'disable'
		); 
		$res = $this->db->insert('users', $doc);
		$this->create_new_profile($user_id);
		return $res;
	}
	
	public function promote($user_id){
		$query = $this->db->get_where('users', array('user_id' => $user_id));
		if($query->num_rows()>0){
			$query = $query->result_array();
			$user = $query[0];
			if($user['user_status']=='enable'){
				if($user['role']=='user'){
					$this->db->update('users',array('user_status'=>'enable', 'role'=>'admin'),array('user_id'=>$user_id));		
				}
			}else{
				$this->db->update('users',array('user_status'=>'enable', 'role'=>'user'),array('user_id'=>$user_id));	
			}
		}
	}
	
	public function demote($user_id){
		$query = $this->db->get_where('users', array('user_id' => $user_id));
		if($query->num_rows()>0){
			$query = $query->result_array();
			$user = $query[0];
			if($user['role']=='admin'){
				$this->db->update('users',array('user_status'=>'enable', 'role'=>'user'),array('user_id'=>$user_id));		
			}else{
				if($user['user_status']=='enable')
				$this->db->update('users',array('user_status'=>'disable', 'role'=>'user'),array('user_id'=>$user_id));	
			}
		}
	}
	
	public function get_all_users($sort_by=NULL){
		$sql = "SELECT * from users ";
		switch($sort_by):
			case 'username': $sql.="order by username";break;
			case 'user_id': $sql.="order by user_id";break;
			case 'role': $sql.="order by role";break;
			case 'status': $sql.="order by user_status";break;
			case 'created': $sql.="order by created_at";break;
			case 'login': $sql.="order by last_login";break;
		endswitch;
		$res = $this->db->query($sql);
		return $res->result_array();
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
			"lan_rw" => $this->input->post('lan_rw'),
			"gender" => $this->input->post('gender'),
			"birthdate" => $this->input->post('birth_year').'-'.$this->input->post('birth_month').'-'.$this->input->post('birth_day'),
			"specialization" => $this->input->post('specialization')
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
	
	function get_contacts(){
		$sql = "SELECT count(*) as num from works where LOWER(status) in ('in progress', 'done' , 'redo', 'verify' , 'signoff')";
		$result = $this->db->query($sql);
		if($result->num_rows>0){
			$result = $result->result_array();
			return $result[0]['num'];
		}else return 0;
		
	}
	
	function leaderboard_projects($limit=0){
		if($limit>0){
			$query = "select users.user_id, users.username, avatar, count(*) as num from (select users.*, avatar from users left join user_profiles on users.user_id = user_profiles.user_id) as users, works where users.user_id = works.work_horse and lower(works.status) in ('verify', 'signoff') group by users.user_id, users.username, avatar order by num desc, users.exp desc limit 0,".$limit;	
		}else{
			$query = "select users.user_id, users.username, avatar, count(*) as num from (select users.*, avatar from users left join user_profiles on users.user_id = user_profiles.user_id) as users, works where users.user_id = works.work_horse and lower(works.status) in ('verify', 'signoff') group by users.user_id, users.username, avatar order by num desc, users.exp desc";
		}
		$result = $this->db->query($query,array());
		$data = $result->result_array();
		return $data;
	}
	
	function leaderboard_points($limit=0){
		if($limit>0){
			$query = "select * from (select users.user_id, username, avatar, exp,hour_spent from users left join user_profiles on users.user_id = user_profiles.user_id) as t where exp>0 order by exp DESC, hour_spent desc limit 0,".$limit;
		}else{
			$query = "select * from (select users.user_id, username, avatar, exp,hour_spent from users left join user_profiles on users.user_id = user_profiles.user_id) as t where exp>0 order by exp DESC, hour_spent desc";
		}
		$result = $this->db->query($query);
		$data = $result->result_array();
		return $data;
	}
	
	function leaderboard_time($limit=0){
		if($limit>0){
			$query = "select user_id, username, avatar, user.exp as xp, sum(hour(timediff(deadline, done_at))) as exp from (select users.*, avatar from users left join user_profiles on users.user_id = user_profiles.user_id) as user,works where works.work_horse = user.user_id and lower(works.status) in ('verify','signoff') group by user_id, username, avatar, user.exp having exp>0 order by exp desc, xp desc limit 0,".$limit;
		}else{
			$query = "select user_id, username, avatar, users.exp as xp, sum(hour(timediff(deadline, done_at))) as exp from (select users.*, avatar from users left join user_profiles on users.user_id = user_profiles.user_id) as users,works where works.work_horse = users.user_id and lower(works.status) in ('verify','signoff') group by user_id, username, avatar, users.exp having exp>0 order by exp desc, xp desc";
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
	
	function works_compeleted($user_id){
		$sql ="SELECT count(*) as num FROM works where work_horse = ? and lower(works.status) in ('verify', 'signoff')";
		$res = $this->db->query($sql, array($user_id));
		$data = $res->result_array();
		return $data[0]['num'];
	}
	
	function hours_spent($user_id){
		$sql = "select sum(hour(TIMEDIFF(done_at, assigned_at))) as num from works where (lower(works.status) in ('verify', 'signoff')) and work_horse = ?";
		$res = $this->db->query($sql, array($user_id));
		$data = $res->result_array();
		return $data[0]['num'];	
	}
	
	function hours_saved($user_id){
		$sql = "select sum(hour(TIMEDIFF(deadline, done_at))) as num from works where !isnull(deadline) and (lower(works.status) in ('verify', 'signoff')) and work_horse = ?";
		$res = $this->db->query($sql, array($user_id));
		$data = $res->result_array();
		return $data[0]['num'];	
	}
	
	function last_task($user_id){
		$sql = "SELECT works.*, project_name from works, project where (lower(works.status) in ('done','redo','verify','signoff','reject')) and works.project_id = project.project_id and work_horse = ? order by done_at DESC limit 0,1";
		$res = $this->db->query($sql, array($user_id));
		if($res->num_rows>0){
			$data = $res->result_array();
			return $data[0];	
		}else{ return false;}
	}
	
	function working_on($user_id){
		$sql = "SELECT works.*, project_name from works, project where (lower(works.status) in ('in progress','redo')) and works.project_id = project.project_id and work_horse = ? order by assigned_at DESC";
		$res = $this->db->query($sql, array($user_id));
		if($res->num_rows>0){
			$data = $res->result_array();
			return $data;
		}else{ return false;}
	}
	
	function collaborators($user_id){
		$sql = "select avatar, user_id from user_profiles where user_id != ? and user_id in (select distinct work_horse from works where project_id in (SELECT DISTINCT project_id from works where works.work_horse = ?)) limit 0,6";
		$res = $this->db->query($sql , array($user_id, $user_id));
		if($res->num_rows>0){
			return $res->result_array();
		}else{
			return false;
		}
	}
	
	function recommendation($user_id, $num=5){
		$sql = "SELECT * from works,(SELECT count(work_id) as num, work_skill.work_id from skill_set,work_skill where work_skill.skill_id = skill_set.skill_id and user_id = ? group by work_skill.work_id order by num DESC) as t where t.work_id = works.work_id and lower(works.status) in ('open','reject') limit 0, ".$num;
		$res = $this->db->query($sql, array($user_id));
		if($res->num_rows()>0){
			$res = $res->result_array();
			return $res;
		}else{
			return false;
		}
	}
	
	function reset_pass_notify($username){
		$user = $this->get_user($username,'username');
		if($user->num_rows()>0){
			$user = $user->result_array();
			$user = $user[0];
			$doc = array(
				'code' => md5(date('Y-m-d H:i:s').$user['user_id'].'pass'),
				'action' => 'pass',
				'user_id' => $user['user_id'],
				'created_at' => date('Y-m-d H:i:s'),
				'validity' => date('Y-m-d H:i:s', time()+60*60),
			);
			$this->notify($user['user_id'],'Password Reset',"We recieved a request regarding reseting your password. If you wish to proceed with this action click on following link: <a href='".base_url()."login/recovery/".$doc['code']."'>reset password</a>");
			$this->db->insert('actions', $doc);
			return "An email is sent to you containing furthur instuctions...";
		}else return "Uername doesn't exist!";
	}
	
	function reset_pass($code){
		$sql = "SELECT * from actions where code=? and validity>?";
		$res = $this->db->query($sql, array($code, date('Y-m-d H:i:s')));
		if($res->num_rows()>0){
			$action = $res->result_array();
			$action = $action[0];
			$user = $this->get_user($action['user_id']);
			if($user->num_rows()>0){
				$user = $user->result_array();
				$user = $user[0];
				$newPass = $this->createRandomPassword();
				$sql = "update users set secret=? where user_id=?";
				$this->notify($user['user_id'], 'Your Password Reseted',"Your password on Workpad is reseted to: ".$newPass);
				$this->db->query($sql, array(md5($newPass),$user['user_id']));
				return "Dear ".$user['username'].", an email is sent to you containing your new password.";
			}else return "Error: Invalid Code!";
			$sql = "DELETE FROM actions where code = ?";
			$this->db->query($sql, array($code));
		}else{
			return "Error: Invalid Code!";
		}
	}
	
	function createRandomPassword() { 
		$chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
		srand((double)microtime()*1000000); 
		$i = 0; 
		$pass = '' ; 
	
		while ($i <= 7) { 
			$num = rand() % 33; 
			$tmp = substr($chars, $num, 1); 
			$pass = $pass . $tmp; 
			$i++; 
		} 
	
		return $pass; 
	} 
	
	function list_users(){
		$sql = "SELECT * from users where user_status='enable'";
		$res=$this->db->query($sql);
		return $res->result_array();
	}
	
	function notify($user_id, $subject, $message){		
			ini_set('display_error',0);
			error_reporting('E_ALL');
			$q = $user_id;
			
			$query = $this->db->get_where('users', array('user_id' => $q));
			if($query->num_rows>0){
				$query = $query->result_array();
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