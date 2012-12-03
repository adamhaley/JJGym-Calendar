<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="global.xsl" />
<xsl:import href="wrapper_main.xsl" />

<xsl:output method="html" indent="yes" />


<xsl:template match="resources">
 <h1>Edit Story</h1><br />
<form method="post" action="index.php?c=submit_story_step_2">
<input type="hidden" name="id" value="{/page/request/id}" />
<div class="formrow">
		<div class="col1">Title</div>
		<div class="col2">
		<input type="text" name="title" size="40">
			<xsl:attribute name="value" >
				<xsl:apply-templates select="resource[@class='story'][1]/title" />
			</xsl:attribute>
		</input>
		</div>
	</div><br />
	<div class="formrow">
		<div class="col1">Body</div>
		<div class="col2">
		<textarea name="body" cols="100" rows="30">
			<xsl:apply-templates select="resource[@class='story'][1]/body" />
		</textarea>
		<br /><input type="submit" value="Next &gt;&gt;" />
		</div>
	</div>
	


</form>
</xsl:template>

</xsl:stylesheet>
