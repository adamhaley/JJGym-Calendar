<?
$dir = "classes/";
if ($handle = opendir($dir)) {
  while ($fentry = readdir($handle)) {
   if (is_file("$dir/$fentry") && $fentry != 'require.php' && !preg_match("/^\./",$fentry)) {
     if (preg_match("/\.php$/i",$fentry))
	 	if($fentry=='view.php'){
			if (version_compare(PHP_VERSION,'5','>=')){
				require_once("$dir/$fentry");
			}				
		}else if($fentry=='view-php4.php'){
	 		if (version_compare(PHP_VERSION,'5','<')){
				require_once("$dir/$fentry");
			}	
		}else{
      		require_once("$dir/$fentry");
     	}
	 }
   }
}

$dir = "resources/";
if ($handle = opendir($dir)) {
  while ($fentry = readdir($handle)) {
   if (is_file("$dir/$fentry") && $fentry != 'require.php') {
     if (preg_match("/\.php$/i",$fentry))
      require("$dir/$fentry");
     }
   }
}

$dir = "commands/";
if ($handle = opendir($dir)) {
  while ($fentry = readdir($handle)) {
   if (is_file("$dir/$fentry") && $fentry != 'require.php') {
     if (preg_match("/\.php$/i",$fentry))
      require("$dir/$fentry");
     }
   }
}

$db = new db('localhost','jjgym_root','slinkyjuggler','jjgym_calendar');

$message = new message();
$dbcache = new dbcache();


//initialise session vars
session_register('mode');

$_SESSION['mode'] = $_GET['mode'] ? $_GET['mode'] : $_SESSION['mode'];

//do xslt conversion to php5 in case running on a php5 server


?>
