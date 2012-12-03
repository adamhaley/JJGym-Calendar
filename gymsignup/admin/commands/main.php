<?
class c_home extends command{
	function process(){
		global $message;	
	
		$robj = new story;
		$this->auxarray['totalcount'] = $robj->count();
		
		$conditions = array();
                //build limit clause
                $pp = 5;
		$this->auxarray['perpage'] = $pp;		

 	        $cp = $_GET['page'] ? $_GET['page'] - 1 : 0;
                $start = $cp * $pp;
            	$clause = "$start,$pp";

               	$conditions['limit'] = $clause;
		$conditions['order_by'] = 'time_posted desc';
		
		$rarray = $robj->get_all($conditions);
	
		//get story photos
		$imagearray = array();
		$photo = new story_photo;
		foreach($rarray as $robj){
			$imagearray = array_merge($imagearray,$photo->get_all(array('story_id' => $robj->get_prop('story_id'))));
		}
		
		
		if($_SESSION['uid']){
			$user = new user();
			$user->load($_SESSION['uid']);		
		}
		$rarray = array_merge($robj->get_all($conditions),array($user));
		$this->rarray = array_merge($rarray,$imagearray);

		return $this->build_view();
	}
}



class c_login extends command{
}

class c_login_authenticate extends command{
        function process(){
                global $message;
                $emp = new user();

                if($uid = $emp->is_authentic($_REQUEST['username'],$_REQUEST['password'])){
                        $_SESSION['uid'] = $uid;
                        $_GET['res'] = 'user';
                        $emp->load($uid);

                        //clear out REQUEST
                        $_REQUEST = array();
                        $command = new c_home();

                        return $command->process();
                }else{
                        $message->add("error","Login Failed");
                        $command = new c_login();
                        return $command->process();
                }
        }
}

class c_logout extends command{
        function process(){
                session_unset('uid');
		global $message;

		$message->add("confirmation","You have logged out.");

                $command = new c_home();
                return $command->process();
        }
}

class c_register_step_1 extends command{

}

class c_register_step_2 extends command{

}

class c_register_step_3 extends command{

}

class c_manage_stories extends command{
	function process(){
		global $message;
		if(!$_SESSION['uid']){
			$message->add("error","No UID in c_manage_stories. User not logged in.");
		}
		$robj = new story;
		$rarray = $robj->get_all(array('user_id' => $_SESSION['uid'],'order_by' => 'time_posted desc'));
		
		//get story photos
		$imagearray = array();
		$photo = new story_photo;
		foreach($rarray as $robj){
			$imagearray = array_merge($imagearray,$photo->get_all(array('story_id' => $robj->get_prop('story_id'))));
		}
		
		$rarray = array_merge($imagearray,$rarray);
		$this->set_resource_array($rarray);
		
		return $this->build_view();
	}
}

class c_view_story extends command{
	function process(){
		$id = $_REQUEST['id'] ? $_REQUEST['id'] : 1;
		$res = new story;
		$res->load($id);
		
		$image = new story_photo;
		$imagearray = $image->get_all(array('story_id' => $id,'order_by' => 'time_posted'));

		if(is_object($imagearray[0])){
			if(!$_REQUEST['imageid']){
				$_REQUEST['imageid'] = $imagearray[0]->get_prop('id');
			}
			
		}
		$this->auxarray['numimages'] = count($imagearray);
		
    //merge images
		$rarray = array_merge($imagearray,array($res));

		//get comments
    $comment = new comment;
	  $carray = $comment->get_all(array('story_id' => $id)); 

    //get users associated to comments
    $uarray = array();
    foreach($carray as $cobj){
      //if(!in_array($cobj,$carray)){
        $uarray[] = $cobj->get_associated_user();
      //}
    }

    //merge comment objects
		$rarray = array_merge($rarray,$carray);
		//merge user objects
    $rarray = array_merge($rarray,$uarray);

    //get user who posted the story
		$user = new user;
		$user->load($res->get_prop('user_id'));
		$rarray = array_merge($rarray,array($user));		

		$this->rarray = $rarray;
		return $this->build_view();
	}
}

class c_view_user extends command{
  function process(){
    $robj = new user;
    $robj->load($_REQUEST['user_id']);

    $this->set_resource_array(array($robj));
    return $this->build_view();
  }
}

class c_search_results extends command{
  function process(){
    $robj = new story();
    //run search query
  }
}

class c_submit_story extends command{
	 function process(){
                $id = $_REQUEST['id'];
                $robj = new story;

        	//if the id is passed, load it from the db 
	       if($id){
                        $robj->load($id);

 	               $this->rarray = array($robj);
        	}	
	        return $this->build_view();
        }
}

class c_submit_story_step_2 extends command{
	function process(){
		$id = $_REQUEST['id'] ? $_REQUEST['id'] : '';
		$robj = new story;
		//if the id is passed, load it from the db
		if($id){
			$robj->load($id);
		}
		//save it, buddy
		$robj->populate_from_array($_POST);
		$robj->set_prop('user_id',$_SESSION['uid']);
		$robj->save();
	
		$this->rarray = array($robj);
		return $this->build_view();
	}
}

class c_submit_story_step_3 extends command{
	function process(){
		global $buildpath;
		global $message;

		$robj = new story_photo;
		if($id = $_REQUEST['deleteimage']){
			$robj->load($id);
			$robj->delete();
		}		

		if($_FILES['image']['name'] && $_FILES['image']['type'] == 'image/jpeg' && file_exists($_FILES['image']['tmp_name'])){
			$tmpfile = $_FILES['image']['tmp_name'];
			$robj->set_prop("filename",$_FILES['image']['name']);

			$destpath =  "images/" . $_FILES['image']['name'];
	
			copy($tmpfile,$destpath);

			$robj->create_resized($_FILES['image']['name'], "images/");
			$robj->create_thumb($_FILES['image']['name'],"images/");
			$robj->set_prop("story_id",$_REQUEST['id']);
			$robj->set_prop("user_id",$_SESSION['uid']);
			$robj->save();
		}
		$rarray = $robj->get_all(array('story_id' => $_REQUEST['id']));

		$this->rarray = $rarray;
		return $this->build_view();
	}
}

class c_edit_photo extends command{
	function process(){
		$robj = new story_photo;
                $robj->load($_REQUEST['id']);

		if($_POST){
			$robj->set_prop('caption',$_POST['caption']);
			$robj->set_prop('description',$_POST['description']);
			$robj->save();
		}
		$this->rarray = array($robj);
		return $this->build_view();
	}
}

class c_submit_story_step_4 extends command{

}

class c_slideshow extends command{
	function process(){
		$robj = new story_photo;
		$this->set_resource_array($robj->get_all(array('story_id' => $_REQUEST['id'],'order_by' => 'time_posted')));
		return $this->build_view();
	}
}

class c_about extends command{

}

class c_contact extends command{

}

class c_store extends command{

}

class c_signup extends command{

}

class c_signup_step_2 extends command{
	function process(){
		global $message;

		$robj = new user;

		$err = 0;

		if($_POST['password'] != $_POST['password2'])
        $robj->set_prop('story_id',$_REQUEST['story_id']);{
			$message->add('error',"Passwords do not match. Please re-enter.");
			$err = 1;
		}
		
		foreach($_POST as $key => $value){
			if($key != 'c' && $key != 'password2'){
				if($value == ''){
					$err = 1;
					$message->add('error',"Please enter your " . ucwords(str_replace('_',' ',$key)) . ".");
				}				
			}
		}

		if(count($robj->get_all(array('username' => $_POST['username'])))){
			$err = 1;
			$message->add('error',"Username " . $_POST['username'] . " already exists. please choose a different one.");
		}
	

		if($err){
			$command = new c_signup();
			return $command->process();
		}else{
			$robj->populate_from_form_post();
			$robj->save();

			return $this->build_view();
		}

	}
}

class c_save extends command{                   
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
    /*
    return $this->build_view();
    */
  }
}

class c_add_comment extends command{
  function process(){
    $story_id = $_REQUEST['story_id'];
    $robj = new story;
    $robj->load($story_id);
    $this->set_resource_array(array($robj));
    return $this->build_view();
  }
}

class c_add_comment_save extends command{
  function process(){
    $story_id = $_REQUEST['story_id'];
    $parent_id = $_REQEUEST['parent_id'];

    $robj = new comment;
    $robj->set_prop('comment_parent_id',$parent_id);
    $robj->set_prop('story_id',$story_id);
    $robj->set_prop('user_id',$_SESSION['uid']);
    $robj->set_prop('body',$_REQUEST['body']);
    
    $robj->save();

    $story = new story;
    $story->load($story_id);
    $this->set_resource_array(array($robj,$story));

    $_REQUEST['id'] = $story_id;

    $command = new c_view_story();
    return $command->process();
  }
}

class c_reply_comment extends command{
  function process(){
    $cid = $_REQUEST['comment_parent_id'];
    $robj = new comment;
    $robj->load($cid);
    
    $user = new user;
    $user->load($robj->get_prop('user_id'));
    
    $story = new story;
    $story->load($_REQUEST['story_id']);
    
    $this->set_resource_array(array($robj,$user,$story));

    return $this->build_view();
  }
}

class c_reply_comment_save extends command{
  function process(){
    $robj = new comment;
    $robj->set_prop('comment_parent_id',$_REQUEST['comment_parent_id']);
    $robj->set_prop('body',$_REQUEST['body']);

    $robj->set_prop('story_id',$_REQUEST['story_id']);
    $robj->set_prop('user_id',$_SESSION['uid']);
    $robj->save();

   //get parent comment
   $pobj = new comment;
   $pobj->load($_REQUEST['comment_parent_id']);
   $story_id = $_REQUEST['story_id'];
  
  return $this->build_view();
 }
}


class c_view_thread extends command{

}
?>
