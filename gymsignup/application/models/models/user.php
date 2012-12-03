<?php defined('SYSPATH') or die('No direct script access.');
 
class User_Model extends Model {
 
	var $id;
	var $name_first;
	var $name_last;
	var $username;
	var $password;
	var $email;
	var $phone;
	var $date_last_login;
	var $date_registered;


	public function __construct()
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct();
	}
 
	public function is_authentic($username,$password){
		if($this->db->where(array('username' => $username,'password' => $password))->count_records('users') > 0){
		
			$this->db->where(array('username' => $username,'password' => $password));
			$result = $this->db->get('users');
			
			$row = $result->as_array();
			
			$row = $row[0];
			$this->id = $row->id;
			$this->name_first = $row->name_first;
			$this->name_last = $row->name_last;
			$this->username = $row->username;
			$this->password = $row->password;
			$this->email = $row->email;
			$this->phone = $row->phone;
			$this->date_last_login = $row->date_last_login;
			$this->date_registered = $row->date_registered;
			return 1;
		}else{
			echo "didnt find user";
		}

	}

	public function create($data){
		  $this->db->insert('users', $data);

	}
	
	public function update($id,$data){
		$this->db->where('id', $id);
		$this->db->update('users', $data);
	}
	
	public function delete(){

	}
		
	public function load($id){
		$this->db->where('id',$id);
	 	$result = $this->db->get('users');
                        
                $row = $result->as_array();
                        
                $row = $row[0];
                $this->id = $row->id;
                $this->name_first = $row->name_first;
                $this->name_last = $row->name_last;
                $this->username = $row->username;
                $this->password = $row->password;
                $this->email = $row->email;
                $this->phone = $row->phone;
                $this->date_last_login = $row->date_last_login;
                $this->date_registered = $row->date_registered;
	}
}
