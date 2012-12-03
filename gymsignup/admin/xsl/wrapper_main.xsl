<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" indent="yes" />
<xsl:template match="/">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>MGS</title>
<style type="text/css" media="all">@import "css/main.css";</style>

<script language="javascript">
	function deleteConfirm(url){
		if(confirm("Are you sure you want to delete?")){
			window.location=url;
		}
	}
</script>
<script language="javascript" src="js/global.js" />
</head>

<body>
<div id="toparea">
</div>
<div id="logo" onClick="window.location='?c=home'" style="cursor:pointer;">
	<span>Make God Smile></span>
</div>
<div id="banner">
	<span class="adtext">Ad Banner 600x90</span>
</div>
<br />

<div id="header"><span class="navtext">
<a href="?c=home"  class="button">Home</a>  
<xsl:if test="/page/session/uid" >
	<a href="?c=submit_story"  class="button">Submit A Story</a> 
	     <a href="?c=manage_stories"  class="button">My Stories</a>
</xsl:if>
<a href="?c=about"  class="button">About </a>
<a href="?c=contact"  class="button">Contact</a> 
<a href="?c=store"  class="button">Store</a>
<xsl:choose>
	<xsl:when test="/page/session/uid">
		<a href="?c=logout"  class="button">Logout</a>
	</xsl:when>
	<xsl:otherwise>
		<a href="?c=signup" class="button">Signup</a><a href="?c=login" class="button">Login</a>
	</xsl:otherwise>
</xsl:choose>

</span>
</div>
<div id="bar">
<xsl:text> </xsl:text>
</div>
<!--
<div id="menu"><br />
  <xsl:call-template name="menu" /><br />
    <xsl:call-template name="menu" /><br />
      <xsl:call-template name="menu" />
      </div>
      <br />
	  -->
<div id="search">
Search Stories:  <input type="text" /><a href="#" onClick="document.forms[0].submit();">GO</a>
</div>

<div id="content">

<xsl:apply-templates select="/page/messages" />

<!--Welcome Message-->



<div id="innercontent">
<xsl:apply-templates select="/page/content" />
</div>	
<br /><br /><br />
</div>
<div id="adcolumn">
Advertising 160X600

</div>
<br />
<!--
<div id="adcolumn2">
Advertising 120 x 120
</div>
-->
</body>

</html>
</xsl:template>

<xsl:template name="menu">
<div>
         <a href="" title="">Link One</a><br />
        <a href="" title="">Another Link</a><br />
        <a href="" title="">Links Somewhere</a><br />
        <a href="" title="">Link Four</a><br />
        <a href="" title="">Fifth Link</a><br />

        </div>

</xsl:template>

</xsl:stylesheet>
