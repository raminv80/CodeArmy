<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message_model extends CI_Model { 
	
	function __construct() {
		parent::__construct();
	}
	
	function get_message($message_id, $user_id){
		$sql = "SELECT messages.*, users.username, user_profiles.avatar, users.email from messages, users, user_profiles where (message_id = ? or parent_id=?) and (`to` = ? or `from` = ?) and users.user_id = messages.from and users.user_id = user_profiles.user_id ORDER BY message_id DESC";
		$input = array($message_id, $message_id, $user_id, $user_id);
		$res = $this->db->query($sql, $input);
		if($res->num_rows<1)die('Error! message not found.');
		return $res->result_array();
	}
	
	function get_messages($user_id, $cat, $offset=-1, $limit=-1){
		switch($cat){
			case 'sent': $sql = "SELECT messages.*,f.username as from_username, t.username as to_username, user_profiles.avatar, t.email FROM messages, users as f, users as t, user_profiles WHERE f.user_id=messages.from and t.user_id=messages.to and messages.from = ? and user_profiles.user_id=f.user_id ORDER BY messages.message_id DESC";
						 if($offset>-1 && $limit>-1) $sql.=" limit ?,?";
						 $data = $this->db->query($sql, array($user_id, $offset, $limit));
			break;
			case 'inbox': $sql = "SELECT messages.*, f.username as from_username, t.username as to_username, user_profiles.avatar, t.email FROM messages, users as f, users as t, user_profiles WHERE f.user_id=messages.from and t.user_id=messages.to and messages.category IN ('inbox','important') AND messages.to = ? and user_profiles.user_id=f.user_id ORDER BY messages.message_id DESC";
						  if($offset>-1 && $limit>-1) $sql.=" limit ?,?";
						  $data = $this->db->query($sql, array($user_id, $offset, $limit));
			break;
			case 'all': $sql = "SELECT messages.*, f.username as from_username, t.username as to_username, user_profiles.avatar, t.email FROM messages, users as f, users as t, user_profiles WHERE f.user_id=messages.from and t.user_id=messages.to AND messages.to = ? and user_profiles.user_id=f.user_id AND messages.category NOT IN ('trash') ORDER BY messages.message_id DESC";
						  if($offset>-1 && $limit>-1) $sql.=" limit ?,?";
						  $data = $this->db->query($sql, array($user_id, $offset, $limit));
			break;
			default: $sql = "SELECT messages.*, f.username as from_username, t.username as to_username, user_profiles.avatar, t.email FROM messages, users as f, users as t, user_profiles WHERE f.user_id=messages.from and t.user_id=messages.to and category = ? AND messages.to = ? and user_profiles.user_id=f.user_id ORDER BY messages.message_id DESC";
					if($offset>-1 && $limit>-1) $sql.=" limit ?,?"; 
					$data = $this->db->query($sql, array($cat, $user_id, $offset, $limit));
		}
		$res = $data->result_array();
		return $res;
	}
	
	function search_messages($search, $user_id, $offset=-1, $limit=-1){
		if(strlen(trim($search)) < 3){
			return $this->get_messages($user_id, 'all', $offset,$limit); 
		}else{
			$search = '%'.$search.'%';
			$sql = "SELECT messages.*, f.username as from_username, t.username as to_username, user_profiles.avatar, t.email FROM messages, users as f, users as t, user_profiles WHERE messages.content LIKE ? AND f.user_id = messages.from AND t.user_id = messages.to AND messages.to = ? AND user_profiles.user_id = f.user_id AND messages.category NOT IN ('trash')";
			if($offset>-1 && $limit>-1) $sql.= " LIMIT ?,?";
			$data = $this->db->query($sql, array($search, $user_id, $offset, $limit));
			$res = $data->result_array();
			return $res;
		}
	}
	
	function send_message($user_id,$to,$subject,$msg,$parent_id=NULL){
		if($parent_id==0)$parent_id=NULL;
		$doc = array(
			"from" => $user_id,
			"to" => $to,
			"title" => htmlentities($subject),
			"content" => $msg,
			"parent_id" => $parent_id,
		);
		$res = $this->db->insert('messages', $doc);
		//push new message
		require_once(getcwd()."/application/helpers/pusher/Pusher.php");
		$pusher = new Pusher('deb0d323940b00c093ee', '9ab20336af22c4e7fa77', '25755');
		$data = array(
			'from' => $user_id,
			'to' => $to,
			'message_id'=> $this->db->insert_id()
		);
		$pusher->trigger('message-'.$to, 'new-message', $data );
		return $res;
	}
		
	function get_total_messages($user_id, $cat){
		switch($cat){
			case 'sent': $sql = "SELECT count(1) as num FROM messages WHERE messages.from = ?";
				$data = $this->db->query($sql, array($user_id));
			break;
			case 'inbox': $sql = "SELECT count(1) as num FROM messages WHERE messages.to = ? and messages.category IN ('inbox', 'important')";
				$data = $this->db->query($sql, array($user_id));
			break;
			case 'search':
				$search = '%'.$this->input->post('msg-search').'%';
				$sql = "SELECT count(1) as num FROM messages WHERE messages.to = ? AND messages.content LIKE ? AND messages.category IN ('inbox', 'important')";
				$data = $this->db->query($sql, array($user_id, $search));
			break;
			default: $sql = "SELECT count(1) as num FROM messages WHERE messages.to = ? and category = ?";
				$data = $this->db->query($sql, array($user_id, $cat));
		}
		$res = $data->result_array();
		return $res[0]['num'];
	}
	
	function make_important($list,$user_id){
		$res=array();
		$sql = "update messages set category='important' where message_id=? and messages.to=?";
		foreach($list as $l):
			if($this->db->query($sql, array($l,$user_id)))$res[]=$l;
		endforeach;
		return $res;
	}
	
	function make_unimportant($list,$user_id){
		$res=array();
		$sql = "update messages set category='inbox' where message_id=? and messages.to=?";
		foreach($list as $l):
			if($this->db->query($sql, array($l,$user_id)))$res[]=$l;
		endforeach;
		return $res;
	}
	
	function make_read($list,$user_id){
		$res=array();
		$sql = "update messages set status='read' where message_id=? and messages.to=?";
		foreach($list as $l):
			if($this->db->query($sql, array($l,$user_id)))$res[]=$l;
		endforeach;
		return $res;
	}
	
	function make_unread($list,$user_id){
		$res=array();
		$sql = "update messages set status='unread' where message_id=? and messages.to=?";
		foreach($list as $l):
			if($this->db->query($sql, array($l,$user_id)))$res[]=$l;
		endforeach;
		return $res;
	}
	
	function to_trash($list,$user_id){
		$res=array();
		$sql = "update messages set category='trash', status='read' where message_id=? and messages.to=?";
		foreach($list as $l):
			if($this->db->query($sql, array($l,$user_id)))$res[]=$l;
		endforeach;
		return $res;
	}
	
	function delete($list,$user_id){
		$res=array();
		$sql = "update messages set category='deleted' where message_id=? and messages.to=?";
		foreach($list as $l):
			if($this->db->query($sql, array($l,$user_id)))$res[]=$l;
		endforeach;
		return $res;
	}
	
	function recover($list,$user_id){
		$res=array();
		$sql = "update messages set category='inbox' where message_id=? and messages.to=?";
		foreach($list as $l):
			if($this->db->query($sql, array($l,$user_id)))$res[]=$l;
		endforeach;
		return $res;
	}
	
	function num_unread($user_id){
		$sql = "SELECT count(1) as num from messages where status='unread' and category in ('inbox', 'important') and `to`=?";
		$res = $this->db->query($sql,$user_id);
		$res = $res->result_array();
		return $res[0]['num'];
	}
}