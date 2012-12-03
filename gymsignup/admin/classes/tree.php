<?
/**
*This class handles tree recursion functions
*Pass it an associative array with parent ids as values, and child ids as keys.
*/
class tree{
	var $list;
	function tree($list=array()){
		$this->list = $list;
	}
	
	function get_list(){
		return $this->list;	
	}
	
	function set_list($list){
		$this->list = $list;	
	}
	
	/**
	*This function takes a resource object.
	*resource must have a parent property
	*builds the list from the resource id and parent ids
	*optionally pass conditions for a filter
	*/
	function build_from_resource($resource,$conditions=array()){
			
			$rarray = $resource->get_all($conditions);
			foreach($rarray as $robj){
				
				$id= $robj->get_prop('id');
				$parent = $robj->get_prop('parent');
			
				$this->list[$id] = $parent;	
			}
			return;
	}
	
	function get_children($id){
		$children = array();
		foreach($this->list as $child => $parent){
			if($parent==$id){
				$children[] = $child;	
			}	
		}	
		return $children;
	}
	
	function get_parent($id){
		return $this->list[$id];	
	}
	
	function trace_ancestors($id){
		//pass a child id
		//gets ancestors in order of immediate parent first,ascending to tree root 	
		$parents = array();
		while($id=$this->get_parent($id)){
			$parents[] = $id;	
		}
		return $parents;
	}
	
	function get_root_nodes(){
		$nodes = array();
		foreach($this->list as $child => $parent){
			if(!$parent){
				$nodes[] = $child;	
			}
		}	
		return $nodes;
	}
	
	function draw_node($id,$tagflag=0){
		$num = $this->count_ancestors($id);
		for($i=0;$i<$num;$i++){
			$out .= "-";	
		}
	
		$out .= ($tagflag && $id)? "<%" : "";
		
		$out .= $id;
		
		$out .= ($tagflag && $id)? "%>" : "";	
		$out .= $id? "<br />" : "";
		return $out;
	}
	
	function draw_tree($tagflag=0){
		foreach($this->get_root_nodes() as $node){
			//$out .= $this->draw_node($node); 
			$out = $this->call_recursive($node,"\$this->draw_node(\$id,$tagflag)",$out);	
		}	
		return $out;
	}
	
	function call_recursive($id, $function, $out){
		eval("\$out .= $function;");
		if($this->count_children($id)){
			
			$array = $this->get_children($id);
			foreach($array as $id){
				
				$out = $this->call_recursive($id,$function, $out);
			}	
			return $out;
		}else{
			return $out;	
		}
	}
	
	function count_children($id){
		return count($this->get_children($id));	
	}
	
	function count_ancestors($id){
		return count($this->trace_ancestors($id));	
	}
}
?>