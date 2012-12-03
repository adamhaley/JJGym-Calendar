<?
class access_control{
	function __construct(){
		$this->uid = $_SESSION['uid']? $_SESSION['uid'] : $_GET['uid'];
		$employee = new employee;
		$employee->load($this->uid);
		$this->employee = $employee;
	}
	function get_groups(){
		$emp = $this->employee;
        	//get all groups current employee belongs to    
        	$relobj = new ac_employee_group;
        	$rel_array = $relobj->get_all(array('id_employee' => $this->uid));
        	$groups = array();
        	foreach($rel_array as $rel){
                	$group = new ac_group;
                	$group->load($rel->get_prop('id_ac_group'));
                	$groups[] = $group;
        	}
		return $groups;
	}
	function get_available_modules(){
		global $message;
		$module = new auth_module;
		$module_array = $module->get_all();
		$return = array();
		foreach($module_array as $module){
			$access = $this->get_module_permissions($module);
			
			//$message->add('info',"access is $access");
			//echo "access is $access to module " . $module->get_prop('id_auth_module') . " <br />";
			if($access > 0){
				$return[] = $module;
			}
		}
		return $return;
	}
	function get_module_permissions($moduleobj){
		$access = 0;
		$groups = $this->get_groups();
		foreach($groups as $group){
                	$module_group = new ac_module_group;
                	$module_group = $module_group->find(array('id_ac_group' => $group->get_prop('id_ac_group'),'id_auth_module' => $moduleobj->get_prop('id_auth_module')));
                	if(is_object($module_group)){
                        	if($module_group->get_prop('access_level') > $access){
                                	$access = $module_group->get_prop('access_level');
                        	}
                	}
        	}
		return $access;
	}
	function get_available_productions(){
		
	}
	function translate_access_level($access){
	       switch($access){
               		case(0):
                      		$ea = 'None';
                      		break;
               		case(1):
                      		$ea = 'Read-Only';
                      		break;
               		case(2):
                      		$ea = 'Read-Write';
                      		break;
               		case (3): 
                        	$ea = 'Super-User';
                	        break;
        	}
		return $ea;
	}
}
?>
