<?
/**
*@package template
*/
/**
*@package template
*This class represents a text based template
*It is meant mainly for html templates, but can be used for any text file that you need to
*re-use over & over again with certain content elements replaced out from instance to instance 
*/
class template{
	/**
	*Pass the path to the html template file
	*Constructor. 
	*@param string $filename
	*/
	var $file;
	var $source;
	function template($filename=''){
			

			
			$this->file = $filename;
			$this->source = $this->read();
	}
	
	/**
	*Read the html file
	*Sets this->source to the contents of the file
	*Also returns the contents of the file as a string
	*@return string contents of the file passed to the constructor or false on failure
	*/
	function read(){
			global $path;
			global $message;
			$file = $path . $this->file;
			//open the file
			$fh = fopen($file,'r');
			//if file handle exists
			if($fh){
				//read the file
				$source = fread($fh,filesize($file));
				//set the source
				$this->source = $source;
				//return it
				return $this->source;	
			//else if file could not be opened
			}else{
				$message->add("error","did not find $file");
				//return false
				return false;
			}	
	}
	
	/**
	*Parse key value pairs from array.
	*Replaces <%$key%> in html source with value from array[$key]
	*@param array $array
	*@return string Contents of file passed to constructor with special tags replaced
	*/
	function parse_key_values($array = array()){
			//get the source
			$source = $this->source;
			//loop through array
			foreach($array as $k => $v){
				//replace special key
				$source = str_replace("<%$k%>",$v,$source);	
			}
			//set the source
			$this->source = $source;
			//return the source
			return $this->source;	
	}
	/**
	*Parse key values with property values from given resource object
	*@param object $robj
	*@return Contents of file passed to constructor with special tags replaced with values of
	*$robj properties that correspond to each respective tag
	*/
	function parse_resource($robj){
			//get source
			$source = $this->source ? $this->source : $this->read();
			//get resource object properties
			$array = $robj->get_props_array();
			
			
			//for each property
			foreach($array as $k => $v){
				//replace value with "get_type_value" - which then calls type::get_value_for_web() for formatting purposes
				
				//$v = $robj->prepare_prop_for_display($k);
				//replace special tag
				$source = str_replace("<%$k%>",$v,$source);	
			}
			//set the source 
			$this->source = $source;
			//return the source
			return $this->source;	
	}
	
	
	/**
	*@param string $key, string $value
	*@return  Contents of file passed to constructor with special tag <%$key%>  replaced with $value	*This function replaces one key
	*/
	function parse_key($key,$value){
		//get the source
		$source = $this->source;
		//replace key with value
		$source = str_replace("<%$key%>",$value,$source);
		//set the source
		$this->source = $source;
		//return the source
		return $this->source;	
	}
	
	/**
	*@param string $path 
	*This function sets the path to the template file. Call this if you want to replace the file for this object with another one.
	*/
	function set_file($filename){
		global $path;
		$this->file = $filename;	
	}
	
	/**
	*@return string Contents of file with all special tags cleaned out. 
	*/
	function get_source(){
		$source = preg_replace("/<%.*?%>/","",$this->source);
		return $source;	
	}
}
?>
