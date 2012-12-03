<?
/**
*
*@package resource.php
*/
/** 
*Resource class. This is an abstract superclass that represents the behavior of all "resource" 
*
*@author Adam Haley <adam.x.haley@disney.com>
*@access public
*@package resource
*
*/
class resource{

	var $database = '';
	var $new = 1;
	var $table = '';
	
	
	/**
	*Returns associative array of property/values
	*If you pass an array of property names, it will return ana associative array containing only those properties
	*/
	function get_props_array($array=array()){
	
		$ret = array();
		if(count($array)){
		
			foreach($array as $prop){
				if($prop==$this->get_id_string()){
					$ret['id'] = $this->get_prop($prop);
				}
				$ret[$prop] = $this->get_prop($prop);	
			
			}	
		}else{
			foreach($this->props as $k => $v){

				if($k == $this->get_id_string()){
					$ret['id'] = $this->get_prop('id');
				}
				$ret[$k] = $this->get_prop($k);	
			}	
		}	
	
		return $ret;
	}
	

	function get_table(){
   	 	return $this->table ? $this->table : get_class($this);
  	}

	/**
	*Returns prop/values as xml
	*/
	function get_props_xml(){
		$class = $this->class? $this->class : get_class($this);
		$out = "";
		$out .= "<resource class='$class'>\n";
		$array = $this->get_props_array();
		foreach($array as $k => $v){
	
			$view = $this->props[$k]['view'];
			
			$v = $this->_replace_special_chars($v);
			
			
			$varray = explode("\r\n", chunk_split($string,1));
			//$varray = str_split($view);
			$view = $varray[0];
			
			$out .= "\t<$k ";


			if(is_array($this->props[$k])){
			foreach($this->props[$k] as $key => $value){
				if($key != 'value' && $key != 'object' && $key != 'map'){
					$value = $this->_replace_special_chars($value);
					
					
					if($key == 'list' && is_array($value)){
							$array = $value;
							$value = '';
							foreach($array as $l){
								$value .= $l . ",";
							}
							$value = preg_replace("/,$/","",$value);
					}
					$out .= " $key='$value' ";	
				}
			}
			}
		
			$out .= ">";
			$out .= $v;

			$out .= "</$k>\n";	
		}
		$out .= "</resource>";
		return $out;
	}
	
	/**replace stuff for xml**/
	function _replace_special_chars($v){
		$v = str_replace("&","&amp;",$v);
		$v = str_replace("<","&lt;",$v);
		$v = str_replace(">","&gt;",$v);	
		$v = str_replace("'","&#39;",$v);
		return $v;
	}
	
	/**
	*Gets all resources where conditions match. return as xml
	*/
	function get_all_xml($conditions=array()){
		$objarray = $this->get_all($conditions);
		foreach($objarray as $obj){
			$out .= $obj->get_props_xml();	
		}
		return $out;
	}
	
	function get_id_string(){
		return  get_class($this) . '_id';
	}


	function get_foreign_resources(){
		$resarray = array();
		foreach($this->props as $k => $v){
			if($res = $v['object']){
				
				if(is_object($res)){
					
					$resarray = array_merge($resarray,$res->get_all(array('order_by' => 'name','name|!=|'=>'')));
				}
			}else if($list = $v['list']){
				foreach($list as $l){

					$idstring = $this->get_id_string();

					$res = new resource_x();
					$res->set_prop("$idstring",$l);
					$res->set_prop('name',$l);
					$res->class = $k;
					
					$resarray[] = $res;
				}	
			}
		}
		
		return $resarray;
	}
	

	function id_from_prop_value($propname,$value){
		if($obj = $this->props[$propname]['obj']){
			$array = $obj->get_props_array();
			foreach($array as $k => $v){
				if($v == $value){
					return $k;	
				}	
			}
		}	
		return 0;
	}
	
	function friendly_classname(){
		$class = get_class($this);
		$class = str_replace("_"," ",$class);
		return ucwords($class);	
	}
	
	function sql_file_name($action){
		global $message;
		
		$name = get_class($this);
		$file = "sql/$name" . "_" . "$action.sql";
		
		return $file;
	}
	
	/**
	*Takes an id and populates the object properties from the database where id is the given id
	*/
	function load($id){
	
		global $dbcache;
		
		global $message;	
		


		if(!$id){
			$message->add("warning","returning false in load");	
			return false;
		}
	
		
		$file = $this->sql_file_name('select');
		$idstring = $this->get_id_string();
		$this->set_prop("$idstring",$id);
		
		$tobj = new template($file);
		$sql = $tobj->parse_resource($this);	
		if($sql){
			$idfield = $this->props["$idstring"]['map'];
			
			//add id to where clause
			$sql .= " and $idfield =" . $id;
		
			//run query
			$res = $dbcache->query($sql);
			
			//get row
		
			$row = $res->fetchrow();
		}else{
			$message->add("error","empty sql from $file");	
		}
		
		
		if(!is_array($row)){
		
			$message->add("warning","returning false in load"); 
			return false;	
		}	
		
		//loop through, set property 
		foreach($row as $k => $v){
				//echo "$k :: $v <br />";
				$value = $this->get_prop($k);
				if($value == '' || $value == '1'){
					$v = stripslashes($v);
					$this->set_prop($k,$v);//set prop to value
				}
		}
		//set new to false
		$this->new = 0;
		return;
	}

	/**
	*Returns an array of all  resources of this class
	*/
	
	function get_all($conditions = array()){
		global $dbcache;
		global $message;
		$sqlfile = $this->sql_file_name('select');
		
		$sqlobj = new template("$sqlfile");
		
		$sql = $sqlobj->parse_resource($this);
		$sql = $sqlobj->get_source();
		if($sql){
			$cond = $this->sql_conditions($conditions);
		
			$sql .= $cond;

			$res = $dbcache->query($sql);
		
			$classname = get_class($this);
			$array = array();
			
		
			//loop through query results
			//create new object for each row & return array
			$rows = $res->fetchallrows();

			
			foreach($rows as $row){
					eval("\$obj = new $classname;");
					foreach($row as $k => $v){	
						$v = stripslashes($v);
						$obj->set_prop($k,$v);
					}	
			
			
				$array[] = $obj;
			}
			return $array;
		}else{
			$message->add("error","empty sql from $sqlfile");	
		}
	}
	
	
	
	/**
	*Returns an associative array of id's and the first property in the prop array of all  resources of this class
	*/
	function get_all_assoc($conditions=array()){
		$conditions = count($conditions)? $conditions : array();
		$props = $this->props;
		next($props);
		$secondkey = key($props);
		
		$conditions['order_by'] = isset($conditions['order_by'])? $conditions['order_by'] : $this->get_id_string();
		
		$array = $this->get_all($conditions);
		$returnarray = array();
		foreach($array as $obj){
			$props = $obj->props;
			
			$returnarray[$obj->get_prop($this->get_id_string())] = $obj->get_prop($secondkey);
		}
		return $returnarray;
	}
	/**
	*Clears all the properties, sets their value to ''
	*/
	function clear(){
		//the opposite of populate, this function clears all the properties of a resource
		foreach($this->props as $k => $v){
			$this->props[$k]['value'] = '';	
		}
	}
		
	/**
	*Sets the given property name to the given value
	*/ 
	function set_prop($prop,$value){
		//set property
		if($prop == 'id'){
			$this->props[$this->get_id_string()]['value'] = $value;
		}
		if($prop == $this->get_id_string()){
			$this->props['id']['value'] = $value;
		}
		if(isset($this->props[$prop])){
			$this->props[$prop]['value'] = $value;
		}
	}
	
	/**
	*Takes a property name and returns the value
	*/ 
	function get_prop($prop){
		global $message;
		//get property
		$value = $this->props[$prop]['value'];

		$dtype = $this->props[$prop]['datatype'];
		if($dtype=='datetime'){
			$value = $this->format_datetime($value);  
		}
		return $value;
	}

	function format_datetime($value){
		global $message;
	  if($value){
    if (($value = strtotime($value)) === -1) {
 		 	$message->add("error","Error in resource:format_datetime - The string ($str) is bogus");
		} else {
			
			$value = date('M d, Y g:i a',$value);
		}
    }
		return $value;
	}

	function get_db(){
		return $this->database;	
	}
	
	/**
	*Populates this resource object from an associative array AND PREPARES THE PROPERTIES FOR STORAGE  For example, pass $_POST 
	*/
	function populate_from_array($array){
		//array should be an associative array containing prop names as keys, values to be set as values
		//for example pass $_POST as $array when the form is submitted
		//first, populate from the id - loading values from database
		
		if($id=$array[$this->get_id_string()]){
				$this->load($id);
		}
		
		//then - loop through props -setting the value only IF the value is present
		foreach($this->props as $k => $v){
		
			if(isset($array[$k]) || $array[$k . '_month'] || $v['type'] == 'image'){

				$value = $array[$k];

				$this->set_prop($k,$value);
			}
		}
	}

	
	function populate_from_form_post(){
		
		if($id=$_POST[$this->get_id_string()]){
			//echo "populating"; 
			$this->load($id);
		}	
		
		foreach($_POST as $k => $v){
			//echo " $k :: $v<br />";
			if(array_key_exists($k,$this->props) && $k != $this->get_id_string()){
				if(is_array($v)){
					$list = "";
					foreach($v as $value){
						$list .= "$value,";	
					}	
					$v = preg_replace("/,$/","",$list);
					
				}
				$this->set_prop($k,$v);
				//$this->set_prop($k,$this->prepare_prop_for_storage($k,$v));	
			}	
		}
	}
	
	/**
	*Saves this resource.
	*/
	function save(){
		global $db;
		global $message;
		
		if($this->new == 1){
		
			//if it is new resource, build insert query
			$file = $this->sql_file_name('insert');
			
			$tobj = new template($file);
			foreach($this->get_props_array() as $k => $v){
				
				//add slashes to v
				$v = addslashes($v);
				
				$tobj->parse_key("$k","$v");	
			}	
			$sql = $tobj->parse_key('uid',$_SESSION['uid']);
			$sql = $tobj->get_source();
			
			
			if($sql){
			
				$res =  $db->query($sql);
				$id = $db->insert_id();
				$this->set_prop($this->get_id_string(),$id);
				return $res;		
			}else{
				$message->add("error","empty sql from $file");	
			}
					
		}else{
			
			$file = $this->sql_file_name('update');
			
			//$message->add("","file is |" . $file . "|");
		
			$tobj = new template($file);
			foreach($this->get_props_array() as $k => $v){
				
				//add slashes to v
				$v = addslashes($v);
				
				$tobj->parse_key("$k","$v");	
			}	
			$sql = $tobj->parse_key('uid',$_SESSION['uid']);
			$sql = $tobj->get_source();
	
			if($sql){
			
				
				$res = $db->query($sql);
			}else{
				$message->add("error","empty sql from $file");	
			}
		
		}
		return $res;
		
	}
	
	/**
	*Prepares all props for storage
	*/
	
	function prepare_all_props_for_storage(){
		foreach($this->props as $k => $v){
			$v = $v['value'];
			$this->set_prop($k,$this->prepare_prop_for_storage($k,$v));
		}
	}
	/**
	*Deletes this resource.Returns true on sucess, false on failure
	*/
	function delete(){
		global $db;
		global $message;
			
		$file = $this->sql_file_name('delete');
	
		
		
		$tobj = new template($file);
		$sql = $tobj->parse_key("uid",$_SESSION['uid']);
		
		$sql = $tobj->parse_resource($this); 
		$sql = $tobj->get_source();
		
		if($sql){
			return$db->query($sql);
		}else{
				$message->add("error","empty sql from $file");	
		}
		
	}


	/**
	*Returns the object properties in key-value pairs, web-readable format 
	*/
	function dump_props(){
	
		$out = '<br />';
		foreach($this->props as $k => $v){
			$k = ucwords(str_replace('_',' ',$k));
			$out .= "<b>$k:</b><br />";
			$out .= $v['value'] . "\n<br /><br />";
		}	
		return $out;
	}
	
	/**
	*Takes a string propname, replaces underscores with spaces, and capitalizes the words
	*/
	function friendly_propname($propname){
		
		$propname = str_replace('_',' ',$propname);
		$propname = ucwords($propname);
		return $propname;	
	}
	
	function get_security_groups(){
		$secid = $this->secid;
		if(!$secid){
			return array();	
		}	
		
		$tobj = new template("sql/auth_resource_select_groups.sql");
		$sql = $tobj->parse_key($this->get_id_string(),$secid);
		
		global $dbcache;
		$res = $dbcache->query($sql);
		$rows = $res->fetchallrows();
		
		$groups = array();
		foreach($rows as $row){
				$group = new group();
				$group->populate_from_array($row);
				$groups[] = $group;
		}
		return $groups;
	}
	
	/**
	*Returns number of available resources of this class that match conditions
	*/
	function count($conditions = array()){
		global $dbcache;
		global $message;
		
		$file = $this->sql_file_name("count");
		
		
		$sqlobj = new template("$file");
		$sql = $sqlobj->get_source();
		
		if($sql){
			//take of the order by!!!
			unset($conditions['order_by']);
			
			$sql .=  $this->sql_conditions($conditions);
		
			$res = $dbcache->query($sql);
			$row = $res->fetchrow();
	
		
			return  $row['count(*)'];
		}else{
			$message->add("error","empty sql from $file");	
		}
	}

	/**
	*@param array $conditions
	*@return string SQL conditional query to be placed after the where clause
	*This function takes a special coded associative array and builds an sql conditional statement.
	*The simplest way to use it is pass it raw key values.The keys represent resource object properties
	*the value would be the value that would be added to the where clause. 
	*
	*For example if you pass array('category' => 'Character') it would build an sql query that would 
	*look for all the resources of the $this->resource class that had a property of category with a value of 'Character'.
	*
	*You can also put a special token on to the end of the key to represent an operator such as 
	*less than, more than, equal to, contains, etc.
	*To do that, concatinate |(operator)| to the end of the key
	*for example - if you pass sql_conditions array("id|>=|" => "100")
	*it would return "where id >= 100"   
	*/
	function sql_conditions($conditions){
		global $message;

		$r = $this;
		
		if(!is_array($conditions)){
			$conditions = array();
		}
	
		//echo "in sql_conditions";
		
		$cnt = 0;
		$s = " and" ;
	
		foreach($conditions as $k => $v){
			
			$value = $v;
			//echo " $k :: $v <br />";
			//extract the operator from the key
			preg_match("/\|(.*)\|/",$k,$matches);
			$opr = $matches[1] ? $matches[1] : ' = ';
			
			//echo "opr is $opr <br />";
			
			//remove operator from key
			$k = preg_replace("/\|.*\|/","",$k);
			
			//get fieldname from the resource property name
			$key = $k;

			//check if it is id, get the idstring
			if($key == 'id'){
				$key = $this->get_id_string();
			}
			
			//if value is empty continue to the next iteration of the loop
			if($value=='' && $opr != '!='){
				continue;	
			}
			
			//if the key isn't order_by  or limit
			if($key != 'order_by' && $key != 'limit'){
				
				$field = $this->props[$key]['map'];	
			
				//add it to the query
				if(strstr($opr,'like')){
			
					$s .= " $field $opr '%$value%' and";
				}else if(strstr($opr,'between')){
					$s .= " $field $opr $value and";	
				}else{
					$s .= " $field $opr '$value' and";
				}
				//increment the counter
				$cnt++;
			}		
		}
		
		//remove any and or where clauses
        $s = preg_replace("/and$/","",$s);
      	
        $s = preg_replace("/where$/","",$s);

		//add order by clause
       	$o = $conditions['order_by']? $conditions['order_by'] : $this->get_id_string();
			
       	//set flag
       	$descflag = 0;
		//if there is a descending clause
       	if(strstr($o,' desc')){
       		//clean it out so we can use the fieldname to get the propname
			$o = str_replace(' desc','',$o);
			$o = str_replace(' ','',$o);
			//set descflag
			$descflag = 1;	
		}
			
		//get the fieldname from the propname
		$field = $this->props[$o]['map'];
			
		//add order_by to the sql query
		if($field){
       		$s .= " order by " . $field; 
       		
       		   //if descflag was set, add desc to the sql
        	$s .= $descflag? ' desc' : '';
		}	
      
         	
        //add limit clause 	
        if($l = $conditions['limit']){
            $s .= " limit $l";
        }
		//return the sql query
		return $s;
	}	
	
	
	
}


?>
