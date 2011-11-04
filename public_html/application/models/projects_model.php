<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects_model extends CI_Model { 
	
	var $data = '';
	
	function __construct() {
		parent::__construct();
	}
	
	function cash_loaded(){
		$sql = "SELECT SUM(cost) as num FROM works WHERE lower(status) in ('open','reject')";
		$res = $this->db->query($sql);
		$res = $res->result_array();
		return $res[0]['num'];	
	}
	
	function get_all_projects() {
		$query = "SELECT * FROM project";
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function get_all_categories(){
		$query = "SELECT * FROM categories";
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function get_projects($user_id) {
		$query = "SELECT * FROM project WHERE project_owner_id=?";
		$result = $this->db->query($query, array($user_id));
		return $result;
	}
	
	function get_worklists($project_id) {
		$query = "SELECT * FROM works WHERE project_id = ? ORDER BY priority DESC";
		$result = $this->db->query($query, array($project_id));
		return $result;
	}
	
	function save_priority() {
		$query = "UPDATE works SET priority = ? WHERE work_id = ?";
		$result = $this->db->query($query, array($this->input->post('priority'), $this->input->post('work_id')));
		return $result;
	}
	
	function log_history($user_id, $project_id, $work_id, $event, $status=0, $desc = ''){
		$log = array(
			"user_id" => $user_id,
			"work_id" => $work_id,
			"event" => $event,
			"status" => $status,
			"project_id" => $project_id,
			"Desc" => $desc,
			"created_at" => date('Y-m-d H:i:s')
		); 
		if($this->db->insert('history', $log)) {
			return $log['user_id'];
		} else {
			return false;
		}
	}
	
	function num_projects_month(){
		$query = "select count(*) as num from project where project_created_at >= ?";
		$result = $this->db->query($query, array(date('Y-m').'-0 00:00:00', ));
		$data = $result->result_array();
		return $data[0]['num'];
	}
	
	function create_project($creator_id){
		$doc = array(
			"project_name" => $this->input->post('title'),
			"project_desc" => $this->input->post('description'),
			"project_owner_id" => $creator_id,
			"project_created_at" => date('Y-m-d H:i:s') 
		);
		
		if($this->db->insert('project', $doc)) {
			$query = "select max(project_id) as num from project";
			$result = $this->db->query($query, array());
			$data = $result->result_array();
			return $data[0]['num'];	
		} else {
			return false;
		}
	}
	
	function edit_project($id) {
		
		$doc = array(
			"project_name" => $this->input->post('title'),
			"project_desc" => $this->input->post('description')
		); 
		
		if($this->db->update('project', $doc, array('project_id' => $id))) {
			return $id;		
		} else {
			return false;
		}
		
	}
	
	function get_project_details($id){
		$query = "select * from project where project_id = ?";
		$result = $this->db->query($query, array($id));
		return $result;
	}
	
	//get all categories for selected project id
	function get_categories($project_id){
		$query = "select * from categories where project_id = ?";
		$query = $this->db->query($query, array ($project_id));
		return $query;
	}
}