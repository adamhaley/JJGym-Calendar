<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="global.xsl" />
<xsl:import href="wrapper_main.xsl" />

<xsl:output method="html" indent="yes" />

<xsl:template match="resources">
	<xsl:apply-templates select="resource[@class='story'][1]" />
</xsl:template>

<xsl:template match="resource">
 <h1>Edit Story : Step 2</h1><br />
<form method="post" action='index.php' name='story'>
	<input type="hidden" name="c" />
	<input type="hidden" name="title" value="{/page/request/title}" />
	<input type="hidden" name="body" value="{/page/request/body}" />
	<input type="hidden" name="id" value="{story_id}" />
	<div class="formrow">
		<div class="col1"><b>Title</b></div>
		<div class="col2"><xsl:value-of select="title" /></div>
	</div><br />
	<div class="formrow">
		<div class="col1"><b>Body</b></div>
		<div class="col2">
		<xsl:value-of select="body" disable-output-escaping="yes" /><br />
		
		<br /><br />
		<input type="button" name="Back" value="&lt;&lt; Back" onClick="window.location='?c=submit_story&amp;id={id}';" /><xsl:text> 
		 </xsl:text> <input type="button" value="Next &gt;&gt;" onClick="window.location='?c=submit_story_step_3&amp;id={id}';"/>
		</div>
	</div>
	


</form>
</xsl:template>

</xsl:stylesheet>
