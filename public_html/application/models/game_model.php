<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Game_model extends CI_Model { 
	
	function __construct() {
		parent::__construct();
	}
	
	function get_level($exp){
		$sql = "SELECT player_level FROM game_v3 WHERE ((xp_from<=?) OR (xp_from=0)) AND ((xp_to>?) OR (xp_to=0))";
		$res = $this->db->query($sql, array($exp));
		$res = $res->result_array();
		return $res[0]['player_level'];
	}
	
	function get_progress_bar($exp){
		$lvl = $this->get_level($exp);
		if($lvl>99) return 1;
		$sql = "SELECT player_level, xp_from, xp_to, level_up_xp FROM game_v3 WHERE ((xp_from<=?) OR (xp_from=0)) AND ((xp_to>?) OR (xp_to=0))";
		$res = $this->db->query($sql, array($exp));
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
}