<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="global.xsl" />
<xsl:import href="admintools.xsl" />

<xsl:output method="html" indent="yes" />


<xsl:template match="resources">
	<xsl:apply-templates select="resource[1]" />
</xsl:template>

<xsl:template match="resource">
	<form method="post"><xsl:attribute name="action">index.php?action=admin_browse&amp;res=<xsl:value-of select="//resources/resource[1]/@class" /></xsl:attribute>
	

		<table border="0" cellspacing="1">
			<tr>
				<td colspan="2" class="tr_2">Search</td>

			</tr>
		<xsl:apply-templates select="child::*[@edit='1']" />
			<tr>
				<td>
					<xsl:attribute name="colspan"><xsl:value-of select="count(child::*[@edit=1])" /></xsl:attribute>
					<p><input type="submit" name="submit" value="Submit" /></p>

				</td>
			</tr>
		</table>
	</form>
</xsl:template>

<xsl:template match="resource/child::*">
	<tr>
					<td><xsl:value-of select="name()" />:</td>
					
					
					<td>
					<xsl:choose>
							<xsl:when test="@datatype = 'oneofmany'">
							
								<xsl:variable name="classname"><xsl:value-of select="name()" /></xsl:variable>
								<xsl:call-template name="dropdown">
									<xsl:with-param name="nodeset" select="/page/content/resources/resource[@class=$classname]" />
									<xsl:with-param name="namefield">name</xsl:with-param>
									<xsl:with-param name="valuefield">id</xsl:with-param>
									<xsl:with-param name="fieldname"><xsl:value-of select="$classname" /></xsl:with-param>
									<xsl:with-param name="selectedvalue"></xsl:with-param>
									<xsl:with-param name="searchform">1</xsl:with-param>
								</xsl:call-template>
							</xsl:when>
							<xsl:otherwise>
					
								<input type="text" size="40">
									<xsl:attribute name="name"><xsl:value-of select="name()" /></xsl:attribute>
									<xsl:attribute name="value"></xsl:attribute>
								</input>
							</xsl:otherwise>
						</xsl:choose>
					
					

					</td>
				</tr>	


</xsl:template>


</xsl:stylesheet>