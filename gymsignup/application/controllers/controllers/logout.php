<?php defined('SYSPATH') or die('No direct script access.');

class Logout_Controller extends Controller{
	public function index(){
                 $this->session = Session::instance();

                $this->session->delete('uid');
                header('Location:' . $_SERVER['SCRIPT_NAME']);

	}
}
