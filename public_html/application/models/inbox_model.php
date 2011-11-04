<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inbox_model extends CI_Model { 

	var $data = '';
	
	function __construct() {
		parent::__construct();
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
}