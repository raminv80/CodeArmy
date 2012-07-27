<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message_model extends CI_Model { 
	
	function __construct() {
		parent::__construct();
	}
	
	function get_messages($user_id, $cat){
		switch($cat){
			case 'sent': $sql = "SELECT * FROM messages WHERE from = ?"; $data = $this->db->query($sql, array($user_id));
			default: $sql = "SELECT * FROM messages WHERE categry = ? AND to = ?"; $data = $this->db->query($sql, array($cat, $user_id));
		}
		$res = $data->result_array();
		return $res;
	}
}