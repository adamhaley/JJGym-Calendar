<?
/**
*Auto generate sql for inserting, updating,deleting,selecting primary data for a resource object
*/
class sql_generator{

	var $robj;

	function sql_generator($robj = ''){
		if($robj){
			$this->resource = $robj;
		}
	}
	
	function get_sql($which){
		$sql = '';
		if(method_exists($this,$which)){
			eval("\$sql =  \$this->$which();");
		}	
		return $sql;
	}

	function set_resource($robj){
		$this->resource = $robj;
	}
	
	function select(){
		$robj = $this->resource;
		
		$sql = "select ";
		foreach($robj->props as $k => $v){
			$sql .= $v['map'] . ', ';
		}

		$sql = preg_replace("/, $/","",$sql);
		
		$sql .= " from ";
		$sql .= $robj->table;	
		
		$sql .= " where " . $robj->table . ".flag_rec_status='1'";
		
		
		return $sql;		
	}

	function update(){
		//build update sql
		//build update sql
		//echo "in update query ";
		$robj = $this->resource;

		$sql = "update "; 
		$sql .= $robj->table;
		$sql .= " set ";
		foreach($robj->props as $k => $v){
			$field = $v['map'];
			//use type class to get value
				
			$value = $v['value'];
				
			//add to query
			if(!strstr($field,$robj->get_id_string())){
				$sql .= " $field = '$value',";
			}
		}
			
		$sql = preg_replace("/,$/","",$sql);
		
		return $sql;
	}

	function insert(){
			$robj = $this->resource;
			$sql = 'insert into ' . $robj->table . '(';
		
			foreach($robj->props as $k => $v){
				if($k != $robj->get_id_string()){	
					$sql .= $v['map'] . ",";
				}
			}		
	
			$sql = preg_replace("/,$/","",$sql);
			$sql .= ")
			values
			(";
			
			foreach($robj->props as $k => $v){
				$sql .= " '" . $v['value'] . "',";
			}

			$sql = preg_replace("/,$/","",$sql);
			$sql .= ")";
			return $sql;
	}

	function count(){
		$robj = $this->resource;
		$sql = "select count(*) from " . $robj->table;
		return $sql;
	}

	function delete(){
		$robj = $this->resource;
		$sql = "update " . $robj->table .  " set  flag_rec_status='0' ";	
		return $sql;
	}
}
?>
