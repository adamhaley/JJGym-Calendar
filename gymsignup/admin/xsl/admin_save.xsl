<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:import href="admin_view.xsl" />

<xsl:template match="resources">
	<xsl:apply-templates select="resource[1]" />
</xsl:template>


</xsl:stylesheet>
