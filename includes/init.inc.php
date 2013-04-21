<?php

# name of the project directory, same as project name "green-earth"
defined('PRJ_DIR') ? NULL : define('PRJ_DIR', 'green-earth');

# dirctory spearator as \ for windows and / for linux, unix
defined('DS') ? NULL : define('DS', DIRECTORY_SEPARATOR);

# path to root directory of the project
defined('SITE_ROOT') ? NULL : define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'].DS.PRJ_DIR);

# path to includes directory (saying as LIB)
defined('LIB_PATH') ? NULL : define('LIB_PATH', SITE_ROOT.DS.'includes');

# including config file
require_once(LIB_PATH.DS.'config.inc.php');

# including functions file
require_once(LIB_PATH.DS.'functions.inc.php');

# including database files
require_once(LIB_PATH.DS.'database.inc.php');

# including sql to javascript variables file
require_once(LIB_PATH.DS.'sql_to_js_var.inc.php');

# including rdf parser file
require_once(LIB_PATH.DS.'rdf_praser.inc.php');

