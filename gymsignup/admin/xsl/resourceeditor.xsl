<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="resource[1]">

	<xsl:apply-templates select="child::*" />
	
</xsl:template>

<xsl:template match="resource[1]/child::*[edit='1']">
<xsl:variable name="oneofmany"></xsl:variable>
<div class="dinput">
	  <xsl:choose>
	    <xsl:when test="datatype = 'oneofmany'">
	      <select id="{name()}_generic">
		<option>--</option>
	      </select>
	    </xsl:when>
	    <xsl:otherwise>
	      <input type="text" id="{name()}_generic" name="{name()}" value="{value}" />
	    </xsl:otherwise>
	  </xsl:choose>
	  <div id="{name()}" name="{name()}" TABINDEX="100" style="display:none;">
	    <xsl:choose>
	      <xsl:when test="/page/request/id = 1">--</xsl:when>
	      <xsl:when test="/page/request/id">
			<xsl:if test="value = ''">--</xsl:if>
			<xsl:value-of select="value" />
	      </xsl:when>
	      <xsl:otherwise>--</xsl:otherwise>
	    </xsl:choose>
	  </div>
	  <script>
	    // if the browser has javascript, use that instead of generic forms
	    document.getElementById('<xsl:value-of select="name()" />_generic').style.display = 'none';
	    document.getElementById('<xsl:value-of select="name()" />').style.display = 'block';
	  </script>
	</div>
	<br />
	<script>
	  var prop = '<xsl:value-of select="name()" />';

	  new Ajax.InPlaceEditor($('<xsl:value-of select="name()" />'), queryString + prop, {
	      <xsl:if test="datatype = 'date'">
			date: true,
	      </xsl:if>
	      <xsl:if test="datatype = 'oneofmany'">
		  
			dropDown: [<xsl:value-of select="$oneofmany" />],
	      </xsl:if>
	      	ajaxOptions: {method: 'get'} //override so we can use a static for the result
	      });
	</script>
</xsl:template>

<xsl:template match="resource[1]/child::*[edit='0'][view='1']">
	<label for="{name()}"><xsl:value-of select="name()" />:</label>
	<div class="dinput">
	  <div id="{name()}" name="{name()}">
	    <xsl:value-of select="value" /> 
	  </div>
	</div>
	<br />
</xsl:template>

</xsl:stylesheet>
