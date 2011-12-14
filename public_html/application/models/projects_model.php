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
	
	function get_worklist_state($project_id) {
		$query = "SELECT * FROM works WHERE project_id = ? AND lower(status) in ('open','reject') ORDER BY priority DESC";
		$result = $this->db->query($query, array($project_id));
		$res = array();
		$res['open'] = $result->result_array();
		$query = "SELECT works.*, users.user_id as champion_id, users.username as champion FROM works, users WHERE project_id = ? AND lower(status) in ('in progress','redo') AND users.user_id=works.work_horse ORDER BY priority DESC";
		$result = $this->db->query($query, array($project_id));
		$res['progress'] = $result->result_array();
		$query = "SELECT works.*, users.user_id as champion_id, users.username as champion FROM works, users WHERE project_id = ? AND lower(status) in ('done') AND users.user_id=works.work_horse ORDER BY priority DESC";
		//$query = "SELECT * FROM works WHERE project_id = ? AND lower(status) in ('done') ORDER BY priority DESC";
		$result = $this->db->query($query, array($project_id));
		$res['done'] = $result->result_array();
		//$query = "SELECT * FROM works WHERE project_id = ? AND lower(status) in ('verify') ORDER BY priority DESC";
		$query = "SELECT works.*, users.user_id as champion_id, users.username as champion FROM works, users WHERE project_id = ? AND lower(status) in ('verify') AND users.user_id=works.work_horse ORDER BY priority DESC";
		$result = $this->db->query($query, array($project_id));
		$res['verify'] = $result->result_array();
		//$query = "SELECT * FROM works WHERE project_id = ? AND lower(status) in ('signoff') ORDER BY priority DESC";
		$query = "SELECT works.*, users.user_id as champion_id, users.username as champion FROM works, users WHERE project_id = ? AND lower(status) in ('signoff') AND users.user_id=works.work_horse ORDER BY priority DESC";
		$result = $this->db->query($query, array($project_id));
		$res['signoff'] = $result->result_array();
		return $res;
	}
	
	function get_worklist_sprint($project_id){
		$res = array();
		$query = "SELECT id, start, end from sprints where project_id=?";
		$result = $this->db->query($query, array($project_id));
		$sprints = $result->result_array();
		$sprints['general']['id'] = 0;
		foreach($sprints as $sprint):
			$query = "SELECT work_id, title, description, status from works where project_id=? and sprint=? order by sprint ASC, priority ASC";
			$result = $this->db->query($query, array($project_id, $sprint['id']));
			$res[$sprint['id']]=array();
			$res[$sprint['id']]['list'] = $result->result_array();
			if($sprint['id']!=0){
				$res[$sprint['id']]['from'] = $sprint['start'];
				$res[$sprint['id']]['to'] = $sprint['end'];
			}else{
				$res[$sprint['id']]['from'] = NULL;
				$res[$sprint['id']]['to'] = NULL;
			}
		endforeach;
		return $res;
	}
	
	function get_percentage($project_id){
		$sql = "select count(*) as num from works where project_id=?";
		$res=$this->db->query($sql, array($project_id));
		$res = $res->result_array();
		$total = $res[0]['num'];
		$sql = "select count(*) as num from works where project_id=? and lower(status) in ('verify','signoff')";
		$res=$this->db->query($sql, array($project_id));
		$res = $res->result_array();
		$completed = $res[0]['num'];
		return round($completed/$total*100);
	}
	
	function get_project_from_sprint($sprint_id){
		$sql = "select project_id from sprints where id = ?";	
		$res = $this->db->query($sql, array($sprint_id));
		if($res->num_rows()>0){
			$res = $res->result_array();
			return $res[0]['project_id'];
		}else return false;
	}
	
	function delete_sprint($sprint_id){
		$doc=array('sprint'=>0);
		$whr=array('sprint'=>$sprint_id);
		$this->db->update('works',$doc,$whr);
		$this->db->delete('sprints',array('id'=>$sprint_id));	
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
		$query = "select * from categories where project_id = ? or ?=0";
		$query = $this->db->query($query, array ($project_id, $project_id));
		return $query;
	}
	
	function get_my_projects($user_id){
		$query = "SELECT project_id, project_name FROM project where project_owner_id = ?";
		$result = $this->db->query($query, array($user_id));
		return $result->result_array();
	}
	
	function is_project_owner($user_id, $id){
		$query = "SELECT project_id FROM project where project_owner_id = ? and project_id=?";
		$res = $this->db->query($query, array($user_id, $id));
		if($res->num_rows()>0){return true;}else{return false;}
	}
	
	function is_scrum_master($user_id, $id){
		$query = "SELECT project_id FROM project where scrum_master_id = ? and project_id=?";
		$res = $this->db->query($query, array($user_id, $id));
		if($res->num_rows()>0){return true;}else{return false;}
	}
	
	function get_collaborators($project_id){
		$sql = "SELECT DISTINCT users.user_id, user_profiles.avatar, users.username FROM users, works, user_profiles WHERE works.project_id = ? AND works.work_horse=users.user_id and users.user_id=user_profiles.user_id";
		$res = $this->db->query($sql, array($project_id));
		$res = $res->result_array();
		return $res;
	}
	
	function get_sprints($id){
		$sql = "select * from sprints where project_id = ?";
		$res = $this->db->query($sql, array($id));
		$res = $res->result_array();
		return $res;
	}
	
	function get_sprint($sprint_id){
		$sql = "SELECT * from sprints where id=?";
		$res = $this->db->query($sql, array($sprint_id));
		return $res->result_array();
	}
	
	function getCurrentSprint($id){
		$sql = "select * from sprints where project_id = ? and curdate()>=start AND curdate()<=end";
		$res = $this->db->query($sql, array($id));
		return $res->result_array();
	}
	
	function get_chart($project_id, $sprint_id){
		$sql = "SELECT sum(works.points) as points, cast(history.created_at as DATE) as day FROM history, sprints, works where sprints.id = ? and sprints.project_id = ? and history.project_id = works.project_id and works.project_id = sprints.project_id and lower(works.status) in ('verify','signoff') and lower(history.event) not in ('verify','signoff') and history.created_at between sprints.start and sprints.end and history.work_id = works.work_id group by day order by day ASC";
		$res = $this->db->query($sql,array($sprint_id, $project_id));
		$res = $res->result_array();
		return $res;
	}
	
	function get_sprint_points($project_id, $sprint_id){
		$sql = "select sum(works.points) as points from works, sprints where sprints.project_id = works.project_id and sprints.id = ? and sprints.project_id = ?";
		$res = $this->db->query($sql, array($sprint_id,$project_id));
		$res = $res->result_array();
		return $res[0]['points'];
	}
}