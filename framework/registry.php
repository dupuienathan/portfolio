<?php

define("BASEPATH", dirname(__FILE__) . "/");
define("CONFIG_PATH", BASEPATH . "config/");
define("DATABASE_PATH", BASEPATH . "database/");

// This class was lightly based off of the PHP5 Framework on tutsplus.com but it's heavily modified
class registry {
	private static $classes = array();
	
	private static $settins = array();
	
	private static $frameworkName = "IF Framework 1.0";
	
	private static $instance = null;
	
	private function __construct() {

	}
	
	public static function I() {
		if(!isset(self::$instance)) {
			$obj = __CLASS__;
			self::$instance = new $obj();
		}
		
		return self::$instance;
	}
	
	public function init() {
		$this->load_class("config");
		$this->config->load("autoload");
		
		foreach($this->config->item("libraries", "autoload") as $library) {
			$name= "";
			$directory = "";
			$key = "";
			if(is_array($library)) {
				$name = $library[0];
				$key = $library[1];
				if($name == "database") {
					$directory = "database";
				}
				$this->load_class($name, $directory, $key);
			}else{
				$name = $library;
				$this->load_class($name);
			}
		}
	}
	
	public function __clone() {
		trigger_error("Cloning the registry is not permitted!", E_USER_ERROR);
	}
	
	public function load_class($name, $directory = "", $key = "") {
		if(!isset(self::$classes[$name])) {
			if(file_exists(BASEPATH . $directory . "/" . $name . ".php")) {
				require_once BASEPATH . $directory . "/" . $name . ".php";
				if($key == "") {
					$this->$name = new $name();
				}else{
					$this->$key = new $name();
				}
				
				self::$classes[$name] = $name;
			}else{
				echo "Could not find class: " . $name . ".php<br/>";
			}
		}
	}
}

global $registry;

$registry = registry::I();
