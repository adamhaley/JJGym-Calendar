<?
$link = mysql_connect('localhost', 'root', 'root');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}


mysql_select_db('jjgym_calendar',$link);

header('Content-type:text/json');

$q = "SELECT e.user_id, e.comments, e.date, e.time_start, e.time_end, u.name_first, u.name_last from events as e, users as u where u.id = e.user_id and (u.id = '9' or u.id = '2') and e.comments LIKE '%acro%' order by date desc;";

$result = mysql_query($q,$link);
$rows = Array();
while($row = mysql_fetch_assoc($result)){
	$rows[] = $row;

}
print json_encode($rows);


if (!$result) {
    die('Invalid query: ' . mysql_error());
}
// print_r($row);

mysql_close($link);
?>

