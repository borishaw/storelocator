<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="/">
		<div class="infoWindow" style="white-space:nowrap;min-width:200px">
		    <xsl:apply-templates/>
		</div>
	</xsl:template>
	<xsl:template match="info">
	<!-- This is the info window for all the markers in the Joomla database -->
     <p>
		<b><xsl:value-of select="name"/></b>
		<br /><xsl:value-of select="address"/>
		<br /><xsl:value-of select="city"/>, <xsl:value-of select="state"/><xsl:text> </xsl:text><xsl:value-of select="zipcode"/>
     </p>
	</xsl:template>
	<xsl:template match="Result">
	<!-- This is the info window for all the Yahoo Local Search component -->
     <p>
	    <xsl:choose>
		<xsl:when test="BusinessUrl">
           <a>
               <xsl:attribute name="href">
		            <xsl:value-of select="BusinessUrl"/>
		        </xsl:attribute>
               <b><xsl:value-of select="Title"/></b>
           </a>
       </xsl:when>
       <xsl:otherwise>
               <b><xsl:value-of select="Title"/></b>
       </xsl:otherwise>
       </xsl:choose>
       <br /><xsl:value-of select="Address"/>
       <br /><xsl:value-of select="City"/>, <xsl:value-of select="State"/>
       <br /><xsl:value-of select="Phone"/>
		</p>
	</xsl:template>
	<!-- Here are some common things you can do in your info window 

		Adding Driving Directions

		1. 1. Add the following code into the info template where you want the driving directions:

		<br /><br />
		<form action="http://maps.google.com/maps" method="get" target="_blank">
		<i>Your address</i>: <br /><input type="text" name="saddr" size="20" /><br />
		<input type="hidden" name="daddr"><xsl:attribute name="value"><xsl:value-of select="address"/><xsl:text>, </xsl:text><xsl:value-of select="city"/>, <xsl:value-of select="state"/><xsl:text> </xsl:text><xsl:value-of select="zipcode"/></xsl:attribute></input>
		<input type="submit" value="Directions"/></form><br />

      ::::::::::::::::::::::::::::::::::

		Adding HTML into the Info Window

	1. Put the HTML you want added into the misc field of the marker
	2. add the following line into the info template where you want this HTML to go: <xsl:copy-of select="misc" />

	-->

</xsl:stylesheet>