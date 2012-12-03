<?
class resource_factory{

	function get_resource($name){

		if(class_exists($name)){
			eval("\$obj = new $name;");
		
			return $obj;
		}
		
	}
	
	function count($name,$conditions=array()){
		$array = array();
		$resource = $this->get_resource($name);
		if(is_object($resource)){
			$total =  $resource->count($conditions);
		}

		
		return $total;
	}
	
	function get_all($name,$conditions=array()){
		
		$array = array();
		$resource = $this->get_resource($name);
		if(is_object($resource)){
			$array =  $resource->get_all($conditions);
		}
		return $array;
	}

	function get_by_id($name,$id){
		$resource = $this->get_resource($name);
		
		
		
		if(is_object($resource)){
		
			
			$array = $resource->get_all(array('id' => $id));
		
			if(count($array)){
				
				
				return $array[0];
				
				
			}else{
				
				return $resource;
			}
		}
	}
}
?>
