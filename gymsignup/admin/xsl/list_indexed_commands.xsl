<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
<xsl:variable name="resourcepath" select="/page/content/resources" />
<xsl:for-each select="$resourcepath/resource[@class='auth_module']">
	<xsl:variable name="id"><xsl:value-of select="id_auth_module" /></xsl:variable>
	<b><xsl:value-of select="name" /></b><br />
		<xsl:for-each select="$resourcepath/resource[@class='command_index'][id_auth_module=$id]">
			<xsl:value-of select="name" /><br />
		</xsl:for-each>
	<br />
</xsl:for-each>
</xsl:template>
</xsl:stylesheet>
