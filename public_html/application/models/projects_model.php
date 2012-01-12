<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects_model extends CI_Model { 
	
	var $data = '';
	
	function __construct() {
		parent::__construct();
	}
	
	function cash_loaded(){
		$sql = "SELECT SUM(cost) as num FROM works, sprints WHERE works.sprint=sprints.id and lower(status) in ('open','reject') and curdate() between sprints.start and addtime(sprints.end,'23:59:59')";
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
	
	function get_projects($user_id=0) {
		if($user_id==0){
			$query = "SELECT project.*, u1.username as po_username, u1.user_id as po_user_id, u2.user_id as sm_user_id, u2.username as sm_username FROM project, users as u1, users as u2 where u1.user_id = project.project_owner_id and u2.user_id = project.scrum_master_id order by project_id DESC";
		}else{
			$query = "SELECT * FROM project WHERE project_owner_id=?";
		}
		$result = $this->db->query($query, array($user_id));
		return $result;
	}
	
	function get_worklists($project_id) {
		$query = "SELECT * FROM works WHERE project_id = ? ORDER BY priority DESC";
		$result = $this->db->query($query, array($project_id));
		return $result;
	}
	
	function get_worklist_state($project_id, $cur_sprint=-1) {
		$query = "SELECT * FROM works WHERE project_id = ? AND sprint=? AND lower(status) in ('open','reject') ORDER BY priority ASC";
		$result = $this->db->query($query, array($project_id, $cur_sprint));
		$res = array();
		$res['open'] = $result->result_array();
		$query = "SELECT works.*, users.user_id as champion_id, users.username as champion FROM works, users WHERE project_id = ? AND works.sprint=? AND lower(status) in ('in progress','redo') AND users.user_id=works.work_horse ORDER BY priority ASC";
		$result = $this->db->query($query, array($project_id, $cur_sprint));
		$res['progress'] = $result->result_array();
		$query = "SELECT works.*, users.user_id as champion_id, users.username as champion FROM works, users WHERE project_id = ? AND works.sprint=? AND lower(status) in ('done') AND users.user_id=works.work_horse ORDER BY priority ASC";
		//$query = "SELECT * FROM works WHERE project_id = ? AND lower(status) in ('done') ORDER BY priority DESC";
		$result = $this->db->query($query, array($project_id, $cur_sprint));
		$res['done'] = $result->result_array();
		//$query = "SELECT * FROM works WHERE project_id = ? AND lower(status) in ('verify') ORDER BY priority DESC";
		$query = "SELECT works.*, users.user_id as champion_id, users.username as champion FROM works, users WHERE project_id = ? AND works.sprint = ? AND lower(status) in ('verify') AND users.user_id=works.work_horse ORDER BY priority ASC";
		$result = $this->db->query($query, array($project_id, $cur_sprint));
		$res['verify'] = $result->result_array();
		//$query = "SELECT * FROM works WHERE project_id = ? AND lower(status) in ('signoff') ORDER BY priority DESC";
		$query = "SELECT works.*, users.user_id as champion_id, users.username as champion FROM works, users WHERE project_id = ? AND works.sprint = ? AND lower(status) in ('signoff') AND users.user_id=works.work_horse ORDER BY priority ASC";
		$result = $this->db->query($query, array($project_id, $cur_sprint));
		$res['signoff'] = $result->result_array();
		return $res;
	}
	
	function get_work_points_state($project_id, $cur_sprint=-1) {
		$query = "SELECT sum(points) as points, status FROM works WHERE project_id = ? AND sprint=? GROUP BY status";
		$result = $this->db->query($query, array($project_id, $cur_sprint));
		return $result->result_array();
	}
	
	function get_worklist_sprint($project_id){
		$res = array();
		$query = "SELECT id, start, end, sum(works.points) as point from sprints, works where works.sprint=sprints.id and sprints.project_id=? group by sprints.id, sprints.start, sprints.end";
		$result = $this->db->query($query, array($project_id));
		$sprints = $result->result_array();
		$sprints['general']['id'] = 0;
		foreach($sprints as $sprint):
			$query = "SELECT work_id, title, description, status, points from works where project_id=? and sprint=? order by sprint ASC, priority ASC";
			$result = $this->db->query($query, array($project_id, $sprint['id']));
			$res[$sprint['id']]=array();
			$res[$sprint['id']]['list'] = $result->result_array();
			if($sprint['id']!=0){
				$res[$sprint['id']]['from'] = $sprint['start'];
				$res[$sprint['id']]['to'] = $sprint['end'];
				$res[$sprint['id']]['point'] = $sprint['point'];
			}else{
				$res[$sprint['id']]['from'] = NULL;
				$res[$sprint['id']]['to'] = NULL;
				$res[$sprint['id']]['point'] = 0;
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
		if($total==0)return 0; else
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
			"project_owner_id" => $this->input->post('project_owner'),
			"scrum_master_id" => $this->input->post('scrum_master'),
			"deployer_id" => $this->input->post('deployer'),
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
			"project_owner_id" => $this->input->post('project_owner'),
			"scrum_master_id" => $this->input->post('scrum_master'),
			"deployer_id" => $this->input->post('deployer'),
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
		$query = "SELECT project_id, project_name FROM project where project_owner_id = ? or ?='admin'";
		$result = $this->db->query($query, array($user_id, $this->session->userdata('role')));
		return $result->result_array();
	}
	
	function get_my_projects_detailed($user_id){
		$query = "SELECT p1.project_id, 
						 project_desc, 
						 project_name, 
						 (select max(deadline) from works where works.project_id = p1.project_id) as works_deadline, 
						 (select max(end) from sprints where sprints.project_id = p1.project_id) as sprints_deadline, 
						 (select count(1) from bids,works where bids.work_id = works.work_id and p1.project_id = works.project_id) as bids, 
						 (select count(1) from comments, works where works.project_id=p1.project_id and comments.story_id=works.work_id) as comments, 
						 (select count(1) from works where works.project_id = p1.project_id and lower(works.status)!='draft') as num_works,
						 (select count(1) from works where works.project_id = p1.project_id and lower(works.status) in ('done','verify','signoff')) as submited_works,
						 (select count(1) from works where works.project_id = p1.project_id and lower(works.status) in ('open','redo','in progress', 'reject')) as remaining_works
				  FROM project as p1 where project_owner_id = ?";
		$result = $this->db->query($query, array($user_id));
		return $result->result_array();
	}
	
	function is_project_owner($user_id, $id){
		if ($this->session->userdata('role')=='admin') return true;
		$query = "SELECT project_id FROM project where project_owner_id = ? and project_id=?";
		$res = $this->db->query($query, array($user_id, $id));
		if($res->num_rows()>0){return true;}else{return false;}
	}
	
	function is_scrum_master($user_id, $id){
		if ($this->session->userdata('role')=='admin') return true;
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
	
	function getFirstSprint($id){
		$sql = "select * from sprints where project_id = ? limit 0,1";
		$res = $this->db->query($sql, array($id));
		return $res->result_array();
	}
	
	function get_chart($project_id, $sprint_id){
		$sql = "SELECT 
					sum(works.points) as points, 
					cast(history.created_at as DATE) as day 
				FROM history, sprints, works 
				WHERE 
					sprints.id = ? and 
					sprints.project_id = ? and 
					history.project_id = works.project_id and 
					works.project_id = sprints.project_id and 
					works.work_id = history.work_id and
					works.sprint = sprints.id and
					lower(works.status) in ('verify','signoff') and 
					lower(history.event) in ('verify','signoff') and 
					lower(history.event) = 'verify' and
					history.created_at between sprints.start and addtime(sprints.end, '23:59:59')
				GROUP by day 
				ORDER by day ASC";
		$res = $this->db->query($sql,array($sprint_id, $project_id));
		$res = $res->result_array();
		return $res;
	}
	
	function get_sprint_points($project_id, $sprint_id){
		$sql = "select sum(works.points) as points from works, sprints where sprints.project_id = works.project_id and works.sprint = sprints.id and sprints.id = ? and sprints.project_id = ?";
		$res = $this->db->query($sql, array($sprint_id,$project_id));
		$res = $res->result_array();
		return $res[0]['points'];
	}
	
	function get_resource_chart($project_id,$sprint_id){
		$sql = "SELECT sum(works.points) as points, users.username FROM works, users WHERE users.user_id=works.work_horse AND works.sprint = ? AND works.project_id = ? AND lower(works.status) in ('verify','signoff') GROUP BY users.username";
		$res = $this->db->query($sql, array($sprint_id,$project_id));
		$res = $res->result_array();
		return $res;
	}
}