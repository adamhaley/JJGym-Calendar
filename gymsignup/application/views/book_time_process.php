<?php
//format date
$timestamp = strtotime($date);
$date = date('l F j, Y',$timestamp);
?>
<br /><br />
<b>
Thank You, <?php echo $user->name_first ?>. 

Your time is booked on <?php echo $date ?>. 
</b>

<script>

setTimeout('window.location="<?php echo $_SERVER['SCRIPT_NAME']; ?>"',3000);


</script>
