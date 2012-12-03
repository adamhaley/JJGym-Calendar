<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="global.xsl" />
<xsl:import href="wrapper_main.xsl" />

<xsl:output method="html" indent="yes" />

<xsl:template match="resource">

</xsl:template>

<xsl:template match="resource[@class='story'][1]">
	<h1><xsl:value-of select="title" /></h1><br />
	<div class="container">
	<div id="story">
		<div class="storytitle">
			<h2><xsl:value-of select="title" /></h2>
		</div>
		<div class="storyposted">
			Posted by <a href="?c=view_user&amp;user_id={user_id}"><xsl:value-of select="//resources/resource[@class='user'][user_id = ./user_id]/username" /></a> on <xsl:value-of select="time_posted" />
		</div>
		<div class="body">
			<xsl:value-of select="body" disable-output-escaping="yes" />
		</div>
		<div id="comments" >
      <a href="?c=add_comment&amp;story_id={story_id}">+Add Comment</a><br /><br />
      <xsl:for-each select="//resources/resource[@class='comment'][comment_parent_id='0']">
        <xsl:call-template name="comment">
          <xsl:with-param name="commentnode" select="." />
        </xsl:call-template>
      </xsl:for-each>
		</div>
	</div>
    <xsl:call-template name="storyimage" />
	</div>
</xsl:template>

<xsl:template name="comment">
  <xsl:param name="commentnode" />
  <xsl:variable name="comment_id" ><xsl:value-of select="$commentnode/comment_id" /></xsl:variable>
  	
	<div class="reply"><span class="commentposted"><a href="?c=view_user&amp;user_id={$commentnode/user_id}"><xsl:value-of select="//resources/resource[@class='user'][user_id = $commentnode/user_id]/username" /></a>, <xsl:value-of select="$commentnode/date_posted" />:</span>
 	
 <br />
 <xsl:value-of select="substring($commentnode/body,0,50)" disable-output-escaping="yes" /><br />
 <span class="commentcontrols">[<a href="?c=reply_comment&amp;comment_parent_id={$commentnode/comment_id}&amp;story_id={/page/request/id}">Reply</a>]<!--[<a href="?c=view_thread&amp;comment_id={$commentnode/comment_id}">View Thread</a>]--><xsl:if test="user_id = /page/session/uid">[<a href="#">Delete</a>]</xsl:if>
</span>
<xsl:for-each select="//resources/resource[@class='comment'][comment_parent_id = $comment_id]">
  <xsl:call-template name="comment">
    <xsl:with-param name="commentnode" select="." />
  </xsl:call-template>
</xsl:for-each>                         
</div>
</xsl:template>

<xsl:template name="storyimage">
	<xsl:variable name="imagenode" select="//resources/resource[@class='story_photo']" />
 <div id="storyimage" >
        <img class="storyimage" src="images/resized_{$imagenode[./id = /page/request/imageid]/filename}" width="200px">
		<xsl:attribute name="onClick">window.open('index.php?c=slideshow&amp;id=<xsl:value-of select="/page/request/id" />&amp;imageid=<xsl:value-of select="/page/request/imageid" />','slideshow','width=400,height=500');</xsl:attribute>
	</img>
         <span class="imagetext">
           
		<br /><br />
	  <center>
        <xsl:call-template name="slideshowcontrols" />

               </center><br />
               
   </span>
 </div>
</xsl:template>

</xsl:stylesheet>
