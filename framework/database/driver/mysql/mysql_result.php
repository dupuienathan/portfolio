<?php

class mysql_res extends db_result {
	
	function __construct($link, $res) {
		db_result::__construct($link, $res);
	}
	
		
	function num_rows() {
		return mysqli_num_rows($this->result_id);
	}
	
	function result() {

		$res_obj = array();
		
		while($res = mysqli_fetch_object($this->result_id)) {
			$res_obj[] = $res;
		}
		
		return $res_obj;
	}
}

?>