<?

class c_admin_home extends command{
}	
	
class c_admin_save extends command{
function process(){
    global $message;
    if(is_object($this->robj)){
      $robj = $this->robj;
    }else if(class_exists($_REQUEST['res'])){
      eval("\$robj = new " . $_REQUEST['res'] .";");
    }else{
      $message->add('error','No Resource passed to command c_save');
      return $this->build_view();
    }

    if($_REQUEST['id']){
                        $robj->load($_REQUEST['id']);
                }

                $robj->populate_from_form_post();
                $robj->save();

    $command = new c_admin_browse();
    $_REQUEST['res'] = $_REQUEST['res'] ? $_REQUEST['res'] : get_class($robj);
                return $command->process();
  }
}

class c_admin_browse extends command{
function process(){
    global $message;
    //trick the _REQUEST into knowing it is browse in case this is being called
    // from c_delete or c_save
    $_REQUEST['c'] = 'admin_browse';

    $res = $_REQUEST['res'] ? $_REQUEST['res'] : 'story';
    eval("\$robj = new $res;");

                //pull in conditions
                $conditions = $_SESSION['conditions']? $_SESSION['conditions'] : array();

                $_SESSION['conditions'] = $conditions;

                 //count total records
                $total = 0;

    $conditions['order_by'] = $_REQUEST['order_by']? $_REQUEST['order_by'] : $robj->get_table() . "." . $robj->get_id_string();

                $total = $robj->count($conditions);

    $this->perpage = $this->perpage? $this->perpage : 20;
                if($this->pageresults){
                        //build limit clause
                        $pp = $this->perpage;
       $this->auxarray['perpage'] = $pp;

                  $cp = $_GET['page'] ? $_GET['page'] - 1 : 0;
                  $start = $cp * $pp;
                  $clause = "$start,$pp";

                  $conditions['limit'] = $clause;
                }

                $rarray = $robj->get_all($conditions);

                $this->rarray = $rarray;
                $this->auxarray['totalcount'] = $total;

                return $this->build_view();
  }

}

class c_admin_edit extends command{
 function process(){
    global $message;

                $id = $_REQUEST['id'];
                $res = $_REQUEST['res'];
                if(!class_exists($res)){
                        $message->add("error","Need Resource Class Name to edit");
                        return $this->build_view();
                }
    //if we are still running, procees assuming $id and $res are valid

                eval("\$robj = new $res;");
    if($id){
      $robj->load($id);
    }
    $this->set_resource_array(array($robj));

    return $this->build_view();
  }

}




class c_admin_search extends command{
	function process(){
		
		$factory = new resource_factory();
		
		//get resource w/ this id
		$res = $factory->get_resource($_GET['res']);
		
		
	
		$this->rarray = array_merge(array($res),$res->get_foreign_resources());

		
		return $this->build_view();
	}
}

class c_admin_view extends command{
	function process(){		
		$factory = new resource_factory();
		
		//get resource w/ this id
		$this->rarray =  $factory->get_all($_REQUEST['res'],array('id' => $_REQUEST['id']));


		
		return $this->build_view();
	}	
}

class c_admin_create extends command{
	function process(){
		$factory = new resource_factory();
		$rarray = array($factory->get_resource($_GET['res']));
		
		$res = $rarray[0];
		$this->rarray = array_merge($rarray,$res->get_foreign_resources());

		$this->set_stylesheet('admin_edit.xsl');
		
		return $this->build_view();
	}	
}

class c_admin_delete extends command{
	function process(){
		global $message;
		$factory = new resource_factory();	
		$robj = $factory->get_by_id($_GET['res'],$_GET['id']);
		
		$id = $robj->get_prop('id');
		if(is_object($robj)){
			$robj->delete();
			
			if(!$message->num_errors()){
				$message->add("confirmation",ucfirst(get_class($robj)) . " $id Deleted.");	
			}
		}
		
		$browse = new c_admin_browse();
		return $browse->process();
	}	
}

?>
