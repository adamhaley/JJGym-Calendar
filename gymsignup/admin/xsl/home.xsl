<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="global.xsl" />
<xsl:import href="wrapper_main.xsl" />

<xsl:template match="content">
	<xsl:if test="/page/session/uid and resources/resource[@class='user'][1]">
		Welcome, <xsl:value-of select="resources/resource[@class='user'][1]/first_name" /> <xsl:text>  </xsl:text><xsl:value-of select="resources/resource[@class='user'][1]/last_name" />!
	</xsl:if>
	<xsl:if test="not(/page/session/uid)">
		Welcome!<br /> <span style="font-size:9px;font-style:italic ">(You are not <a href="?c=login" style="font-size:9px;"> Logged In</a>.)</span>
	</xsl:if>
  <!--
<object width="550" height="400">
<param name="movie" value="mgs.swf" />
<embed src="mgs.swf" width="550" height="400">
</embed>
</object>
--><div id="featuredstory">
     Featured Story Here
  </div>
	<div id="storylist">
	<div id="pagernav">
	<xsl:variable name="page">
                <xsl:choose>
                        <xsl:when test="/page/request/page">
                        <xsl:value-of select="/page/request/page" />
                        </xsl:when>
                        <xsl:otherwise>
                        1
                        </xsl:otherwise>
                </xsl:choose>
        </xsl:variable>
	<xsl:variable name="action">
                <xsl:call-template name="pageaction" />
        </xsl:variable>
	<xsl:if test="/page/auxarray/totalcount &gt; 5">
	 <xsl:call-template name="pagernav">
                                        <xsl:with-param name="perpage" select="5" />
                                        <xsl:with-param name="page" select="$page" />
                                        <xsl:with-param name="nodeset" select="//resources/resource[@class='story']" />
                                        <xsl:with-param name="total"><xsl:value-of select="/page/aux/totalcount" /></xsl:with-param>
                                        <xsl:with-param name="baseurl">?<xsl:call-template name="querystring">

              <xsl:with-param name="newkey">c</xsl:with-param>

              <xsl:with-param name="newvalue"><xsl:value-of select="$action" /></xsl:with-param>

      </xsl:call-template></xsl:with-param>
              	</xsl:call-template>
	</xsl:if>
	</div>
		<br /><br /><br />
	<xsl:apply-templates select="resources/*[@class='story']" />
	</div>
</xsl:template>


<xsl:template match="resource[@class='story']">
	<xsl:variable name="story_id"><xsl:value-of select="story_id" /></xsl:variable>
	<xsl:variable name="story_photo" select="../resource[@class='story_photo'][story_id=$story_id][1]" />
	<div class="storyrow">
	
		<xsl:if test="$story_photo">
		<div class="storythumb">
		
		<a href="?c=view_story&amp;id={id}" >
		<img src="images/thumb_{$story_photo/filename}" height="60px" width="60px" style="border:1px solid black" />
		</a>
		
		</div>
		</xsl:if>
		<div class="storytitle">
			<a>
				<xsl:attribute name="href">?c=view_story&amp;id=<xsl:value-of select="id" /></xsl:attribute>
			<xsl:value-of select="title" /></a>
		</div>
		<div class="storyposted">
			posted: <xsl:value-of select="time_posted" />
		</div>
		<div class="storybody">
			<xsl:value-of select="substring(body,0,60)" disable-output-escaping="yes" /><a>
                                <xsl:attribute name="href">?c=view_story&amp;id=<xsl:value-of select="id" /></xsl:attribute>...</a>
		</div>
	</div><br />

</xsl:template>

</xsl:stylesheet>
