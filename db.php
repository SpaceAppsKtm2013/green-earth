<?php

require_once('includes/init.inc.php');

$year_start = 1971;
$year_end = 2008;
$table = "energy_production";


for($y=1971; $y<=2008; $y++){
	$sql = "update {$table} set `{$y}`=NULL where `{$y}`=0";
	SQL_to_JS_var::find_by_sql($sql);
}
