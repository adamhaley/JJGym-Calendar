<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="global.xsl" />
<xsl:import href="admintools.xsl" />

<xsl:template match="content">
<div id="content">
<xsl:call-template name="adminform" >
	<xsl:with-param name="node" select="resources/resource[1]" />
	<xsl:with-param name="action">save</xsl:with-param>

</xsl:call-template>
</div>
</xsl:template>

</xsl:stylesheet>
