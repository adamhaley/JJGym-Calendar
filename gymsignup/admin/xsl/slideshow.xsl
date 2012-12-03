<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="global.xsl" />

<xsl:output method="html" indent="yes" />

<xsl:template match="/">
<html>
<head>
<title>

</title>
<link rel="stylesheet" href="css/main.css" />

</head>
<body>
<center>
<xsl:apply-templates select="page/content/resources/resource[@class='story_photo'][id=/page/request/imageid]" />

<center>
 <xsl:call-template name="slideshowcontrols" />
</center>
<br /><br />
[<a href="#" onClick="window.close();">Close</a>]
</center>
</body>
</html>
</xsl:template>

<xsl:template match="resource[@class='story_photo']">
	<img src="images/{filename}" width="400" /><br />
	<center>
		<xsl:value-of select="caption" /><br />
		<em>Posted: <xsl:value-of select="time_posted" /></em>
	</center>
</xsl:template>
</xsl:stylesheet>
