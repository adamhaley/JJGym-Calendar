<?php

/**
*@package user.php
*Class Schema is a child class of Resource.
*Represents a schema
*
*BLA BL ABLA BLA BLA BLA
*/
/**
*@package user
*
*/
class user extends resource{
	/**
	*Constructor
	*/
 	var $new = 1;
	var $table = 'user'; 

	
	function user(){
		
		//object props array
		$this->props=array(
			'user_id' =>  array('value' => '',
							'datatype' => 'id',
							'view' => '1',
							'edit' => '1',
							'map' => 'user.user_id'
							),
							
			'first_name' => array('value' => '',
							'datatype' => 'text',
							'view' => '1',
							'edit' => '1',
							'map' => 'user.first_name'
							
								),
			'last_name' => array(
							'value' => '',
							'datatype' => 'text',
							'view' => '1',
							'edit' => '1',
							'map' => 'user.last_name'
							),
			'email' => array(
							'value' => '',
							'datatype' => 'text',
							'map' => 'user.email',
							'view' => '0',
							'edit' => '1'
			),
			'username' => array(
						
							'datatype' => 'text',
							'map' => 'user.username',
							'view' => '0',
							'edit' => '1'
							),
			'password' => array(
					
							'datatype' => 'text',
							'view' => '0',
							'edit' => '1',
							'map' => 'user.password'
							),
			'last_login' => array(
							'datatype' => 'datetime',
							'view' => '1',
							'edit' => '0',
							'map' => 'user.last_login'
							)			
			
			);
	}


	
	
	function is_authentic($username,$password){
		$sqlobj = new template("sql/user_authenticate.sql");
		$sqlobj->parse_key("username",$username);
		$sqlobj->parse_key("password",$password);
		$sql = $sqlobj->get_source();		
		
		
		global $dbcache;
		
		$res = $dbcache->query($sql);
		
		$emprow = $res->fetchrow();
		if(is_array($emprow)){
			return $emprow['user_id'];	
		}else{
			return 0;	
		}
	}
	

	/**
	*Saves  to the database
	*/
	function save(){
		global $db;
		global $message;
			//echo "IN SAVE <br />"; 
		if($this->new){
			//if it is new resource, build insert query
			//insert into employee table
			if($this->get_prop('password' == '')){
				$this->set_prop('password',$this->generate_password());
			}
			//if it is new resource, build insert query
			$file = $this->sql_file_name('insert');
			
		
				$tobj = new template($file);
				foreach($this->get_props_array() as $k => $v){
					//echo " $k :: $v <br />";
					$tobj->parse_key("$k","$v");	
				}			
				$sql = $tobj->parse_key('uid',$_SESSION['uid']);
				
			if($sql){
				$result = $db->query($sql);
				$this->set_prop('id',$db->insert_id());
			}else{
				$message->add("error","empty sql from $file");	
			}
			//echo "this is new \n";
		}else{
			
			$file = $this->sql_file_name('update');
			
			$tobj = new template($file);
			foreach($this->get_props_array() as $k => $v){
				//echo $k . " : " . $v . " <br />";
				$tobj->parse_key("$k","$v");	
			}	
			$sql = $tobj->parse_key('uid',$_SESSION['uid']);
			
			
			
			//echo " file is $file, sql is $sql <br />";
			if($sql){
				$res = $db->query($sql);
				//$tobj = new template('sql/user_update_user_profile.sql');
				//echo $tobj->source;
				
			}else{
				$message->add("error","empty sql from $file");	
			}
			
		}
		return $res;
	}

	/**
	*Returns an associative array of id's and the first property in the prop array of all  resources of this class
	*OVERRIDING TO GET FIRST NAMES AND LAST NAMES OF EMPLOYEES
	*/
	function get_all_assoc(){
		$props = $this->props;
		
		
		
		$conditions = array('order_by' => 'last_name');
		
		$array = $this->get_all($conditions);
		$returnarray = array();
		foreach($array as $obj){
			$props = $obj->props;
			
			$returnarray[$obj->get_prop('id')] = $obj->get_prop('last_name') . ',' . $obj->get_prop('first_name');
		}
		return $returnarray;
	}
	
	/**
	*Populates the employee object from given email address
	*/
	function populate_from_username($email){
		global $db;
		
		$sql = $this->build_select_query();
		$sql .= " and username='$email'";	
		//echo "QUERY IS $sql \n<br />";
		$res = $db->query($sql);
		$row = $db->fetchrow();
		//echo "id is " . $row['id'];
		$this->populate($row['id']);
		
	}
	
	function generate_password(){
	   /* Generate a random password. Alternates vowels and
	   consonants, for maximum pronounceability.  Uses its own 
	   list of consonants which exclude F and C and K to prevent 
	   generating obscene-sounding passwords. Capital I and 
	   lowercase L are excluded on the basis of looking like 
	   each other.
		*/

       $length = 8;            // make it at least 6 chars long.
        $numbers = "12345678";
       $vowels = "aeiouy";
       $consonants = "bdghjmnpqrstvwxz";
        
       $s = "";
       $newchar = "";
       
       $alt = 0;
       for($i=0;$i<$length;$i++){
       			
       			if($i==$length-1){
       					$newchar = substr($numbers,rand(0,strlen($numbers)-1),1); 
       			}else if ($alt) {
                        $newchar = substr($vowels,rand(0,strlen($vowels)-1),1);
                } else {
                        $newchar = substr($consonants, rand(0,strlen($consonants)-1),1);
                }
                if($i==0){
                	$newchar = strtoupper($newchar);	
                }
                $s .= $newchar;
                $alt = $alt? 0 : 1;
                //echo "I is $i newchar is $newchar <br />";
        }
		return $s;
	}
}

?>
