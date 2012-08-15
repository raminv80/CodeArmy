<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Work_model extends CI_Model { 
	
	function __construct() {
		parent::__construct();
	}
	
	function create_mission($exp){
		
	}
	
	function upload_mission_file(){
		$file_id = $this->_gen_id();
		$check_file_id = $this->get_file($file_id);
		while($check_file_id->num_rows() > 1) {
			$file_id = $this->_gen_id();
			$check_file_id = $this->get_file($file_id);			
		}
		
		// file storing
		
		// end of file storing
		
		$res = array(
			"file_id" => $file_id,
			"file_type" => $file_type,
			"file_name" => $file_name,
			"file_title" => $file_title,
			"file_description" => $file_description,
			"created_at" => date('Y-m-d H:i:s')
		);
		if($this->db->insert('work_files', $res)) {
			return $file_id;
		} else {
			return false;
		}
	}
	
	function _gen_id() {
		$work_id = '';
		list($usec, $sec) = explode(' ', microtime());
		$rand_seed = (float)$sec + ((float)$usec * 100000);
		mt_srand($rand_seed);
		for ($r = 0; $r<13; $r++) { $work_id .= mt_rand(0,9); }
		return $work_id;
	}

	function get_work($work_id) {
		return $this->db->get_where('works', array('work_id' => $work_id));
	}
	
	function get_detail_work($work_id) {
		$sql = "SELECT *, arrangement_type.type as arrangement_type FROM works, mission_category, class, subclass, arrangement_type,bids WHERE arrangement_type.id=works.est_arrangement AND works.category=mission_category.category_id AND class.class_id=works.class AND subclass.subclass_id=works.subclass AND bids.work_id=works.work_id AND bids.bid_status='Accepted' AND bids.user_id=works.work_horse AND works.work_id=?";
		return $this->db->query($sql,$work_id);
	}
	
	function get_work_skills($work_id){
		$sql = "SELECT * from work_skill, skill where work_skill.work_id = ? AND work_skill.skill_id = skill.id";
		$res = $this->db->query($sql, $work_id);
		return $res->result_array();
	}
	
	function get_file($file_id) {
		return $this->db->get_where('work_files', array('file_id' => $file_id));
	}
	
	function get_main_category(){
		$sql = "SELECT * FROM mission_category ORDER BY category_id";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	
	function get_main_class($cat=''){
		if($cat==''){
			$sql = "SELECT class.* FROM class ORDER BY class_id";
			$res = $this->db->query($sql);
		}else{
			$sql = "SELECT class.* FROM class  WHERE class.category_id=? ORDER BY class_id";
			$res = $this->db->query($sql,$cat);
		}
		return $res->result_array();
	}

	function get_sub_class($cat='',$class_id=''){
		if($cat=='' && $class_id==''){
			$sql = "SELECT * FROM subclass ORDER BY class_id";
			$res = $this->db->query($sql);
		}else{
			if($cat==''){
				$sql = "SELECT * FROM subclass WHERE class_id=? ORDER BY class_id";
				$res = $this->db->query($sql,$class_id);
			}else{
				$sql = "SELECT subclass.* FROM subclass,class WHERE class.class_id=subclass.class_id AND class.category_id=? ORDER BY class_id";
				$res = $this->db->query($sql,$cat);
			}
		}
		return $res->result_array();
	}
	
	function previewMission($work_id, $user_id){
		//$sql = "SELECT works.*, mission_category.category as catname, class.class_name as classname, subclass.subclass_name as subclassname FROM works, mission_category, class, subclass WHERE works.work_id = ? AND works.creator = ? AND works.subclass = subclass.subclass_id AND subclass.class_id = class.class_id AND class.category_id = mission_category.category_id";
		$sql = "SELECT works.*, mission_category.category as catname, class.class_name as classname, subclass.subclass_name as subclassname FROM works, mission_category, class, subclass WHERE works.work_id = ? AND works.creator = ? AND class.category_id = mission_category.category_id";
		$res = $this->db->query($sql, array($work_id, $user_id));
		return $res->result_array();
	}
	
	function store_skill_model($key){
		$sql = "SELECT * FROM skill WHERE ? LIKE concat('%', name, '%') ORDER BY name DESC";
		$res = $this->db->query($sql, $key);
		return $res->result_array();
	}
	
	function store_level_model($key){
		$sql = "SELECT * FROM skill_level WHERE ? LIKE concat('%', skill_level, '%')";
		$res = $this->db->query($sql, $key);
		return $res->result_array();
	}
	
	function previewSkills($work_id){
		$sql = "SELECT * FROM work_skill, skill, skill_level WHERE work_skill.work_id = ? AND work_skill.skill_id = skill.id AND work_skill.skill_level = skill_level.id";
		$res = $this->db->query($sql, $work_id);
		return $res->result_array();
	}
	
	function previewFiles($work_id){
		$sql = "SELECT * FROM work_files WHERE work_id = ?";
		$res = $this->db->query($sql, $work_id);
		return $res->result_array();
	}
	
	function setBid($work_id,$user_id,$budget,$time,$desc){
		$sql = "DELETE FROM bids WHERE work_id=? AND user_id=?";
		$this->db->query($sql, array($work_id,$user_id));
		$data=array(
			'work_id' => $work_id,
			'user_id' => $user_id,
			'bid_cost' => $budget,
			'bid_time' => $time,
			'bid_desc' => $desc,
			'bid_status' => 'Bid',
			'created_at' => date('Y-m-d H:i:s')
		);
		$this->db->insert('bids',$data);
	}
	
	function get_work_bids($work_id){
		$sql = "select * from bids where work_id=? order by bid_id DESC";
		$res = $this->db->query($sql, $work_id);
		$res = $res->result_array();
		return $res;
	}
	
	function get_bidders($work_id){
		$sql = "SELECT DISTINCT users.* from bids, users where bids.work_id=? and users.user_id=bids.user_id";
		$res = $this->db->query($sql, $work_id);
		$res = $res->result_array();
		return $res;
	}
	
	function get_bid_avg($work_id){
		$sql = "select AVG(bid_cost) AS avg_cost, AVG(bid_time) AS avg_time  from bids where work_id=?";
		$res = $this->db->query($sql, $work_id);
		$res = $res->result_array();
		return $res[0];
	}
	
	function check_file($file_id, $work_id, $session_id){
		if(!$work_id){
			$sql = "SELECT * FROM work_files WHERE file_id = ? AND session_id = ?";
			$res = $this->db->query($sql, array($file_id, $session_id));
		}else{
			$sql = "SELECT * FROM work_files WHERE file_id = ? AND work_id = ?";
			$res = $this->db->query($sql, array($file_id, $work_id));
		}
		return $res->result_array();
	}
	
	function get_arrangement_type(){
		$sql = "SELECT * FROM arrangement_type ORDER BY ID";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	
	function get_duration($type=''){
		$sql = "SELECT * FROM arrangement_time WHERE type_id = ?";
		$res = $this->db->query($sql, $type);
		return $res->result_array();
	}
	
	function get_budget($type=''){
		$sql = "SELECT * FROM arrangement_budget WHERE type_id = ?";
		$res = $this->db->query($sql, $type);
		return $res->result_array();
	}
	
	function get_selected_arrangement_type($type){
		$sql = "SELECT * FROM arrangement_type WHERE id = ?";
		$res = $this->db->query($sql, $type);
		return $res->result_array();
	}
	
	function get_selected_arrangement_time($time){
		$sql = "SELECT * FROM arrangement_time WHERE time_id = ?";
		$res = $this->db->query($sql, $time);
		return $res->result_array();
	}
	
	function get_selected_arrangement_budget($budget){
		$sql = "SELECT * FROM arrangement_budget WHERE budget_id = ?";
		$res = $this->db->query($sql, $budget);
		return $res->result_array();
	}
	
	function get_owner_works($user_id){
		$sql = "SELECT *, (select count(1) from bids where bids.work_id=works.work_id) as bids from works WHERE owner=? OR creator=? and status!='Signoff'";
		$res = $this->db->query($sql, array($user_id,$user_id));
		return $res->result_array();
	}
	
	function get_my_bids($user_id){
		$sql = "SELECT avg(bids.bid_cost) as avg_cost, avg(bids.bid_time) as avg_time, bids.*, works.*, arrangement_type.type as arrangement FROM bids,works,arrangement_type WHERE arrangement_type.id = works.est_arrangement AND works.work_id=bids.work_id AND user_id=? group by bids.bid_id ORDER BY bid_id DESC ";
		$res = $this->db->query($sql, $user_id);
		return $res->result_array();
	}
	
	function cancel_my_bid($bid_id,$user_id){
		$sql = "SELECT * from bids where bid_id = ?";
		$res = $this->db->query($sql, $bid_id)->result_array();
		if(count($res)!=1)return false;
		$bid = $res[0];
		$res = $this->get_work($bid['work_id'])->result_array();
		if(count($res)!=1)return false;
		$work = $res[0];
		if(($bid['bid_status']=='Bid'||($bid['bid_status']=='Accepted' && in_array(strtolower($work['status']),array('open','reject')))) && $bid['user_id']==$user_id){
			$sql = "Delete from bids where bid_id=? AND user_id=?";
			$this->db->query($sql, array($bid_id,$user_id));
			return true;
		}
		return false;
	}
	
	function get_work_arrangement($work_id){
		$sql = "SELECT arrangement_type.type as type from arrangement_type,works where work_id=? and est_arrangement=arrangement_type.id";
		$res = $this->db->query($sql,$work_id)->result_array();
		return $res[0]['type'];
	}
	
	function create_comment($work_id, $user_name, $message, $attach){
		$data = array(
			'story_id' => $work_id,
			'username' => $user_name,
			'comment_body' => $message,
			'comment_file' => $attach
		);
		$this->db->insert('comments',$data);
		return $this->db->insert_id();
	}
	
	function get_comments($work_id){
		$sql = "SELECT * FROM comments, users WHERE story_id = ? and users.username=comments.username ORDER BY comment_id DESC";
		return $this->db->query($sql, $work_id)->result_array();
	}
	
	function get_work_history($work_id,$limit=0){
		$sql = "SELECT * FROM history WHERE work_id=? ORDER BY id DESC";
		if($limit>0)$sql.=" limit 0,?";
		return $this->db->query($sql, array($work_id,$limit))->result_array();
	}
	
	function get_user_history($user_id,$limit){
		$sql = "SELECT * FROM history WHERE user_id=? ORDER BY id DESC";
		if($limit>0)$sql.=" limit 0,?";
		return $this->db->query($sql, array($user_id,$limit))->result_array();
	}
	
	function log_history($user_id,$work_id,$event,$status,$desc){
		$user = $this->db->get_where('users',array('user_id'=>$user_id))->result_array();
		$user = $user[0];
		$work = $this->db->get_where('works',array('work_id'=>$work_id))->result_array();
		$work = $work[0];
		$data = array(
			'user_id' => $user_id,
			'work_id' => $work_id,
			'Desc' => $desc,
			'event' => $event,
			'status' => $status
		);
		$this->db->insert('history',$data);
		
		require_once(getcwd()."/application/helpers/pusher/Pusher.php");
		$pusher = new Pusher('deb0d323940b00c093ee', '9ab20336af22c4e7fa77', '25755');
		$data = array(
			'user_id' => $user_id,
			'username' => $user['username'],
			'work_id' => $work_id,
			'work_title'=>$work['title'],
			'Desc' => $desc,
			'event' => $event,
			'status' => $status,
			'event_id'=> $this->db->insert_id()
		);
		$pusher->trigger('CA_activities', 'new-activity-'.$work_id, $data );
	}
	
	function get_recent_activities($work_id,$limit=-1){
		$sql = "SELECT history.*, works.title, users.username, users.exp FROM history, works, users WHERE works.work_id=? AND history.user_id=users.user_id AND works.work_id=history.work_id ORDER BY history.id DESC";
		if($limit>0)$sql.=" limit 0,?";
		$res = $this->db->query($sql, array($work_id,$limit))->result_array();
		return $res;
	}
	
	function get_mission_task($work_id){
		$sql = "SELECT * FROM mission_task WHERE mission_task.work_id = ?";
		$res = $this->db->query($sql,$work_id);
		return $res;
	}
	
	function get_bids($work_id){
		$sql = "SELECT bids.*, username, exp FROM bids,users WHERE users.user_id=bids.user_id AND bids.work_id=? ORDER BY bid_status ASC, bid_id DESC";
		return $this->db->query($sql, array($work_id))->result_array();
	}
	
	function accept_bid($bid_id){
		$res = $this->db->get_where('bids',array('bid_id'=>$bid_id))->result_array();
		$work = $this->get_work($res[0]['work_id'])->result_array();
		$bid = $res[0];
		$work = $work[0];
		$po = $this->session->userdata('user_id');
		if($po==$work['owner']){
			//update works
			$sql = "UPDATE works SET status='assigned', work_horse=?, assigned_at=?, cost=? WHERE work_id=?";
			$this->db->query($sql,array($bid['user_id'],time(),$bid['bid_cost'],$bid['work_id']));
			//update bid
			$sql = "UPDATE bids SET bid_status='Accepted' WHERE bid_id=?";
			$this->db->query($sql,array($bid_id));
			return true;
		}else return false;
	}
	
	function remove_bid($bid_id, $user_id){
		$res = $this->db->get_where('bids',array('bid_id'=>$bid_id))->result_array();
		$work = $this->get_work($res[0]['work_id'])->result_array();
		$bid = $res[0];
		$work = $work[0];
		$po = $this->session->userdata('user_id');
		if($po==$work['owner']){
			$sql = "DELETE FROM bids WHERE bid_id=?";
			$this->db->query($sql,$bid_id);
			return true;
		}else return false;
	}
}