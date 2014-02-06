<?
// mysqli

$mysqli = new mysqli("localhost", "root", "root", "jjgym_calendar");
$result = $mysqli->query("SELECT * from USERS");
$row = $result->fetch_assoc();
echo htmlentities($row['_message']);



?>