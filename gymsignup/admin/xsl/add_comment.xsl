<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="global.xsl" />
<xsl:import href="wrapper_main.xsl" />

<xsl:output method="html" indent="yes" />


<xsl:template match="resources">
  <xsl:choose>
    <xsl:when test="/page/session/uid">

  <h1>Add comment to <xsl:value-of select="resource[@class='story'][1]/title" /></h1><br />

<form method="post" action="index.php">
<input type="hidden" name="c" value="add_comment_save" />
<input type="hidden" name="story_id" value="{/page/request/story_id}" />
<textarea name="body" cols="100" rows="10">
</textarea><br /><br />
<input type="submit" value="Add Comment" />
</form>
    </xsl:when>
    <xsl:otherwise>
      Oops!<br />
      You need to be logged in to do that.<br />
      Please <a href="?c=login">Login</a> or <a href="?c=signup">Create an account</a> if you dont't have one.
    </xsl:otherwise>
  </xsl:choose>
</xsl:template>

</xsl:stylesheet>
