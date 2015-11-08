<?php
class mysql{
	private $connection;
	private $query;
	function __construct(){
		$this->connection = mysqli_connect('localhost', 'toor', 'toor', 'mangacreator_main') or die(mysqli_error($this->connection));
			if (!$this->connection){//$connect
				echo mysqli_connect_errno().mysqli_connect_error();
			}
	}

	function query($sql){
		$this->query = mysqli_query($this->connection, $sql);
	}

	function fetch(){
		return mysqli_fetch_assoc($this->query);
	}

	function fetch_array(){
		$arr = [];
		while($row = $this->fetch()){
			$arr[] = $row;
		}
		return $arr;
	}

	function num_rows(){
		return mysqli_num_rows($this->query);
	}

	function real_escape($string){
		return mysqli_real_escape_string($this->connection, $string);
	}

	static function get_instance(){
		global $mysql;
		return $mysql;
	}

	function get_last_id(){
		return mysqli_insert_id($this->connection);
	}

	function aff_rows(){
		return mysqli_affected_rows($this->connection);
	}
}

?>
