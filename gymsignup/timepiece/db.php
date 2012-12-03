<?//MYSQL CONNEX
$link = mysql_connect('localhost','jjgym_root','slinkyjuggler');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db('jjgym_timepiece');
?>
