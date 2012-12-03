<?php defined('SYSPATH') or die('No direct script access.'); ?>

2009-05-11 23:49:13 -04:00 --- error: Uncaught Kohana_Database_Exception: There was an SQL error: Column 'usage' cannot be null - INSERT INTO `events` (`date`, `user_id`, `time_start`, `time_end`, `usage`, `comments`, `request_exclusive`) VALUES ('--', '1', '00:00', '00:00', NULL, '', '0') in file system/libraries/drivers/Database/Mysql.php on line 361
