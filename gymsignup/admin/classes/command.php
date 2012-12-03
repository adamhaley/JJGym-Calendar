<?
//abstract command class
class command{	
    var $stylesheet;
	var $view;
	var $rarray = array();
	var $auxarray = array();
	var $pageresults = 1;
	
	function process(){
		return $this->build_view();
	}
	
  	function set_resource_array($rarray){
    		$this->rarray = $rarray;
  	}

	function build_view(){
			$this->view = new view();			

			//get the stylesheet name from request
			$path = 'xsl/';
		
			$name = str_replace('c_','',get_class($this)) . '.xsl';
			if(file_exists($path . $name)){
				$this->set_stylesheet($name);
			}else{
				$this->set_stylesheet('home.xsl');	
			}
		
			$view = is_object($this->view)? $this->view : new view($this->rarray);
			$view->set_stylesheet($this->stylesheet);
			
			/*
			$page = new page();
			$pagearray = $page->get_all();
			*/
			
			//$this->rarray = array_merge($pagearray,$this->rarray);
			//$this->rarray = array_merge($this->rarray,$page->get_foreign_resources());
			$this->auxarray['pageresults'] = $this->pageresults;
			return $view->build($this->rarray,$this->auxarray); 
	}
	
	function set_stylesheet($path,$force=0){
		if($force || !$this->stylesheet){
			$this->stylesheet = $path;	
		}
	}
}

?>
