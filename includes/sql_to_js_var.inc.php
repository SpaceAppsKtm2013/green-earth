<?php

require_once(LIB_PATH.DS.'database.inc.php');

class SQL_to_JS_var
{

	public static function find_by_sql($sql="") {
		global $database;
		$result_set = $database->query($sql);
		return $result_set;
	}

	public static function sql_to_jqvector_var($sql=""){
		global $database;
		$result_set = self::find_by_sql($sql);
		while ($row = $database->fetch_array($result_set)){
			echo $row[0].":".$row[1].", ";
		}
	}
}
