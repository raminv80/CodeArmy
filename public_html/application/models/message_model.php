<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message_model extends CI_Model { 
	
	function __construct() {
		parent::__construct();
	}
	
	function get_messages($user_id, $cat){
		switch($cat){
			case 'sent': $sql = "SELECT * FROM messages WHERE messages.from = ?"; $data = $this->db->query($sql, array($user_id));break;
			case 'inbox': $sql = "SELECT * FROM messages WHERE messages.category IN ('inbox','important') AND messages.to = ?"; $data = $this->db->query($sql, array($user_id));break;
			default: $sql = "SELECT messages.*, f.username as from_username, t.username as to_username FROM messages, users as f, users as t WHERE f.user_id=messages.from and t.user_id=messages.to and category = ? AND messages.to = ?"; $data = $this->db->query($sql, array($cat, $user_id));
		}
		$res = $data->result_array();
		return $res;
	}
}