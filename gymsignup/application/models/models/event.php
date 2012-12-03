<?php defined('SYSPATH') or die('No direct script access.');
 
class Event_Model extends Model {
 
	public function __construct()
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct();
	}
 		
	public function get_event($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('events');
	}
 
	public function load_events($month,$year)
	{
		$nextyear = ($month == 12)? $year +1 : $year;
		$nextmonth = ($month == 12)? 1 : $month +1;

		$sql = "SELECT TIME_FORMAT(events.time_start,'%l:%i %p') as time,TIME_FORMAT(events.time_end,'%l:%i %p') as time_end, events.id, events.user_id, events.date,events.time_start, users.name_first, users.name_last, events.usage, events.comments FROM events,users where events.date >= '$year-$month-1' and events.date < '$nextyear-$nextmonth-1' and events.user_id = users.id order by events.time_start + 0";
		//echo($sql);

	    	$result = $this->db->query($sql);

		return $result;
	}
	
	public function insert_event($data)
	{
		$this->db->insert('events', $data);
	}
 
	public function delete_event($id)
	{
		 $this->db->where('id', $id);
		$this->db->delete('events');
	}
}
