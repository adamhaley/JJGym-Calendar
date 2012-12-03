<?
/**
*@package db.php
*This file holds db related classes
*class db, class dbresult, class dbcache
*/
/**
*@package db
*DB wrapper class.
*Use this class for all database interactions.
*For the time being MYSQL is the only supported db.
*Add support for new engine or modify class if db engine changes
*/
class db{
	var $dbc;
	var $result;
	var $numrows;
	
	/**
	*Constructor. Takes HOST,USER,PASS,DBNAME
	*Connects to DB and selects DB
	*/
	function db($host,$user,$pass,$dbname){
		$this->dbc = mysql_connect($host,$user,$pass);
		$this->result = '';
		mysql_select_db("$dbname");
		return;	
	}
	
	/**
	*Returns result row as associative array
	*/
	function fetchrow(){
		$res = $this->result;
		
		if(is_resource($res)){
			return mysql_fetch_assoc($res);
		}
	
		return array();
	}
	
	/**
	*Runs query. 
	*@param string sql query
	*@return resource result
	*/
	function query($sql){
		global $message;
		
		

	
		if($_SESSION['mode'] == 'debug'){
			$message->add("warning",utf8_encode($sql) . " <br />");
		}
		if(!$this->result = mysql_query($sql)){
			$message->add("error","MYSQL Error: " . mysql_error());		
				//echo "Set error: " . mysql_error();
		}

		
		//$message->add('warning',$sql);
		
		return $this->result;
	}
		
	/**
	*Returns an array of arrays, each representing a result row. 
	*/
	function fetchallrows(){
		$i=0;
		$rows = array();
		
		if(is_resource($this->result)){
			if(mysql_num_rows($this->result)>0){
				mysql_data_seek($this->result,0);
			}
		
			while($row = mysql_fetch_assoc($this->result)){
				$rows[] = $row;
				$i++;
			}
		}
		return $rows;
	
	}	

	/**
	*Selects a database. 
	*@param db name
	*/
	function select_db($db){
		return mysql_select_db($db);	
	}
	
	/**
	*Returns auto increment id of last query
	*@return int id
	*/
	function insert_id(){
		return mysql_insert_id();	
	}
}
/**
*@package dbresult
*class to represent an sql query and its result data
*/
class dbresult{
	var $sql;
	var $row;
	var $allrows;
	
	function dbresult($sql=''){
		global $db;
		
		
		$this->sql = $sql;
		
		//query the database
		$db->query($sql);
		
		//set row to fetchrow
		$this->row = $db->fetchrow();
		
		
		
		//set allrows to fetchallrows
		$this->allrows = $db->fetchallrows();
	}

	function set_prop($prop,$value){
		eval("\$this->$prop = $value;");		
	}
	
	function get_prop($prop){
		eval("\$value = \$this->$prop;");
		return $value;
	}
	function fetchrow(){
		return $this->get_prop('row');	
	}
	function fetchallrows(){
		return $this->get_prop('allrows');	
	}
	
}

/**
*@package dbcache
*DB cacheing class
*Use this class for cacheing dbresults
*
*/

class dbcache{
	var $cachearray;
	function dbcache(){
		
		$this->cachearray = array();
		
	}	

	function query($sql){
		$array = $this->cachearray;
	
		foreach($this->cachearray as $res){
			if($res->get_prop('sql') == $sql){
				//echo "loading $sql  from cache <br />";
				return $res;	
			}
		}
		return $this->_add($sql);	
	}

	function _add($sql){
		
		$res = new dbresult($sql);	
		$this->cachearray[] = $res;
		return $res;
		
	}
	
}
?>
