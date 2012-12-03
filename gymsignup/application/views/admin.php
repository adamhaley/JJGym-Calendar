<?
?>
<h2>Edit Announcements</h2>
<form method="post" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>/admin/update_ann">
<textarea class="ckeditor" cols="80" id="editor1" name="editor1" rows="10">

<? echo $data[0]->announcement;?>


</textarea>
<br />
<input type="submit" value="Submit" />
</form>
