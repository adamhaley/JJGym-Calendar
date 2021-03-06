<?php defined('SYSPATH') or die('No direct script access.');
/**
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Admin_Controller extends Template_Controller {
  	// Set the name of the template to use
        public $template = 'kalvan/template';
	
	public function index()
	{
                $user = new User_Model;

		if(isset($_SESSION['uid'])){
                       $user->load($_SESSION['uid']);
                       $this->template->user = $user;
                }

		$this->session = Session::instance();

		$amodel = new Announcements_Model;
		$data = $amodel->get();
		$data = $data->as_array();
	
		$this->template->content = new View('admin');
                $this->template->user = $user;
		$this->template->content->data = $data;

	}

	public function update_ann(){
	
		$user = new User_Model;

		if(isset($_SESSION['uid'])){
                       $user->load($_SESSION['uid']);
                       $this->template->user = $user;
                }

                $this->session = Session::instance();


		$content = $this->input->post('editor1');
	
		$this->template->content = new View('update_ann');
		$this->template->user = $user;

		$mod = new Announcements_Model;
		$data = array('announcement' => $content);
		$mod->update($data);
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
