<?php

class mysql_db extends db {
	
	var $linkid;

	function __construct($host, $user, $pass, $data, $port) {
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->data = $data;
		$this->port = $port;
		
		$this->connect();
	}
	
	function connect() {
		$this->linkid = mysqli_connect($this->host, $this->user, $this->pass) or die("Could not connect to mysql server");
		mysqli_select_db($this->linkid, $this->data) or die("Could not select mysql database: " . $this->data);
	}
	
	function query($query) {
		$this->connect();
		$res = mysqli_query($this->linkid, $query) or die(mysqli_errno($this->linkid) . ": " . mysqli_error($this->linkid));
		$this->disconnect();
		return $res;
	}
	
	function select($select) {
		$this->select = $select;
		return $this;
	}
	
	function from($from) {
		$this->from = $from;
		return $this;
	}
	
	function limit($num) {
		$this->limit = $num;
		return $this;
	}
	
	function where($key, $val) {
		$this->where[] = array($key, $val);
		return $this;
	}
	
	function join($table, $data) {
		$this->join = $table;
		$this->join_data = $data;
		return $this;
	}
	
	function get() {
		$query = "SELECT ";
		
		$query .= $this->select . " FROM ";
		
		$query .= "`".$this->from."` ";
		
		if($this->join != "") {
			$query .=" JOIN " . $this->join . " ON " . $this->join_data . " ";
		}
		
		if(count($this->where) > 0) {
			$query .= " WHERE ";
			$where_str = array();
			foreach($this->where as $wh) {
				$q = "`".$wh[0]."` = ";
				
				if(is_string($wh[1])) {
					$q .= "\"".$wh[1]."\"";
				}else{
					$q .= $wh[1];
				}
				
				$where_str[] = $q;
			}			
			$query .= join(" AND ", $where_str);
		}
		
		if($this->limit != "") {
			$query .= " LIMIT " . $this->limit;
		}
		
		if($this->order != "") {
			$query .= " ORDER BY " . $this->order . " " . $this->order_type; 
		}
		
		$query .= ";";
		
		$this->select = "";
		$this->from = "";
		$this->where = array();
		$this->join = "";
		$this->join_data = "";
		$this->limit = "";
		$this->like = "";
		
		$res = $this->query($query);
		
		return new mysql_res($this->linkid, $res);
	}
	
	function disconnect() {
		mysqli_close($this->linkid);
	}
}

?>