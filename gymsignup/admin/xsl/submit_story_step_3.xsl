<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="global.xsl" />
<xsl:import href="wrapper_main.xsl" />

<xsl:output method="html" indent="yes" />


<xsl:template match="resources">

<h1>Edit Story: Upload Images</h1><br /><br />

<form method="post" enctype="multipart/form-data" action="index.php?c=submit_story_step_3" >
<input type="file" name="image" />
<input type="hidden" name="id" value="{/page/request/id}" />
<br /><br />
<input type="submit" value="Upload Image" /><xsl:text>    </xsl:text>


<input type="button" value="Done &gt;&gt;" onClick="window.location='?c=submit_story_step_4&amp;id={/page/request/id}';" />
<br /><br />
<xsl:for-each select="resource[@class='story_photo']">
<div class="uploadthumb">
<img src="images/thumb_{filename}" />
<br />
<center><a href="#" onClick="window.open('index.php?c=edit_photo&amp;id={story_photo_id}','edit_photo','width=400,height=500');">Edit</a><xsl:text>    </xsl:text><a href="?c=submit_story_step_3&amp;id={/page/request/id}&amp;deleteimage={story_photo_id}" >Delete</a></center>
</div>
</xsl:for-each>


</form>
</xsl:template>

</xsl:stylesheet>
