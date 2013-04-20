<?php

require_once('includes/init.inc.php');

$sql = "SELECT country, `1971` from energy_supply ";
SQL_to_JS_var::sql_to_jqvector_var($sql);
