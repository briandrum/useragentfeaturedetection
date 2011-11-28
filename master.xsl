<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:output method="html" omit-xml-declaration="yes" indent="no" />

<xsl:template match="/">

  <xsl:text disable-output-escaping="yes">&lt;</xsl:text>!DOCTYPE html<xsl:text disable-output-escaping="yes">&gt;</xsl:text>

  <head>
    <xsl:if test="data/params/feature-detection = 0">
      <script>
        document.cookie='feature_detection=1, feature_maxwidth=' + Math.round(Math.max(screen.width,screen.height) * ('devicePixelRatio' in window ? devicePixelRatio : 1)) + '; path=/';
        if (document.cookie.indexOf('feature_detection=1') !=-1) location.reload(true);
      </script>
    </xsl:if>
    <style type="text/css">
      img {
        width: 100%;
      }
    </style>
  </head>

  <body>
    <h1>
      maxwidth = “<xsl:value-of select="data/params/feature-maxwidth" />”
    </h1>
    <p>
      <img src="{$root}/image/4/{data/params/feature-maxwidth}/0/1/farm5.staticflickr.com/4107/5001563671_98a40b9606_o.jpg" />
    </p>
  </body>

</xsl:template>

</xsl:stylesheet>
