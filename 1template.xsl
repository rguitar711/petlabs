<?xml version ="1.0" ?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version ="1.0">

<xsl:output method="html"/>

<xsl:template match="/">

 <html>
<head>
<title>Wonders of the World</title>
</head>



<body> 


<h1>Wonderall</h1> 
<p align="center"><img src="herodotus. jpg" width="120"    height="171" /></p>  
<p>The famous Greek histori an     Herodotus wrote of seven great   archi tectural achievements. 
And      although hi s writings did not      survive, he planted seeds for   what has become the list of the   
  <strong>Seven Wonders of the  Ancient World</strong>.   </p>


<p>The <xsl:value-of select="ancient_wonders/wonder/name"/> is one of the wonders </p>

</body>

</html>


</xsl:template>



</xsl:stylesheet>
