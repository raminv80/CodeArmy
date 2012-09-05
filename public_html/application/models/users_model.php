<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model { 
	var $data = '';
	
	function __construct() {
		parent::__construct();
	}
	
	private function gen_userId(){
		$id = md5(microtime());
		$query = $this->db->get_where('users', array('user_id' => $id));
		while($query->num_rows() > 0){
			$id = md5(microtime().rand());
			$query = $this->db->get_where('users', array('user_id' => $id));
		}
		return $id;	
	}
	
	// create new user 
	public function create_new_user() {
	    $user_id = gen_userId();
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
	
	public function create_new_user_v5() {
		$user_id = gen_userId();
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
		//$this->assign_skill('communication', $user_id);
		//$this->assign_skill('Leadership', $user_id);
		return $res;
	}
	
	public function create_new_user_codearmy() {
		$user_id = $this->gen_userId();
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
		$this->create_new_profile($user_id, $this->input->post('dob'));
		//$this->assign_skill('communication', $user_id);
		//$this->assign_skill('Leadership', $user_id);
		$data = array(
			'username' => $this->input->post('username'),
			'user_id' => $user_id,
			'role' => 'user',
			'level' => 1,
			'tutorial' => 0,
			'is_logged_in' => true
		);
		$this->session->set_userdata($data);
		return $user_id;
	}
	
	public function reg_division($div){
		if(in_array($div,array('designer','developer','copywriter'))){
			$sql = "UPDATE user_profiles set specialization=LOWER(?) WHERE user_id = ? and (isNULL(specialization) OR specialization='unknown')";
			$res = $this->db->query($sql, array($div, $this->session->userdata('user_id')));
			return $res;
		}
	}
	
	public function assign_skill($skill_name, $user_id){
		$sql = "select id from skill where LOWER(name) = LOWER(?)";
		$res = $this->db->query($sql, array($skill_name));
		if($res->num_rows>0){
			$res = $res->result_array();
			$skill_id = $res[0]['id'];
			$doc = array(
				"user_id" => $user_id,
				"skill_id" => $skill_id,
				"point" => 0,
				"claim" => 0
			);
			$this->db->insert('skill_set', $doc);
		}
	}
	
	public function promote_to_po_codearmy($user_id){
		$this->db->update('users',array('user_status'=>'enable','role'=>'po'),array('user_id'=>$user_id));
		$this->db->update('user_profiles',array('specialization'=>'product owner'),array('user_id'=>$user_id));
	}
	
	public function promote_to_po_old($user_id){
		$this->db->update('users',array('user_status'=>'enable'),array('user_id'=>$user_id));
		$this->db->update('user_profiles',array('specialization'=>'product owner'),array('user_id'=>$user_id));
	}
	
	public function is_po_v5($user_id){
		$res = $this->db->get_where('users', array('user_id'=>$user_id, 'user_status' => 'enable'));
		return $res->num_rows()>0;
		
	}
	
	public function can_claim($user_id){
		$sql = "SELECT * FROM users WHERE user_id = ? and claims>0";
		$res = $this->db->query($sql, array($user_id));
		return $res->num_rows()>0;
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
	public function create_new_profile($user_id, $dob=NULL) {
		//CodeArmy v1
		$info =unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
		$contact = array(
			"address" => $info['geoplugin_regionName'],
			"country" => $info['geoplugin_countryCode']
			);
		
		$contact = json_encode($contact);
		$doc = array(
			"user_id" => $user_id,
			//"birthdate" => $dob,
			"contact" => $contact,
			"lan_speak" => 'English',
			"lan_rw" => 'English',
			"gender" => 'male',
			"specialization" => 'unknown'
		);
		$this->assign_skill('communication', $user_id);
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
	
	function get_remember_me_token(){
		$id = md5(microtime());
		$query = $this->db->get_where('users', array('remember_me_token' => $id));
		while($query->num_rows() > 0){
			$id = md5(microtime().rand());
			$query = $this->db->get_where('users', array('remember_me_token' => $id));
		}
		return $id;
	}
	
	//validate login
	function validate() {
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('secret', md5($this->input->post('password')));
		$query = $this->db->get('users');
		if($query->num_rows == 1) {
			$user = $query->result_array();
			$this->update_user_geo($user[0]['user_id']);
			if($this->input->post('remember')=="remember"){
				$token = $this->get_remember_me_token();
				$this->db->update('users',array('remember_me_token'=>$token),array('user_id'=>$user[0]['user_id']));
				//create cookie
				$cookie = array(
					'name'   => 'remember_me_token',
					'value'  => $token,
					'expire' => '1209600',  // Two weeks
					'domain' => $_SERVER['HTTP_HOST'],
					'path'   => '/'
				);
				
				set_cookie($cookie);
			}
			return $query;
		}
		else {
			return false;
		}
	}
	
	function update_user_geo($user_id){
		$info = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
		$lat = $info['geoplugin_latitude'];
		$lng = $info['geoplugin_longitude'];
		$sql = "UPDATE user_profiles SET lat = ?, lng=? WHERE user_id=?";
		$this->db->query($sql,array($lat,$lng,$user_id));
	}
	
	//CodeArmy check authorisation function
	public function is_authorised($role = 'all'){
		$user_id = $this->session->userdata('user_id');
		$user_role = $this->session->userdata('role');
		if($user_id && (($role==$user_role)||($role=='all'))){
			return true;
		}else{
			//check remember me cookie
			$val = get_cookie('remember_me_token');
			if($val===0)$val='undefined';
			$sql = "SELECT * FROM (`users`) WHERE `remember_me_token` =  ?";
			$query = $this->db->query($sql, array($val));

			if($query->num_rows == 1) {
				//resume session
				$query_data = $query->result_array();
				$data = array(
					'username' => $this->input->post('username'),
					'user_id' => $query_data[0]['user_id'],
					'role' => $query_data[0]['role'],
					'level' => $this->gamemech->get_level($query_data[0]['exp']),
					'tutorial' => $query_data[0]['show_tutorial'],
					'is_logged_in' => true
				);
				$this->session->set_userdata($data);
				return true;
			}
			else {
				return false;
			}	
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
	
	function get_avatar($user_id){
		$profile = $this->get_profile($user_id);
		$user = $this->get_user($user_id);
		$user = $user->result_array();
		$user = $user[0];
		$profile = $profile->result_array();
		$profile = $profile[0];
		return ($profile['avatar'])? '/public/'.$profile['avatar'] : 'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $user['email'] ) ) );	
	}
	
	function getWorkTitle($user_id, $story_id){
		$res = $this->db->get_where('works', array('work_id' => $story_id));
		$res = $res->result_array();
		if(strcmp($res[0]['owner'], $user_id)==0) return 'Product owner';
		$user = $this->get_user($user_id);
		$user = $user->result_array();
		$user = $user[0];
		if($user['role']=='admin') return 'Admin';
		return 'lvl '.$this->gamemech->get_level($user['exp']);
	}
	
	//update profile
	//function update_profile($user_id,$avatar) {
	function update_profile($user_id) {
		//structure the profile data
		$contact = array(
			"phone" => $this->input->post('phone'),
			"address" => $this->input->post('address'),
			"country" => $this->input->post('country')
		);
		
		$urls = array(
			"skype" => $this->input->post('skype'),
			"facebook" => $this->input->post('facebook'),
			"twitter" => $this->input->post('twitter'),
			"linkedin" => $this->input->post('linkedin'),
			"github" => $this->input->post('github-address'),
			"portfolio" => $this->input->post('portfolio-address'),
			"blog" => $this->input->post('blog-address'),
			"extra1" => $this->input->post('extra1'),
			"extraaddress1" => $this->input->post('extraaddress1'),
			"extra2" => $this->input->post('extra2'),
			"extraaddress2" => $this->input->post('extraaddress2')
		);
		
		$contact = json_encode($contact);
		$urls = json_encode($urls);
		
		$doc = array(
			"status_msg" => $this->input->post('status-msg'),
			"full_name" => $this->input->post('fullname'),
			"bank_name" => $this->input->post('bank-name'),
			"bank_acc" => $this->input->post('bank-accountno'),
			"bank_country" => $this->input->post('bank-country'),
			"bank_swift" => $this->input->post('bank-swift'),
			"bank_firstname" => $this->input->post('bank-firstname'),
			"bank_lastname" => $this->input->post('bank-lastname'),
			"paypal_acc" => $this->input->post('paypal-email'),
			"contact" => $contact,
			"urls" => $urls,
			//"lan_speak" => $this->input->post('lan_speak'),
			//"lan_rw" => $this->input->post('lan_rw'),
			//"gender" => $this->input->post('gender'),
			"birthdate" => $this->input->post('birthday')
			//"specialization" => $this->input->post('specialization')
		);
		
		//if($avatar!=""){
			//assign the new avatar
	        //$relative_url = 'images/profile/'.$avatar;
    	    //$doc['avatar'] = $relative_url;
    	//}

		//update profile
		return $this->db->update('user_profiles', $doc, array('user_id' => $user_id));
	}
	
	function update_email($user_id){
		$email = array(
			"email" => $this->input->post('email')
		);
		
		return $this->db->update('users', $email, array('user_id' => $user_id));
	}
	
	function update_last_login($user_id){
		$doc2 = array(
			"last_login" => date('Y-m-d H:i:s'),
			"attempt" => 0
		);
		return $this->db->update('users', $doc2, array('user_id' => $user_id));	
	}
	
	function show_attempt_captcha($username){
		$sql = "SELECT * from users where username=? and attempt>3";
		$this->db->query($sql, array($username));
		if($query->num_rows == 1) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function attempt($username){
		$sql = "update users set attempt = attempt+1 where username = ?";
		$this->db->query($sql, array($username));
	}
	
	function reset_attempt($user_id){
		$doc2 = array(
			"attempt" => 0
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
			$query = "select users.user_id, users.email, users.username, avatar, count(*) as num from (select users.*, avatar from users left join user_profiles on users.user_id = user_profiles.user_id) as users, works where users.user_id = works.work_horse and lower(works.status) in ('verify', 'signoff') group by users.user_id, users.username, avatar order by num desc, users.exp desc limit 0,".$limit;	
		}else{
			$query = "select users.user_id, users.email, users.username, avatar, count(*) as num from (select users.*, avatar from users left join user_profiles on users.user_id = user_profiles.user_id) as users, works where users.user_id = works.work_horse and lower(works.status) in ('verify', 'signoff') group by users.user_id, users.username, avatar order by num desc, users.exp desc";
		}
		$result = $this->db->query($query,array());
		$data = $result->result_array();
		return $data;
	}
	
	function leaderboard_points($limit){
		if($limit>0){
			$query = "select * from (select users.user_id, username, email, avatar, exp, ranks.rank from users left join user_profiles on users.user_id = user_profiles.user_id inner join ranks on exp >= start_exp and exp <= end_exp) as t where exp>=0 order by exp DESC limit 0,".$limit;
		}else{
			$query = "select * from (select users.user_id, username, email, avatar, exp, ranks.rank from users left join user_profiles on users.user_id = user_profiles.user_id inner join ranks on exp >= start_exp and exp <= end_exp) as t where exp>=0 order by exp DESC";
		}
		$result = $this->db->query($query);
		if($result->num_rows>0){
			$data = $result->result_array();
			return $data;
		} else {
			return false;
		}
	}
	
	function leaderboard_centered($user_id){
		$limit = 2;
		$query = "select users.user_id, username, email, avatar, exp, ranks.rank from (select * from users where user_id = ?) as users left join user_profiles on users.user_id = user_profiles.user_id inner join ranks on exp >= start_exp and exp <= end_exp";
		
		$result = $this->db->query($query,$user_id);
		$data = $result->result_array();
		
		$query = "select * from (select users.user_id, username, email, avatar, exp, ranks.rank from (select * from users where exp>(select exp from users where user_id=?)) as users left join user_profiles on users.user_id = user_profiles.user_id inner join ranks on exp >= start_exp and exp <= end_exp) as t where exp>=0 order by exp DESC limit 0,".$limit;
		$result1 = $this->db->query($query,$user_id);
		$data1 = $result1->result_array();
		$limit = 2+2-$result1->num_rows;
		$query = "select * from (select users.user_id, username, email, avatar, exp, ranks.rank from (select * from users where exp<(select exp from users where user_id=?)) as users left join user_profiles on users.user_id = user_profiles.user_id inner join ranks on exp >= start_exp and exp <= end_exp) as t where exp>=0 order by exp DESC limit 0,".$limit;
		$result2 = $this->db->query($query,$user_id);
		$data2 = $result2->result_array();
		$data = array_merge($data1,$data,$data2);
		return $data;
	}
	
	function leaderboard_centered_details($user_id){
		$myPos = $this->leader_board_my_pos($user_id);
		$limit = 4;
		$query = "select users.user_id, username, email, avatar, exp, ranks.rank from (select * from users where user_id = ?) as users left join user_profiles on users.user_id = user_profiles.user_id inner join ranks on exp >= start_exp and exp <= end_exp";
		
		$result = $this->db->query($query,$user_id);
		$data = $result->result_array();
		$data[0]['position'] = $myPos;
		
		$query = "select * from (select users.user_id, username, email, avatar, exp, ranks.rank from (select * from users where exp>(select exp from users where user_id=?)) as users left join user_profiles on users.user_id = user_profiles.user_id inner join ranks on exp >= start_exp and exp <= end_exp) as t where exp>=0 order by exp DESC limit 0,".$limit;
		$result1 = $this->db->query($query,$user_id);
		$data1 = $result1->result_array();
		for($i=0; $i<count($data1);$i++){$data1[$i]['position'] = $myPos - $result1->num_rows + $i;}
		
		$limit = 5+5-$result1->num_rows;
		$query = "select * from (select users.user_id, username, email, avatar, exp, ranks.rank from (select * from users where exp<(select exp from users where user_id=?)) as users left join user_profiles on users.user_id = user_profiles.user_id inner join ranks on exp >= start_exp and exp <= end_exp) as t where exp>=0 order by exp DESC limit 0,".$limit;
		$result2 = $this->db->query($query,$user_id);
		$data2 = $result2->result_array();
		for($i=0; $i<count($data2);$i++){$data2[$i]['position'] = $myPos + $i +1;}
		
		$data = array_merge($data1,$data,$data2);
		return $data;
	}
	
	function leaderboard_time($limit=0){
		if($limit>0){
			$query = "select user_id, username,email, avatar, user.exp as xp, sum(hour(timediff(deadline, done_at))) as exp from (select users.*, avatar from users left join user_profiles on users.user_id = user_profiles.user_id) as user,works where works.work_horse = user.user_id and lower(works.status) in ('verify','signoff') group by user_id, username, avatar, user.exp having exp>0 order by exp desc, xp desc limit 0,".$limit;
		}else{
			$query = "select user_id, username, email, avatar, users.exp as xp, sum(hour(timediff(deadline, done_at))) as exp from (select users.*, avatar from users left join user_profiles on users.user_id = user_profiles.user_id) as users,works where works.work_horse = users.user_id and lower(works.status) in ('verify','signoff') group by user_id, username, avatar, users.exp having exp>0 order by exp desc, xp desc";
		}
		$result = $this->db->query($query);
		$data = $result->result_array();
		return $data;
	}
	
	function leader_board_my_pos($user_id){
		$sql = "SELECT (SELECT COUNT(*) FROM users as x WHERE x.exp <= t.exp and x.exp>=0) AS position, t.username FROM users AS t WHERE t.user_id = ?";
		$res = $this->db->query($sql, array($user_id));
		if($res->num_rows>0){
			$data = $res->result_array();
			return $data[0]['position'];
		}else{return 0;}
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
	
	function works_bid($user_id){
		$sql = "SELECT count(*) as num FROM bids WHERE user_id = ? AND bid_status = 'Bid'";
		$res = $this->db->query($sql, array($user_id));
		$data = $res->result_array();
		return $data[0]['num'];
	}
	
	function get_history_log($user_id, $limit){
		$user = $this->get_user($user_id)->result_array();
		$username = ucfirst($user[0]['username']);
		$sql = "SELECT * from history, works where user_id = ? and history.work_id = works.work_id order by history.created_at DESC limit 0,".$limit;
		$res = $this->db->query($sql, $user_id);
		$data = $res->result_array();
		$res = array();
		foreach($data as $event):
			switch ($event['event']):
				case 'bid':$res[]=$username.' applied for job <a href="#">'.$event['title'].'</a>';break;
				case 'win':$res[]=$username.' is assigned to job <a href="#">'.$event['title'].'</a>';break;
				case 'done':$res[]=$username.' submited job <a href="#">'.$event['title'].'</a>';break;
				case 'redo':$res[]=$username.' is asked to revise job <a href="#">'.$event['title'].'</a>';break;
				case 'verify':$res[]=$username.' completed job <a href="#">'.$event['title'].'</a>';break;
				case 'reject':$res[]=$username.' failed to deliver job <a href="#">'.$event['title'].'</a>';break;
			endswitch;
		endforeach;
		return $res;
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
		$sql = "select avatar, users.user_id, users.email from user_profiles, users where users.user_id=user_profiles.user_id and users.user_id != ? and users.user_id in (select distinct work_horse from works where project_id in (SELECT DISTINCT project_id from works where works.work_horse = ?))";
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
		if($user && $user->num_rows()>0){
			$user = $user->result_array();
			$user = $user[0];
			$doc = array(
				'code' => md5(date('Y-m-d H:i:s').$user['user_id'].'pass'),
				'action' => 'pass',
				'user_id' => $user['user_id'],
				'created_at' => date('Y-m-d H:i:s'),
				'validity' => date('Y-m-d H:i:s', time()+60*60),
			);
			$this->notify($user['user_id'],'Password Reset',"We received a request for resetting your password. If you are the one initiating the request and wish to continue, please click here: <a href='".base_url()."login/recovery/".$doc['code']."'>reset password</a>");
			
			$this->db->insert('actions', $doc);
			return "An email is sent to you containing further instuctions...";
		}else return "Uername doesn't exist!";
	}
	
	function reset_pass_notify_codearmy($email){
		$user = $this->get_user($email,'email');
		if($user && $user->num_rows()>0){
			$user = $user->result_array();
			$user = $user[0];
			$doc = array(
				'code' => md5(date('Y-m-d H:i:s').$user['user_id'].'pass'),
				'action' => 'pass',
				'user_id' => $user['user_id'],
				'created_at' => date('Y-m-d H:i:s'),
				'validity' => date('Y-m-d H:i:s', time()+60*60),
			);
			$this->notify($user['user_id'],'Password Reset',"We received a request for resetting your password. If you are the one initiating the request and wish to continue, please click here: <a href='".base_url()."login/recovery/".$doc['code']."'>reset password</a>");
			$this->db->insert('actions', $doc);
			return "Alright sir! i've sent you an email containing a confidential link to reset your password. Please check your email ASAP.";
		}else return "Sorry sir! but your email is not registered in our system.";
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
				$this->notify($user['user_id'], 'Your Password is Reset',"<p>Hello!</p><p>Your password on <a href='http://codearmy.com'>CodeArmy</a> has been reseted to: ".$newPass."</p><p>Soldier on!</p>");
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
	
	function subscribe($email, $type, $ip, $agent){
		$data = array(
			'email' => $email,
			'type' => $type,
			'ip' => $ip,
			'agent' => $agent
		);
		
		$this->db->insert('subscription', $data);
	}
	
	function notify($user_id, $subject, $message, $category = NULL, $shor_message="", $target_id = NULL){
			ini_set('display_error',1);
			error_reporting('E_ALL');
			$q = $user_id;
			
			$query = $this->db->get_where('users', array('user_id' => $q));
			if($query->num_rows>0){
				$query = $query->result_array();
				$to = $query[0]['email'];
			}
			
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
			
			$mail->SetFrom('noreply@codearmy.com', 'CodeArmy');
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
				"target_id" => $target_id,
				"title" => $subject,
				"message" => ($shor_message=="")?$message:$shor_message,
				"status" => 'unread',
				"created_at" => date('Y-m-d'),
				"category" => $category
			);
			$this->db->insert('inbox',$data);
			
			if(!$mail->Send())
			{
			   echo "Message could not be sent. <p>";
			   echo "Mailer Error: " . $mail->ErrorInfo;
			   exit; die();
			}
			
	}
	
	function send_invites($user_id){
		$strEmail = strtolower($this->input->post('email'));
		$strMessage = $this->input->post('message');
		$subject = "Invite you to be a part of CodeAr.my";
		
		$strFormatEmailList = str_replace(";", ",", $strEmail); // replace ; with , if any
		$strFormatEmailList = str_replace(" ", "", $strFormatEmailList); // remove space
		$strMessage = str_replace("\r", "<br>", $strMessage);
		$strAddMessage = "<br>Visit <a href=\"http://www.codearmy.com\" target=\"_blank\">http://www.codearmy.com</a>";
		$strMessage = $strMessage."".$strAddMessage;
		
		$strSplit = explode(",", $strFormatEmailList);
		
		require_once(getcwd()."/application/helpers/phpmailer/class.phpmailer.php");
		
		foreach($strSplit as $mailtosend):
			$mail = new PHPMailer();
			
			$mail->IsSMTP();                                      // set mailer to use SMTP
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			//$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
			$mail->Host       = "mail.vakilian.net";      // sets GMAIL as the SMTP server
			//$mail->Port       = 110;                   // set the SMTP port for the GMAIL server
			$mail->Username = "noreply@vakilian.net";  // SMTP username
			$mail->Password = "work123"; // SMTP password
			//$mail->SMTPDebug  = 1;
			
			$mail->SetFrom('noreply@codearmy.com', 'CodeArmy');
			$mail->AddAddress($mailtosend);
			//$mail->AddAddress("ellen@example.com");                  // name is optional
			//$mail->AddReplyTo("info@example.com", "Information");
			
			$mail->WordWrap = 50;                                 // set word wrap to 50 characters
			//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
			//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
			$mail->IsHTML(true);                                  // set email format to HTML
			
			$mail->Subject = $subject;
			$mail->Body    = $strMessage;
			$mail->AltBody = $strMessage;
			if(!$mail->Send())
			{
			   echo "Message could not be sent. <p>";
			   echo "Mailer Error: " . $mail->ErrorInfo;
			   exit; die();
			}
		endforeach;
	}
	
	public function send_mail($from, $to, $subject, $message){
		require_once(getcwd()."/application/helpers/phpmailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth   = true;
		$mail->Host       = "mail.vakilian.net";
		$mail->Username = "noreply@vakilian.net";
		$mail->Password = "work123";
		$mail->SetFrom($from);
		$mail->AddAddress($to);
		$mail->WordWrap = 50;
		$mail->IsHTML(true);
		$mail->Subject = $subject;
		$mail->Body    = $message;
		$mail->AltBody = $message;
		$mail->Send();
	}
	
	
	function tallents_map($percision){
		$sql = "SELECT round(lat,2) AS lat, round(lng,2) AS lng, count(*) AS num FROM users,user_profiles WHERE users.user_id=user_profiles.user_id AND users.role='user' GROUP BY round(lat,?), round(lng,?)";
		$res = $this->db->query($sql,array($percision,$percision));
		$res = $res->result_array();
		return $res;
	}
}