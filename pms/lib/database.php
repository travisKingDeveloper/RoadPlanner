<?php
/*
 * The-Di-Lab coding lib
 * www.the-di-lab.com
 */
require_once 'setting.php';
class Database {
	private $query;
	private $results;

	private static $Database;

	//connect to the Database
	private function __construct() {		
		$this->link = mysql_connect(Setting::$dbhost, Setting::$dbuser, Setting::$dbpass) or die(mysql_error());
		mysql_select_db(Setting::$dbname) or die(mysql_error());
	}
	public static function singleton() {
		if (!isset (self :: $Database)) {
			self :: $Database = new Database();
		}
		return self :: $Database;
	}
	public function query($query) {
		$this->query = $query;
		return $this->execute();
	}
	//execute the mysql query
	private function execute() {
		$this->results = mysql_query($this->query, $this->link) or die(mysql_error());
		return $this->results;
	}
}