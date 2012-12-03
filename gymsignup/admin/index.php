<?
require 'require.php';

$commandstring = $_GET['c']? $_GET['c'] : 'admin_browse';

eval("\$command = new c_$commandstring;");
echo $command->process();
?>
