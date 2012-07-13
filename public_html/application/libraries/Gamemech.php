<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Gamemech {
	
	//ver3
	/*
    function get_level($exp){
		$lvl = floor($exp / points_per_level)+1;
		if ($lvl>99) $lvl = 99;
		return $lvl;
	}
	
	function get_progress_bar($exp){
		$lvl = floor($exp / points_per_level)+1;
		if($lvl>99) return 1;
		return ($exp % points_per_level)/points_per_level;
	}
	
	function points_left($exp){
		return points_per_level - ($exp % points_per_level);
	}
	
	function job_points($hour, $level ){
		
	}
	*/
	
	//ver5
	function get_level($exp){
		$lvl = floor($exp / points_per_level)+1;
		if ($lvl>99) $lvl = 99;
		return $lvl;
	}
	
	function get_progress_bar($exp){
		$lvl = floor($exp / points_per_level)+1;
		if($lvl>99) return 1;
		return ($exp % points_per_level)/points_per_level;
	}
	
	function points_left($exp){
		return points_per_level - ($exp % points_per_level);
	}
	
	function job_points($hour, $level ){
		
	}
}

/* End of file GameMech.php */