<?xml version='1.0' encoding='ISO-8859-1' ?> 
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<!--VARIABLE TEMPLATES-->
<!--PAGE ACTION MAP
        THIS TEMPLATE RETURNS THE VALUE OF THE ACTION VARIABLE
        THAT IS USED TO PERSIST THE PAGE ACTION TO THINGS LIKE PAGINATION AND COLUMN SORT.
        SOMETIMES WE WANT THIS TO BE THE SAME, OTHER TIMES WE WANT IT TO MAP TO A NEW ACTION.
        -->
<xsl:template name="pageaction">
  <xsl:choose>
    <xsl:when test="/page/request/c/. = 'admin_delete' or /page/request/c/. = 'login_authenticate' or /page/request/c/. = 'admin_save'">admin_browse</xsl:when>
    <xsl:otherwise><xsl:value-of select="/page/request/c" /></xsl:otherwise>
  </xsl:choose>
</xsl:template>
<!--END VARIABLE TEMPLATES-->

<!--REUSEABLE SLIDESHOW CONTROLS-->
<!--START SLIDESHOW CONTROLS-->
<xsl:template name="slideshowcontrols">
  <xsl:variable name="imagenode" select="//resources/resource[@class='story_photo']" />

<xsl:choose>
<xsl:when test="$imagenode[id=/page/request/imageid]/preceding-sibling::resource[1]/@class='story_photo'">
 <a href="?c={/page/request/c}&amp;id={/page/request/id}&amp;imageid={$imagenode[1]/id}">|&lt;&lt;</a> <xsl:text>  </xsl:text> <a href="?c={/page/request/c}&amp;id={/page/request/id}&amp;imageid={$imagenode[id=/page/request/imageid]/preceding-sibling::resource[1]/id}">&lt;</a>
</xsl:when>
<xsl:otherwise>
|&lt;&lt;    &lt;
</xsl:otherwise>
</xsl:choose>

<!--
<xsl:text>  . . . . . oOo. . . . . </xsl:text>
-->
image <xsl:value-of select="count($imagenode[id=/page/request/imageid]/preceding-sibling::*) + 1" /> of <xsl:value-of select="count(//resources/resource[@class='story_photo'])" />
<xsl:choose>
<xsl:when test="$imagenode[id=/page/request/imageid]/following-sibling::resource/@class='story_photo'">
 <xsl:text>  </xsl:text><a href="?c={/page/request/c}&amp;id={/page/request/id}&amp;imageid={$imagenode[id=/page/request/imageid]/following-sibling::resource/id}">&gt;</a>
<xsl:text>  </xsl:text> <a href="?c={/page/request/c}&amp;id={/page/request/id}&amp;imageid={$imagenode[last()]/id}">&gt;&gt;|</a>
</xsl:when>
<xsl:otherwise>
    &gt;  &gt;&gt;|
</xsl:otherwise>
</xsl:choose>
</xsl:template>
<!--END SLIDESHOW CONTROLS-->


<!--REUSEABLE DROPDOWN MENU-->
<xsl:template name="dropdown">
	<xsl:param name="nodeset" />
	<xsl:param name="namefield" />
	<xsl:param name="valuefield" />
	<xsl:param name="heading" />
	<xsl:param name="fieldname" />
	<xsl:param name="selectedvalue" />
	<xsl:param name="searchform" />

	<xsl:if test="$heading != ''">
		<xsl:value-of select="$heading" />:<br />
	</xsl:if>	
	
	<!--START DROPDOWN-->
	<select>
		
		<xsl:attribute name="name"><xsl:value-of select="$fieldname" /></xsl:attribute>
		<xsl:choose>
			<xsl:when test="$searchform = 1">
				<option value=""></option>
			</xsl:when>
			<xsl:otherwise>
				<option value="1">TBD</option>
			</xsl:otherwise>
		</xsl:choose>

		<xsl:for-each select="$nodeset">
	
	
	
			<option>
				<xsl:if test="$selectedvalue = name">
					<xsl:attribute name="selected">1</xsl:attribute>
				</xsl:if>
				<xsl:attribute name="value">
					<xsl:value-of select="*[name()=$valuefield]" /> 
				</xsl:attribute>
			
				<xsl:value-of select="*[name()=$namefield]" />
			</option>
		
		</xsl:for-each>
	</select>
	<!--END DROPDOWN-->
</xsl:template>
<!--END REUSEABLE DROPDOWN MENU-->


<!--REUSEABLE CHECKBOXES-->
<xsl:template name="checkboxes">
	<xsl:param name="nodeset" />
	<xsl:param name="value" />

	<xsl:for-each select="$nodeset">
		<input type="checkbox">
			<xsl:attribute name="name"><xsl:value-of select="@class" />[]</xsl:attribute>
			<xsl:attribute name="value"><xsl:value-of select="id" /></xsl:attribute>
			<xsl:if test="contains($value,./name)">
				<xsl:attribute name="checked">1</xsl:attribute>
			</xsl:if>

		</input>
		 <xsl:text>    </xsl:text>
		<xsl:value-of select="name" />
	</xsl:for-each>
	
</xsl:template>
<!--END REUSEABLE CHECKBOXES-->


<!--GENERIC PAGER TEMPLATE-->
<xsl:template name="pagernav">
	<xsl:param name="total" />
	<xsl:param name="nodeset" />
	<xsl:param name="perpage" />
	<xsl:param name="page" />
	<xsl:param name="baseurl" />
	<xsl:param name="start" />
	<xsl:param name="end" />  

	<!--SET UP VARIABLES-->
	<xsl:variable name="action">
		<xsl:choose>
			<xsl:when test="/page/request/action = 'admin_delete' or /page/request/action = 'admin_save'">admin_browse</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="/page/request/action" />
			</xsl:otherwise>
		</xsl:choose>

	</xsl:variable>
	
	<xsl:variable name="numpages" select="ceiling($total div $perpage)" />

	<xsl:variable name="res"><xsl:value-of select="/page/content/resources/resource[1]/@class" /></xsl:variable>

	<!--END SET UP VARIABLES-->

	<div class='paginator'>
		<div class='paginatorleft'>
			<xsl:if test="$page &gt; 1">
				<xsl:attribute name="onClick">
				window.location='<xsl:value-of select="$baseurl" />&amp;page=<xsl:value-of select="$page - 1" />';</xsl:attribute>
			</xsl:if>
	
	<span>
	<!--START FIRST LINK-->
<!--	[ 
	<xsl:choose>
		<xsl:when test="$page &gt; 1">
		<a>
			<xsl:attribute  name="href">?c=admin_browse&amp;res=<xsl:value-of select="$res" />&amp;page=<xsl:value-of select="1" />
			</xsl:attribute>
			First</a>
		</xsl:when>
		<xsl:otherwise>
			First
		</xsl:otherwise>
	</xsl:choose>
-->
	<!--END FIRST LINK-->
<!--	] &#9674; [ &#171; -->
	<!--START PREVIOUS LINK-->
	<xsl:choose>
		<xsl:when test="$page &gt; 1">
			<a>
				<xsl:attribute  name="href"><xsl:value-of select="$baseurl" />&amp;page=<xsl:value-of select="$page - 1" /></xsl:attribute>
				Previous</a>
		</xsl:when>
		<xsl:otherwise>
			Previous
		</xsl:otherwise>
	</xsl:choose>
	<!--END PREVIOUS LINK-->
	<!--]-->
	</span>
  	</div>
  	<!--START CENTRAL AREA-->												
	<div class='paginatortext'>
		
	Page <select name='page'>
		<xsl:attribute name="onChange">goPage('<xsl:value-of select="$baseurl" />',this);</xsl:attribute>
			
			<xsl:call-template name="pageroption">
				<xsl:with-param name="total"  select="$numpages" />
				<xsl:with-param name="page" select="1" />
			</xsl:call-template>

		</select> <!--of <xsl:value-of select="$numpages" />-->
		<br /> 
	</div>
	<!--END CENTRAL AREA-->
	<div class='paginatorright'>
		<xsl:if test="$page &lt; $numpages">
		
			<xsl:attribute  name="onClick">window.location='<xsl:value-of select="$baseurl" />&amp;page=<xsl:value-of select="$page + 1" />';</xsl:attribute>
		
		</xsl:if>
	<span>
	<!--[-->
	<!--START NEXT LINK-->
	<xsl:choose>
		<xsl:when test="$page &lt; $numpages">
		<a>
			<xsl:attribute  name="href"><xsl:value-of select="$baseurl" />&amp;page=<xsl:value-of select="$page + 1" /></xsl:attribute>
			Next</a>
		</xsl:when>
		<xsl:otherwise>
			Next
		</xsl:otherwise>
	</xsl:choose>
	<!--END NEXT LINK-->
	<!--&#187; ] &#9674; [-->
	<!--START LAST LINK-->
	<!--
	<xsl:choose>
		<xsl:when test="$page &lt; $numpages">
			<a>
				<xsl:attribute  name="href">?c=admin_browse&amp;res=<xsl:value-of select="$res" />&amp;page=<xsl:value-of select="$numpages" />
				
				</xsl:attribute>
				Last</a>
		</xsl:when>
		<xsl:otherwise>
			Last
		</xsl:otherwise>
	</xsl:choose>
	-->
	<!--END LAST LINK-->
	<!--]-->
	</span>
	</div>
   	</div>	
</xsl:template>
<!--END GENERIC PAGER TEMPLATE-->

<!--START PAGER OPTION-->
<xsl:template name="pageroption">
	<xsl:param name="total" />
	<xsl:param name="page" />

	<xsl:variable name="nextpage" select="$page + 1" />
	<option>
		<xsl:attribute name="value"><xsl:value-of select="$page" /></xsl:attribute>
		<xsl:if test="$page = /page/request/page">
			<xsl:attribute name="selected">1</xsl:attribute>
		</xsl:if>
		<xsl:value-of select="$page" />
	</option>
	
	<xsl:if test="$page &lt;$total">
		<xsl:call-template name="pageroption">
			<xsl:with-param name="total"  select="$total" />
			<xsl:with-param name="page" select="$nextpage" />
		</xsl:call-template>
	</xsl:if>	

</xsl:template>
<!--END PAGEROPTION-->

<!--QUERYSTRING PERSISTENCE TEMPLATE-->
<!--USE THIS TEMPLATES TO BUILD LINKS AND MAINTAIN QUERYSTRING PARAMS OF CURRENT REQUEST-->
<xsl:template name="querystring">
	<xsl:param name="newkey" />
	<xsl:param name="newvalue" />

	<xsl:for-each select="/page/request/child::*[name() != $newkey]">
		
		<xsl:value-of select="name()" />=<xsl:value-of select="." />
		<xsl:if test="position() &lt; last()">&amp;</xsl:if>
	</xsl:for-each>
	<xsl:if test="$newkey != ''">&amp;<xsl:value-of select="$newkey" />=<xsl:value-of select="$newvalue" /></xsl:if>
</xsl:template>
<!--END QUERYSTRING PERSISTENCE TEMPLATE-->

<!--START LOGIN FORM-->
<xsl:template name="login">




			<form name="login" method="post" action="index.php?c=login_authenticate">
			<table width="350" cellspacing="0" cellpadding="0" class="logintable">
			
					<tr>
						<td colspan="2" class="textcell_left"><b>Login</b><br /><br /></td>
					</tr>
					<tr>
						<td class="textcell_left">User Name:</td>
						<td><input type="text" name="username" size="30"  maxlength="40" /></td>
					</tr>
					<tr>
						<td class="textcell_left">Password:</td>
						<td><input type="password" name="password"  size="30" maxlength="32"/></td>
					</tr>
					
					<tr>
						<td class="textcell_left"></td>
						<td class="inputcell"><input type="submit" value="Login" /></td>
						<input type="hidden" name="login" value="1" />
					</tr>
				
				
			</table>
			</form>
			<script language="javascript">
				document.login.username.focus();
			</script>
</xsl:template>
<!--END LOGIN-->

<!--MESSAGES-->
<xsl:template name="messages" >
<xsl:if test="count(/page/messages/child::*) &gt; 0">
<div class="messages">
	<xsl:for-each select="/page/messages/message">
			<div>
				<xsl:attribute name="class"><xsl:value-of select="@type" /></xsl:attribute>
				<xsl:value-of select="." disable-output-escaping="yes"/><br /><br />
			</div>
	</xsl:for-each>
	
</div>
</xsl:if>

</xsl:template>


<!--END MESSAGES-->

</xsl:stylesheet>
