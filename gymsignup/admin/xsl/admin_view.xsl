<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="global.xsl" />
<xsl:import href="admintools.xsl" />


<xsl:template match="resources">
	<xsl:apply-templates select="resource[1]" />
</xsl:template>


<xsl:template match="resource">
	<xsl:variable name="res"><xsl:value-of select="@class" /></xsl:variable>
	<div id="data">

		<table border="0" cellspacing="1">
			<tr class="tr_2">
				<td colspan="2"><span class="resourceclass"><xsl:value-of select="$res" /></span> Detail</td>
			
			</tr>
			<xsl:apply-templates select="child::*" />
			
			<tr>
				<td colspan="3">[<span><a href="#" ><xsl:attribute name="onClick">deleteConfirm('index.php?c=admin_delete&amp;res=<xsl:value-of select="$res" />&amp;id=<xsl:value-of select="id" />','<xsl:value-of select="$res" />');</xsl:attribute>delete</a></span>] [<span><a><xsl:attribute name="href">?c=admin_edit&amp;res=<xsl:value-of select="$res" />&amp;id=<xsl:value-of select="id" /></xsl:attribute>edit</a></span>] [<span><a><xsl:attribute name="href">?c=admin_browse&amp;res=<xsl:value-of select="$res" /></xsl:attribute>back to browse</a></span>]</td>
			</tr>
		</table>

	</div>	
</xsl:template>

<xsl:template match="resource/child::*">
			<tr>
				<td><xsl:value-of select="name()" />:</td>

				<td><xsl:value-of select="."/></td>
			</tr>
</xsl:template>

</xsl:stylesheet>
