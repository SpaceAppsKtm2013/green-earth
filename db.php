<?php

require_once('includes/init.inc.php');

$year_start = 1971;
$year_end = 2007;
$table = "transmission_loss";


for($y=1971; $y<=2007; $y++){
	$sql = "update {$table} set `{$y}`=NULL where `{$y}`=0";
	SQL_to_JS_var::find_by_sql($sql);
}

echo "successful";
