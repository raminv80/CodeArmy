<?php

function points_size ($points=1)  {
    // Helper function to display T-Shirt size based on points
    
	$shirt = "s";
	switch ($points) {
	    case 1:
	    case 2:
	    case 3:
	        $shirt = "s";
	        break;
	    case 5:
	    case 8:
	    case 13:
	        $shirt = "m";
	        break;
	    case 20:
	    case 40:
	        $shirt = "l";
	        break;
	}
	return $shirt;
} 

function get_status_class ($status)  {
    // Helper function to display story header colour based on status
    
	$class = "open";
	switch ($status) {
	    case "open":
	        $class = "open";
	        break;
	    case "in progress":
	    case "reject":
	    case "redo":
	        $class = "progress";
	        break;
	    case "done":
	        $class = "done";
	        break;
	    case "signoff":
	        $class = "paid";
	        break;
	}
	return $class;
} 