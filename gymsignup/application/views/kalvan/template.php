<!DOCTYPE html>
<html data-ng-app="jjgym">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>
The Kalvan's Practice Space Calendar
</title>
<link rel="stylesheet" href="js/bower_components/bootstrap/dist/css/bootstrap.css" />
<link rel="stylesheet" href="js/bower_components/angular/angular-csp.css" /> 
<link rel="stylesheet" href="http://www.jjgym.com/gymsignup/css/main.css" />
<!-- <script language="javascript" src="http://www.jjgym.com/js/prototype.js" ></script>  -->


	<script type="text/javascript" src="http://www.jjgym.com/js/ckeditor/ckeditor.js"></script>
	<script type="text/javascript">
		/*
		var config = {
        	toolbar : 'basic',
        	uiColor : '#fff'
    	}

		CKEDITOR.replace( 'ckeditor',config);
		*/
	</script>
</head>
<body data-ng-controller="CalendarController">
  <h1><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">The Kalvan's Practice Space Calendar</a></h1>
	Back to <a href="http://www.jjgym.com">JJGym homepage</a><br>
   <div id="login">
	<?php 
		if(isset($_SESSION['uid'])){
			if($user->name_first != ''){
			echo "<b>Welcome, " . $user->name_first . " " . $user->name_last . "!</b>";
 			}
			if($this->uri->last_segment() == 'book_time'){
				echo " [<a href='" .  $_SERVER['SCRIPT_NAME'] . "/calendar/'> &lt;&lt;Back To Calendar</a>]";
			}else{
				echo " [<a class='book-link' data-ng-click='bookTime()'>Reserve Time Slot</a>] "; 
			} 
			if($_SESSION['uid'] == '2' || $_SESSION['uid'] == '9' || $_SESSION['uid'] =='1'){
				echo " [<a href='" . $_SERVER['SCRIPT_NAME'] . "/admin'>Edit Announcements</a>]";
			}
			
			echo " [<a href='" .  $_SERVER['SCRIPT_NAME'] . "?logout'>Logout</a>] ";
		}else{
	?>
		<form action="" method="POST" name="login"> 
		<!--Username:<input type="text" name="username" />--> <b>Password:</b><input type="password" name="password"/> [<a href="#" onClick="document.forms['login'].submit();">Login</a>]
	</form>
	
	<? } ?>
	</div>

	<div id="content">
	<?php echo $content ?>
	</div>
	<br /><br /><br /><br /><br /><br /><br /><br />
        <div id="footer" class="copyright">
                Rendered in {execution_time} seconds, using {memory_usage} of memory<br />
                Calendar app developed by Adam Haley using Kohana
        </div>
	
	<script type="text/javascript" src="js/bower_components/jquery/jquery.js"></script>
	<script type="text/javascript" src="js/bower_components/angular/angular.js"></script>
	<script type="text/javascript" src="js/bower_components/bootstrap/dist/js/bootstrap.js"></script>
	<script type="text/javascript" src="js/bower_components/moment/moment.js"></script>
	<script type="text/javascript" src="js/bower_components/twix/bin/twix.js"></script>
	<script type="text/javascript" src="js/bower_components/underscore/underscore.js"></script>
	<script type="text/javascript" src="js/bower_components/angular-ui-bootstrap/src/timepicker/timepicker.js"></script>
	<script type="text/javascript" src="js/bower_components/angular-ui-bootstrap/src/dropdownToggle/dropdownToggle.js"></script>
	<script type="text/javascript" src="js/bower_components/angular-ui-bootstrap/src/transition/transition.js"></script>
	<script type="text/javascript" src="js/bower_components/angular-ui-bootstrap/src/modal/modal.js"></script>
	<script type="text/javascript" src="js/app.js"></script>
</body>
</html>
