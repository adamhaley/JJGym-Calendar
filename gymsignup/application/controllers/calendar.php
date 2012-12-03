<?php defined('SYSPATH') or die('No direct script access.');
/**
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Calendar_Controller extends Template_Controller {
  	// Set the name of the template to use
        public $template = 'kalvan/template';
	
	public function index()
	{
		$this->session = Session::instance();

		if(isset($_POST['password'])){
			$this->login();
			header('Location:' . $_SERVER['SCRIPT_NAME']);
		}
		$user = new User_Model;
		if(isset($_SESSION['uid'])){
			$user->load($_SESSION['uid']);
		}
		//set up calendar
		$month = isset($_GET['month'])? $_GET['month'] : date('n');
		$year = isset($_GET['year'])? $_GET['year'] : date('Y');

		$this->calendar = new Calendar($month,$year);
		
		$event = new Event_Model;		
		$events_array = $event->load_events($month,$year);

		foreach($events_array as $row){
			//print_r($row);			
			$date = $row->date;
		
			$datearray = explode('-',$date);
			$year = $datearray[0];
			$month = $datearray[1];
			$day = $datearray[2];

			$time = $row->time;
			$time_end = $row->time_end;		
			$usage = $row->usage;
			$comments = $row->comments;
			
			$name = $row->name_first . " " . $row->name_last;

			$code = " <b>$name</b> ($usage%)<br />";
			$code .= $time . " - " . $time_end;
			$now = gmmktime(0,0,0,date('n'),date('d'),date('Y'));
			$compdate = gmmktime(0,0,0,$month,$day,$year);
			//echo gmmktime(0,0,0,date('n'),date('d'),date('Y')) . " comp to " . strtotime("$month-$day-$year") . " <br />";
			if(isset($_SESSION['uid']) && $row->user_id == $_SESSION['uid'] && $now <=$compdate){
                                $code .= " [<a href='#' onClick='delete_event(" . $row->id . ")' class='delete'>x</a>] ";
                        }
			$code .= "<br /><div class='duration'>" . $comments . "</div>";

			$this->add_to_calendar($code,$month,$day,$year);
		}


		$cal = $this->calendar->render(TRUE);
		

		$this->template->content = new View('calendar');
		$this->template->user = $user;	
	
		$ann = new Announcements_Model;
		$row = $ann->get()->as_array();
		$content = $row[0]->announcement;

		$this->template->content->announcements = $content;
		//$this->template->title = 'The Kalvan\'s Calendar';
		$this->template->content->cal = $cal;
		/*
		$view = new View('calendar');
		$view->render(TRUE);
		*/
	}

	public function add_to_calendar($code,$month,$day,$year)
	{
		 $this->calendar->attach($this->calendar -> event() -> condition('year', $year) -> condition('month', $month) -> condition('day', $day)  -> output($code));
		
	}

	public function login()
	{
		//$username = $this->input->post('username');
		$password  = $this->input->post('password');

		$user = new User_Model;
		if($user->is_authentic($password)){
			$_SESSION['uid'] = $user->id;
			return $user;
		}
	}

	public function book_time()
	{
	       $data = array();
	       if($id = $this->uri->segment(3)){
			$event = new Event_Model;
			$data = $event->get_event($id)->result_array();
		}
               $this->session = Session::instance();
		
		$this->template->content = new View('book_time');
		if(count($data)){
			$this->template->content->event = $data[0];
		}
		if(isset($_SESSION['uid'])){
 			$user = new User_Model;
                       $user->load($_SESSION['uid']);
                	$this->template->user = $user;

		}

		 //set up calendar
                $month = isset($_GET['month'])? $_GET['month'] : date('n');
                $year = isset($_GET['year'])? $_GET['year'] : date('Y');

                $this->calendar = new Calendar($month,$year);

                $cal = $this->calendar->render(TRUE);
		$this->template->content->cal = $cal;
	}

	public function book_time_process()
	{
	 	$this->session = Session::instance();

		if(isset($_SESSION['uid'])){

			$user = new User_Model;
                 	$user->load($_SESSION['uid']);
                        $this->template->user = $user;

                }

		$month = $this->input->post('date_month'); 
		$day = $this->input->post('date_day');
		$year = $this->input->post('date_year');
	//	$year = date("Y");

		$date = $year . "-" . $month . "-" . $day;
		echo $date;
		$data['date'] = $date;
		$data['user_id'] = $_SESSION['uid'];

			

		//$hour = ($this->input->post('ampm') == 'pm')? $this->input->post('start_hour') + 12 : $this->input->post('start_hour');


		$data['time_start'] = $this->input->post('time_start')==''? '00:00' : $this->input->post('time_start');
		$data['time_end'] = $this->input->post('time_end')==''? '00:00' : $this->input->post('time_end')  ;
		$data['usage'] = $this->input->post('usage');
		$data['comments'] = ($this->input->post('comments') == '')? '' : $this->input->post('comments');
	
		//get total max booked percentage for current time slot
		//get events where end time is less than current end time and greater than current start time
		//get events where start time is 


		$event = new Event_Model;
		$event->insert_event($data);
	

		//repeat weekly if selected
		if($this->input->post('repeat')=='on'){
			$enddate = $this->input->post('repeat_until_year') . "-" . $this->input->post('repeat_until_month') . "-" . $this->input->post('repeat_until_day');
			$time = strtotime($enddate);
			$thistime = strtotime($data['date']);
			//echo "enddate is $enddate endtime is $time<br />";
			while($thistime <= $time){
				//add a week
				$thistime += 604800;
				$thisdate = date("Y-m-d",$thistime + 7200);
				$data['date'] = $thisdate;

				$event->insert_event($data);
				//echo "thistime is $thistime. <br /><br />";
			}
		}

	 	$this->template->content = new View('book_time_process');
		$this->template->content->user = $user;
		$this->template->content->date = $date;
		$this->template->content->time = $this->input->post('time_start');
		$this->template->content->usage = $data['usage'];
	}

	public function delete_event(){
		$id = $this->input->get('id');
		
		$event = new Event_Model;
		$event->delete_event($id);
	}

	public function __call($method, $arguments)
	{
		// Disable auto-rendering
		$this->auto_render = FALSE;

		// By defining a __call method, all pages routed to this controller
		// that result in 404 errors will be handled by this method, instead of
		// being displayed as "Page Not Found" errors.
		echo 'This text is generated by __call. If you expected the index page, you need to use: welcome/index/'.substr(Router::$current_uri, 8);
	}

} // End Welcome Controller
