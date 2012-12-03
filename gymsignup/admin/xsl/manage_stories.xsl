<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="global.xsl" />
<xsl:import href="wrapper_main.xsl" />

<xsl:output method="html" indent="yes" />


<xsl:template match="resources">
 <h1>My Stories</h1><br />

<xsl:apply-templates select="resource[@class='story']" />
</xsl:template>


<xsl:template match="resource[@class='story']">
<xsl:variable name="story_id"><xsl:value-of select="story_id" /></xsl:variable>
<xsl:variable name="story_photo" select="../resource[@class='story_photo'][story_id=$story_id][1]" />
		<xsl:if test="$story_photo">
		<div class="storythumb">
		
		<a href="?c=view_story&amp;id={id}" >
		<img src="images/thumb_{$story_photo/filename}" height="60px" width="60px" style="border:1px solid black" />
		</a>
		
		</div>
		</xsl:if>
        <div class="storyrow">
                <div class="storytitle">
			<b>
                        <xsl:value-of select="title" /></b>
                </div>
                <div class="storyposted">
                        posted: <xsl:value-of select="time_posted" />
                </div>
                <div class="storybody">
                        <xsl:value-of select="substring(body,0,200)" disable-output-escaping="yes" />
                </div>
        </div>
	[<a href="?c=submit_story&amp;id={id}">Edit</a>] <xsl:text >    </xsl:text>
	<br /><br />
</xsl:template>
</xsl:stylesheet>
