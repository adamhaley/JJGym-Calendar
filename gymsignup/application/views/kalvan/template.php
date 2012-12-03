<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>
The Kalvan's Practice Space Calendar
</title>
<link rel="stylesheet" href="http://www.jjgym.com/gymsignup/css/main.css" />
<script language="javascript" src="http://www.jjgym.com/js/prototype.js" ></script>
<script>
function delete_event(id){
	req = new Ajax.Request('<?php echo $_SERVER['SCRIPT_NAME']; ?>/calendar/delete_event?id=' + id,{onComplete:delete_event_complete});
}

function delete_event_complete(req){
	window.location.reload();
}

</script>

	<script type="text/javascript" src="http://www.jjgym.com/js/ckeditor/ckeditor.js"></script>
	<script type="text/javascript">
		CKEDITOR.replace( 'ckeditor',
    {
        toolbar : 'basic',
        uiColor : '#fff'
    });

	</script>
</head>
<body>
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
				echo " [<a href='" .  $_SERVER['SCRIPT_NAME'] . "/calendar/book_time'>Reserve Time Slot</a>] "; 
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



</body>
</html>
