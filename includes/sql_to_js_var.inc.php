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
			echo $row[1]!=NULL ? $row[0].":".$row[1].", " : NULL;
		}
	}

	public static function sql_to_jqplot_var($sql=""){
		global $database;
		$result_set = self::find_by_sql($sql);
		$j=0;
		while ($row = $database->fetch_array($result_set)){
			$i=0;
			echo "var line{$j} = [";
			foreach($row as $col){
				if($i>4){
					$key = array_keys($row);
					echo "['".$key[$i] . "', " .$col."], "; 
				}
				$i++;
			};
			echo "];\n";
			$j++;
		}
		
	}

	public static function sql_to_jqplot_series_var($sql=""){
		global $database;
		$result_set = self::find_by_sql($sql);
		$j=0;
		while ($row = $database->fetch_array($result_set)){
			echo "{label:' ".$row["country"]."'}, ";
		}

	}
		
	
	
	
}
