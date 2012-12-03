<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="global.xsl" />
<xsl:import href="wrapper_main.xsl" />

<xsl:output method="html" indent="yes" />
<xsl:template match="resources">

    <h1><xsl:value-of select="//resources/resource[@class='story'][1]/title" /></h1>
    <br /><br />
    <script language="javascript">
      window.location='?c=view_story&amp;id=<xsl:value-of select="/page/request/story_id" />';
    </script>

</xsl:template>

</xsl:stylesheet>
