<?php
# application/classes/controller/api/users.php

class Api_Controller extends Template_Controller {

	public $template = 'kalvan/api';
    static $table_name = 'events';
     
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

     	$event = new Event_Model;		
		$events = $event->load_events($month,$year);

		$array = array();
		foreach($events as $event){
			$array[] = $event;
		}

		$this->template->content = json_encode($array);
    }
    function get_events_by_date()
  	{
     	$date = date("Y-m-d");
     	// print_r($date);
     	$event = new Event_Model;		
		$events = $event->load_events_by_date($date);
		$array = array();
		foreach($events as $event){
			$array[] = $event;
		}

		$this->template->content = json_encode($array);

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