<?php defined('SYSPATH') or die('No direct script access.'); ?>

2009-02-04 01:28:10 -05:00 --- error: Uncaught Kohana_Database_Exception: There was an SQL error: Unknown column 'events.duration' in 'field list' - SELECT TIME_FORMAT(events.time_start,'%l:%i %p') as time, events.id, events.user_id, events.date,events.duration,events.time_start, users.name_first, users.name_last FROM events,users where events.date >= '2009-2-1' and events.date < '2009-3-1' and events.user_id = users.id order by events.time_start + 0 in file system/libraries/drivers/Database/Mysql.php on line 361
2009-02-04 03:19:10 -05:00 --- error: Uncaught PHP Error: Undefined variable: content in file application/views/kalvan/template.php on line 135
2009-02-04 17:35:29 -05:00 --- error: Uncaught PHP Error: Undefined variable: content in file application/views/kalvan/template.php on line 135
