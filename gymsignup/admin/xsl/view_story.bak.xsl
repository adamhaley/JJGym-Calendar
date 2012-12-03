<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="global.xsl" />
<xsl:import href="wrapper_main.xsl" />

<xsl:output method="html" indent="yes" />

<xsl:template match="resource">

</xsl:template>

<xsl:template match="resource[@class='story'][1]">
	<h1>Viewing Story: <xsl:value-of select="title" /></h1><br />
	<div class="container">
	<xsl:call-template name="storyimage" />
	<div id="story">
		<div class="storytitle">
			<h2><xsl:value-of select="title" /></h2>
		</div>
		<div class="storyposted">
			<xsl:value-of select="time_posted" />
		</div>
		<div class="body">
			<xsl:value-of select="body" disable-output-escaping="yes" />
		</div>
	</div>
	</div>
</xsl:template>
<xsl:template name="storyimage">
	<xsl:variable name="imagenode" select="//resources/resource[@class='story_photo']" />
 <div id="storyimage" >
	
        <img src="images/resized_{$imagenode[./id = /page/request/imageid]/filename}" width="200px">
		<!--
		<xsl:attribute name="onClick">window.open('index.php?c=slideshow&amp;imageid=<xsl:value-of select="{/page/request/imageid}" />','slideshow','width=400,height=500');</xsl:attribute>
		-->
	</img>
         <span class="imagetext">
           
		<br /><br />
	<center>  

<!--START SLIDESHOW CONTROLS-->
<xsl:choose>
<xsl:when test="$imagenode[id=/page/request/imageid]/preceding-sibling::resource/@class='story_photo'">
 <a href="?c=view_story&amp;id={/page/request/id}&amp;imageid={$imagenode[1]/id}">|&lt;&lt;</a> <xsl:text>  </xsl:text> <a href="?c=view_story&amp;id={/page/request/id}&amp;imageid={$imagenode[id=/page/request/imageid]/preceding-sibling::resource/id}">&lt;</a> 	
</xsl:when>
<xsl:otherwise>
|&lt;&lt;    &lt;
</xsl:otherwise>
</xsl:choose>

<!--
<xsl:text>  . . . . . oOo. . . . . </xsl:text> 
-->
image <xsl:value-of select="$imagenode[id=/page/request/id]::position()" /> of <xsl:value-of select="count(//resources/resource[@class='story_photo'])" />
<xsl:choose>
<xsl:when test="$imagenode[id=/page/request/imageid]/following-sibling::resource/@class='story_photo'">
 <a href="?c=view_story&amp;id={/page/request/id}&amp;imageid={$imagenode[id=/page/request/imageid]/following-sibling::resource/id}">&gt;</a> 
<xsl:text>  </xsl:text> <a href="?c=view_story&amp;id={/page/request/id}&amp;imageid={$imagenode[last()]/id}">&gt;&gt;|</a>  
</xsl:when>
<xsl:otherwise>
&gt;  &gt;&gt;|
</xsl:otherwise>
</xsl:choose>
<!--END SLIDESHOW CONTROLS-->


 </center>
	 </span>
 </div>
</xsl:template>


</xsl:stylesheet>
