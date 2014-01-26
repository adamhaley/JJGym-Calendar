<?php
# application/classes/controller/api/users.php

class Users_Controller extends Api_Controller {

	public $template = 'kalvan/api';
    static $table_name = 'users';
    /**
     * @see http://kohanaframework.org/3.2/guide/kohana/security/validation
     * @see http://kohanaframework.org/3.2/guide/api/Validation
     *
     * @var array
     */
   
    function index()
  	{

  		$month = isset($_GET['month'])? $_GET['month'] : date('n');
		$year = isset($_GET['year'])? $_GET['year'] : date('Y');

     	$user = new User_Model;		
		$users = $user->load($month,$year);

		$array = array();
		foreach($users as $user){
			$array[] = $user;
		}

		$this->template->content = json_encode($array);
    }
    function get()
  	{
        
    }
    function put()
    {

    }
    function post()
    {
        if( ! $this->post_validate($this->request->post()))
        {
            $this->validation_error_response();
        }
        else
        {
            return $this->fulfill_post_request();
        }
    }
}