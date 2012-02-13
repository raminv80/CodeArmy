<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inbox_model extends CI_Model { 

	var $data = '';
	
	function __construct() {
		parent::__construct();
	}
	
	function get_overwiew($user_id){
		$result = array();
		$sql = "SELECT count(*) as num from works where lower(status) in ('verify','signoff') and work_horse = ?";
		$data1 = $this->db->query($sql, array($user_id));
		$data1 = $data1->result_array();
		$sql = "SELECT count(*) as num from works where lower(status) = 'done' and work_horse = ?";
		$data2 = $this->db->query($sql, array($user_id));
		$data2 = $data2->result_array();
		$sql = "SELECT count(*) as num from bids where user_id = ?";
		$data3 = $this->db->query($sql, array($user_id));
		$data3 = $data3->result_array();
		$sql = "SELECT count(*) as num from works where work_horse = ?";
		$data4 = $this->db->query($sql, array($user_id));
		$data4 = $data4->result_array();
		$sql = "SELECT count(*) as num from works where lower(status) ='signoff' and work_horse = ?";
		$data5 = $this->db->query($sql, array($user_id));
		$data5 = $data5->result_array();
		$result['completed'] = $data1[0]['num'];
		$result['done'] = $data2[0]['num'];
		$result['bids'] = $data3[0]['num'];
		$result['assigned'] = $data4[0]['num'];
		$result['paid'] = $data5[0]['num'];
		return $result;
	}
	
	function list_messages($user_id){
		$sql = "SELECT * FROM inbox WHERE user_id = ? order by id desc";
		$result = $this->db->query($sql, array($user_id));
		if($result->num_rows()>0){
			$data = $result->result_array();
			return $data;
		}else return false;
	}
	
	function get_history($user_id){
		$sql = "SELECT * FROM history, project, works WHERE user_id = ? and project.project_id = history.project_id and works.work_id = history.work_id";
		$result = $this->db->query($sql, array($user_id));
		if($result->num_rows()>0){
			return $result->result_array();
		}else return false;
	}
	
	function read($id, $user_id){
		$message_id = explode('_',$id);
		$message_id = $message_id[1];
		$sql = "update inbox set status = 'read' where id=? and user_id=? and status='unread'";
		$this->db->query($sql, array($message_id, $user_id));
		return $id;
	}
	
	function get_bids($user_id){
		$sql = "select inbox.*, avatar, md5(lower(trim(email))) as email_hash from (select users.email, inbox.id, inbox.target_id, inbox.user_id, title, message, inbox.created_at, status from inbox, users where users.user_id=inbox.target_id and inbox.user_id = ? and category = 'bid' and status = ?) as inbox left join user_profiles on inbox.target_id = user_profiles.user_id order by inbox.id desc";
		$result = $this->db->query($sql, array($user_id,'unread'));
		$unread = $result->num_rows();
		$result1 = array();
		if($unread<7){
			$diff = 7 - $unread;
			$sql.=' limit 0,?';
			$result1 = $this->db->query($sql, array($user_id,'read',$diff));
			$result1 = $result1->result_array();
		}
		$res = array();
		$res[0] = $unread;
		$res[1] = array_merge($result->result_array(), $result1);
		return $res;
	}
	
	function get_messages($user_id){
		$sql = "select inbox.*, avatar, md5(lower(trim(email))) as email_hash from (select users.email as email, inbox.id, inbox.target_id, inbox.user_id, title, message, inbox.created_at, status from inbox, users where users.user_id = inbox.target_id and inbox.user_id = ? and category = 'message' and status = ?) as inbox left join user_profiles on inbox.target_id = user_profiles.user_id order by inbox.id desc";
		$result = $this->db->query($sql, array($user_id,'unread'));
		$unread = $result->num_rows();
		$result1 = array();
		if($unread<7){
			$diff = 7 - $unread;
			$sql.=' limit 0,?';
			$result1 = $this->db->query($sql, array($user_id,'read',$diff));
			$result1 = $result1->result_array();
		}
		$res = array();
		$res[0] = $unread;
		$res[1] = array_merge($result->result_array(), $result1);
		return $res;
	}
	
	function get_jobs($user_id){
		$sql = "select inbox.*, avatar, md5(lower(trim(email))) as email_hash from (select users.email as email, inbox.id, inbox.target_id, inbox.user_id, title, message, inbox.created_at, status from inbox, users where users.user_id = inbox.target_id and inbox.user_id = ? and category = 'job' and status = ?) as inbox left join user_profiles on inbox.target_id = user_profiles.user_id order by inbox.id desc";
		$result = $this->db->query($sql, array($user_id,'unread'));
		$unread = $result->num_rows();
		$result1 = array();
		if($unread<7){
			$diff = 7 - $unread;
			$sql.=' limit 0,?';
			$result1 = $this->db->query($sql, array($user_id,'read',$diff));
			$result1 = $result1->result_array();
		}
		$res = array();
		$res[0] = $unread;
		$res[1] = array_merge($result->result_array(), $result1);
		return $res;
	}
}