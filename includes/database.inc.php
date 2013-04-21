<?php

# including config file
require_once(LIB_PATH.DS.'config.inc.php');

# creating database class
class MySQLDatabase{
	
	private $connection;
	private $magic_quotes_active;
	private $real_escape_string_exists;
	public $last_query;

# constructor 
	function __construct(){
	# establising the connection
		$this->open_connection();
	# check magic_quotes_gpc [http://www.php.net/manual/en/function.get-magic-quotes-gpc.php]
		$this->magic_quotes_active = get_magic_quotes_gpc();
	# check mysql_real_escape_string function
		$this->real_escape_string_exists = function_exists( "mysql_real_escape_string" );
	}

	public function open_connection(){
		$this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
		if(!$this->connection){
			die("Database connection failed: " . mysql_error());
		}else{
			$this->db_select = mysql_select_db(DB_NAME, $this->connection);
			if(!$this->db_select)
				die("Database connection failed: " . mysql_error());
		}
	}

	public function query($sql){
		$this->last_query = $sql;
		$result = mysql_query($sql, $this->connection);
		$this->confirm_query($result);
		return $result;
	}

	private function confirm_query($result){
		if(!$result){
		
# if you want to check sql error
#			$output = "Database query failed: " . mysql_error() . "<br />";
#			$output.= "Last SQL query: " . $this->last_query;
#			die($output);
	
			die("Invalid! query");
		}
	}

	public function escape_value( $value ) {
		if($this->real_escape_string_exists) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if($this->magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if(!$this->magic_quotes_active) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}

// database neutral methods
	public function fetch_array($result_set){
		return mysql_fetch_array($result_set);
	}

	public function num_rows($result_set){
		return mysql_num_rows($result_set);
	}

# destructor for closing database
	# closing the connection
	public function close_connection(){
		if(isset($this->connection)){
			mysql_close($this->connection);
			unset($this->connection);
		}
	}

	# destructor to close the connection
	function __destruct(){
		$this->close_connection();
	}


}

# $db as object of MySQLDatabase class
$database = new MySQLDatabase();

