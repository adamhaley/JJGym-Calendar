<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="global.xsl" />
<xsl:import href="wrapper_main.xsl" />

<xsl:template match="content">

<script language="javascript">
	window.location='?c=browse&amp;res=<xsl:value-of select="/page/request/res" />';
</script>

</xsl:template>

</xsl:stylesheet>
