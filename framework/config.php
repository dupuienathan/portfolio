<?php

class Config {
	var $config = array();
	
	function __construct() {
		$this->load("config");
	}
	
	public function load($file) {
		if(file_exists(CONFIG_PATH . $file . ".php")) {
			include(CONFIG_PATH . $file . ".php");
			
			if(!isset($config)) {
				return FALSE;
			}
			
			if(!is_array($config)) {
				return FALSE;
			}
			
			$this->config = array_merge($this->config, $config);
		}
	}
	
	public function item($item, $section = "") {
		if($section != "") {
			if(isset($this->config[$section][$item])) {
				return $this->config[$section][$item];
			}else{
				return false;
			}
		}else{
			if(isset($this->config[$item])) {
				return $this->config[$item];
			}else{
				return false;
			}
		}
	}
}
