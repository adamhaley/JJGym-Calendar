<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="global.xsl" />
<xsl:import href="wrapper_main.xsl" />

<xsl:output method="html" indent="yes" />


<xsl:template match="resources">
  <xsl:choose>
    <xsl:when test="/page/session/uid">
    <h1><xsl:value-of select="//resources/resource[@class='story'][1]/title" /></h1>
  <xsl:apply-templates select="resource[@class='comment'][1]" />
  <br />Reply to comment:<br />
<form method="post" action="index.php">
<input type="hidden" name="c" value="reply_comment_save" />
<input type="hidden" name="story_id" value="{/page/request/story_id}" />
<input type="hidden" name="comment_parent_id" value="{/page/request/comment_parent_id}" />
<textarea name="body" cols="100" rows="10">
</textarea><br /><br />
<input type="submit" value="Post Reply" />
</form>
    </xsl:when>
    <xsl:otherwise>
      Oops!<br />
      You need to be logged in to do that.<br />
      Please <a href="?c=login">Login</a> or <a href="?c=signup">Create an account</a> if you dont't have one.
    </xsl:otherwise>
  </xsl:choose>
</xsl:template>

<xsl:template match="resource[@class='comment']">
 <span class="commentposted"> On <xsl:value-of select="date_posted" />, <a href="?c=view_user&amp;user_id={user_id}"><xsl:value-of select="//resources/resource[@class='user'][user_id = ./user_id]/username" /></a>  says:</span>
 <br />
   <xsl:value-of select="substring(body,0,50)" disable-output-escaping="yes" /><br /><br />
</xsl:template>

</xsl:stylesheet>
