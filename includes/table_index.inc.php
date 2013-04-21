<?php

require_once(LIB_PATH.DS.'database.inc.php');

class table_index
{

	public static $table;
	public static $rdf;
	public static $dataset;
	public static $unit;
	public static $dark_tone_hex;
	public static $light_tone_hex;



	public static function init_for_query($id=1) {
		global $database;
		$sql = "SELECT * FROM data_index WHERE id={$id} LIMIT 1";
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
			self::$table = $row["table"];
			self::$rdf = $row["rdf"];
			self::$dataset = $row["dataset"];
			self::$unit = $row["unit"];
			self::$dark_tone_hex = $row["darktone"];
			self::$light_tone_hex = $row["lighttone"];
	}
}

