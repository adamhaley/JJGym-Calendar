<?php

// Get the day names
$days = Calendar::days(TRUE);

// Previous and next month timestamps
$next = mktime(0, 0, 0, $month + 1, 1, $year);
$prev = mktime(0, 0, 0, $month - 1, 1, $year);

// Import the GET query array locally and remove the day
$qs = $_GET;
unset($qs['day']);

// Previous and next month query URIs
$prev = Router::$current_uri.'?'.http_build_query(array_merge($qs, array('month' => date('n', $prev), 'year' => date('Y', $prev))));
$next = Router::$current_uri.'?'.http_build_query(array_merge($qs, array('month' => date('n', $next), 'year' => date('Y', $next))));

?>
<table class="calendar">
<tr class="controls">
<td class="prev" colspan="3"><?php echo html::anchor($prev, '&laquo;') ?></td>
<td class="title" colspan="1"><?php echo strftime('%B %Y', mktime(0, 0, 0, $month, 1, $year)) ?></td>
<td class="next" colspan="3"><?php echo html::anchor($next, '&raquo;') ?></td>
</tr>
<tr>
<?php foreach ($days as $day): ?>
<th><?php echo $day ?></th>
<?php endforeach ?>
</tr>
<?php $i=0; foreach ($weeks as $week): ?>
<tr>
<?php foreach ($week as $day):

list ($number, $current, $data) = $day;

if (is_array($data))
{
	$classes = $data['classes'];
	$output = empty($data['output']) ? '' : '<ul class="output"><li>'.implode('</li><li>', $data['output']).'</li></ul>';
}
else
{
	$classes = array();
	$output = '';
}
if(($i == 0 && $day[0] >7) || ($i>=4 && $day[0] < 7)){
?>
<td></td>
<?php
}else{
	$tdclass ='day';
	$now = mktime(0, 0, 0, date('m'), date('j'), date('Y'));
	$compdate = mktime(0,0,0,$month,$day[0],$year);
	if($compdate < $now){
		$tdclass = 'before';
	}else if($compdate == $now){
		$tdclass = 'today';
	}
?>
<!--<td class="<?php echo implode(' ', $classes) ?>">--><td valign="top" class="<?=$tdclass;?>" onClick="selectDay(<? echo $month ?>,<?php echo $day[0] ?>,<?php echo $year ?>);"><span class="day_content"><?php echo $day[0] ?></span><?php echo $output ?></td>
<?php } endforeach ?>
</tr>
<?php $i++; endforeach ?>
</table>
