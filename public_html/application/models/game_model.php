<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Game_model extends CI_Model { 
	
	function __construct() {
		parent::__construct();
	}
	
	function get_level($exp){
		$sql = "SELECT player_level FROM game_v3 WHERE ((xp_from<=?) OR (xp_from=0)) AND ((xp_to>?) OR (xp_to=0))";
		$res = $this->db->query($sql, array($exp,$exp));
		$res = $res->result_array();
		return $res[0]['player_level'];
	}
	
	function get_progress_bar($exp){
		$lvl = $this->get_level($exp);
		if($lvl>99) return 1;
		$sql = "SELECT player_level, xp_from, xp_to, level_up_xp FROM game_v3 WHERE ((xp_from<=?) OR (xp_from=0)) AND ((xp_to>?) OR (xp_to=0))";
		$res = $this->db->query($sql, array($exp,$exp));
		$res = $res->result_array();
		return ($exp - $res[0]['xp_from'])/($res[0]['level_up_xp']);
	}
	
	function points_left($exp){
		return points_per_level - ($exp % points_per_level);
		$sql = "SELECT player_level, xp_from, xp_to, level_up_xp FROM game_v3 WHERE ((xp_from<=?) OR (xp_from=0)) AND ((xp_to>?) OR (xp_to=0))";
		$res = $this->db->query($sql, array($exp));
		$res = $res->result_array();
		return $res[0]['level_up_xp'] + $res[0]['xp_from'] - $exp;
	}
	
	function job_points($hour, $level ){
		$sql = "SELECT job_hour_xp FROM game_v3 WHERE player_level = ?";
		$res = $this->db->query($sql, array($level));
		$res = $res->result_array();
		return $res[0]['job_hour_xp'] * $hour;
	}
	
	function get_work_skill_dificaulty($work_id){
		$sql = "SELECT (SELECT max(weight) from skill)*(SELECT max(skill_point) FROM skill_level) as max";
		$res = $this->db->query($sql)->result_array();
		$max = $res[0]['max'];
		$sql = "select max(point*weight) as point from skill, work_skill where work_id='5863448921578' and skill_id=skill.id";
		$res = $this->db->query($sql,$work_id)->result_array();
		$point = $res[0]['point'];
		return $point/$max;
	}
	
	function get_type_dificaulty($work_id){
		//TODO: calc $type as normalaized wight of job dificulty based on mission type
		$type = 0.5;
		return $type;
	}
	
	function cal_job_points($work_id,$user_id){
		$nslw = $this->get_work_skill_dificaulty($work_id);
		$ntw = $this->get_type_dificaulty($work_id);
		$avg_weight = ($nslw+$ntw)/2;
		
		$sql = "SELECT exp FROM users WHERE user_id=?";
		$res = $this->db->query($sql, $user_id);
		$exp = $res[0]['exp'];
		
		$level = $this->get_level($exp);
		
		$sql = "SELECT arrangement_type.weight*bids.bid_time as spent_time FROM arrangement_type,works,bids WHERE bids.user_id=? AND bids.work_id=? AND bids.status='Accepted' AND works.est_arrangement = arrangement_type.id AND works.work_id=?";
		$res = $this->db->query($sql,array($user_id,$work_id,$work_id))->result_array();
		$hour = (count($res)>0)? $res[0]['spent_time']:0;
		
		return round($this->job_points($hour,$level)*$avg_weight);
	}
}