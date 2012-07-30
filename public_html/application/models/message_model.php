<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message_model extends CI_Model { 
	
	function __construct() {
		parent::__construct();
	}
	
	function get_messages($user_id, $cat, $offset=-1, $limit=-1){
		switch($cat){
			case 'sent': $sql = "SELECT messages.*,f.username as from_username, t.username as to_username FROM messages, users as f, users as t WHERE f.user_id=messages.from and t.user_id=messages.to and messages.from = ?";
						 if($offset>-1 && $limit>-1) $sql.=" limit ?,?";
						 $data = $this->db->query($sql, array($user_id, $offset, $limit));
			break;
			case 'inbox': $sql = "SELECT messages.*, f.username as from_username, t.username as to_username FROM messages, users as f, users as t WHERE f.user_id=messages.from and t.user_id=messages.to and messages.category IN ('inbox','important') AND messages.to = ?";
						  if($offset>-1 && $limit>-1) $sql.=" limit ?,?";
						  $data = $this->db->query($sql, array($user_id, $offset, $limit));
			break;
			default: $sql = "SELECT messages.*, f.username as from_username, t.username as to_username FROM messages, users as f, users as t WHERE f.user_id=messages.from and t.user_id=messages.to and category = ? AND messages.to = ?";
					if($offset>-1 && $limit>-1) $sql.=" limit ?,?"; 
					$data = $this->db->query($sql, array($cat, $user_id, $offset, $limit));
		}
		$res = $data->result_array();
		return $res;
	}
	
	function send_message($user_id){
	}
		
	function get_total_messages($user_id, $cat){
		switch($cat){
			case 'sent': $sql = "SELECT count(1) as num FROM messages WHERE messages.from = ?";
				$data = $this->db->query($sql, array($user_id));
			break;
			case 'inbox': $sql = "SELECT count(1) as num FROM messages WHERE messages.to = ? and messages.category IN ('inbox', 'important')";
				$data = $this->db->query($sql, array($user_id));
			break;
			default: $sql = "SELECT count(1) as num FROM messages WHERE messages.to = ? and category = ?";
				$data = $this->db->query($sql, array($user_id, $cat));
		}
		$res = $data->result_array();
		return $res[0]['num'];
	}
}