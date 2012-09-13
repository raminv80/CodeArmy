<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	function check_last_login() {
		$strSQL = "SELECT user_id FROM users WHERE DATE_SUB(NOW(),INTERVAL 2 DAY) >= last_login";
		$res = $this->db->query($strSQL);
		if($res->num_rows() > 0) {
			return $res->result_array();
		} else {
			return false;
		}
	}
	
	function check_last_reminder($userid){
		$strSQL = "SELECT user_id, reminder FROM users WHERE user_id = ?";
		$res = $this->db->query($strSQL, $userid);
		if($res->num_rows() > 0) {
			return $res->result_array();
		} else {
			return false;
		}
	}
	
	function update_reminder($reminder, $userid){
		$strSQL = "UPDATE users SET reminder = ? WHERE user_id = ?";
		$this->db->query($strSQL, array($reminder, $userid));
	}
}
?>