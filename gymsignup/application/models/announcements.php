<?php defined('SYSPATH') or die('No direct script access.');
 
class Announcements_Model extends Model {
 
	public function __construct()
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct();
	}
 		
	public function get()
	{
		$this->db->where('id', '1');
		return $this->db->get('announcements');
	}
 
	
	public function update($data)
	{
		$this->db->where('id','1');
		$this->db->update('announcements', $data);
	}
 
}
