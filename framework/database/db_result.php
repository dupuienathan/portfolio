<?php

class db_result {
	var $link_id;
	var $result_id;
	
	function __construct($linkid, $result) {
		$this->link_id = $linkid;
		$this->result_id = $result;
	}
}

?>