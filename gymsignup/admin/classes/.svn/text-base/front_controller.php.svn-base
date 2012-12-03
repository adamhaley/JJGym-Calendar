<?
/**
*The "Controller" in Model-View-Controller.
*
*This class is the first stop in a request.  
*Implements the Front Controller Pattern.
*@package front_controller
*@category ModelViewController
*
*@link http://www.martinfowler.com/eaaCatalog/modelViewController.html
*@link http://www.martinfowler.com/eaaCatalog/frontController.html
*/
class front_controller{
	/**
	*Load {@link command} and invoke {@link command::process()}.
	*if {@link command::process()} returns a value, return that.
	*otherwise get the {@link view} from the {@link command} and return the result of {@link view::build()}
	*@return string
	*/
	function process(){
		$commandname = $this->_get_command_name();
		

		if(class_exists($commandname)){
			eval("\$commandobj = new $commandname;");
			$ret = $commandobj->process();
			if($ret){
				return $ret;
			}
			$view = $commandobj->get_view();
			return $view->build();
		}else{
			return "Command " . $_REQUEST['c'] . " not found.";
		}
	}

	/**
	*Evaluates query string and returns name of the {@link command} to execute.
	*Searches loaded commands and checks for a command named c_[$_GET['c']]_[$_GET['res']] 
	*if not found, returns c_[$_GET['c']]
	*/
	function _get_command_name(){
		$firsttry = 'c_' . $_REQUEST['c'] . '_' . $_REQUEST['res'];
		if(class_exists($firsttry)){
			return $firsttry;
		}
		return 'c_' . $_REQUEST['c'];
	}
}
?>
