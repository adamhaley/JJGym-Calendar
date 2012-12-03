<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="global.xsl" />
<xsl:import href="admintools.xsl" />

<xsl:output method="html" indent="yes" />


<xsl:template match="resources">

	<xsl:call-template name="adminform">
		<xsl:with-param name="node" select="resource[1]" />
		<xsl:with-param name="action">admin_save</xsl:with-param>

	</xsl:call-template>
</xsl:template>

</xsl:stylesheet>