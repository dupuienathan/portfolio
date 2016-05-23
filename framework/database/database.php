<?php

define("DB_DRIVER_PATH", DATABASE_PATH . "driver/");
require_once(DATABASE_PATH . "db_result.php");

class db {
	var $host = "";
	var $user = "";
	var $pass = "";
	var $data = "";
	var $port = 0;
	
	var $select;
	
	var $from;
	
	var $where = array();
	
	var $limit;
	
	var $order;
	
	var $order_type;
	
	var $like;
	
	var $join;
	
	var $join_data;
	
	function __construct($host, $user, $pass, $data, $port = 3306) {
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->data = $data;
		$this->port = $port;
	}
}

class database {
	
	var $default_db;
	
	var $databases = array();
	
	function __construct() {
		registry::I()->config->load("database");
		$default = registry::I()->config->item("default", "database");
		
		if(!isset($this->databases[$default])) {
			$conf = registry::I()->config->item($default, "database");
			
			$this->default_db = $default;
			
			$driver = $conf["dbdriver"];
			
			$driver_class = $driver. "_db";
			
			require(DB_DRIVER_PATH . $driver . "/" . $driver_class . ".php");
			require(DB_DRIVER_PATH . $driver . "/" . $driver . "_result.php");
			
			$this->databases[$default] = new $driver_class($conf["hostname"], $conf["username"], $conf["password"], $conf["database"], $conf["port_num"]);
		}
	}
	
	function query($query) {
		$this->check_db();
		$this->databases[$this->default_db]->query($query);
	}
		
	function check_db() {
		if(!isset($this->databases[$this->default_db])) {
			die("Default DB not selected!");
		}
	}
	
	function select($select) {
		$this->check_db();
		$this->databases[$this->default_db]->select($select);
		return $this;
	}
	
	function from($from) {
		$this->check_db();
		$this->databases[$this->default_db]->from($from);
		return $this;
	}
	
	function where($key, $val) {
		$this->check_db();
		$this->databases[$this->default_db]->where($key, $val);
		return $this;
	}
	
	function limit($num) {
		$this->check_db();
		$this->databases[$this->default_db]->limit($num);
		return $this;
	}
	
	function get() {
		$this->check_db();
		return $this->databases[$this->default_db]->get();
	}
	
	function join($table, $data) {
		$this->check_db();
		return $this->databases[$this->default_db]->join($table, $data);
	}
}

?>