<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <!-- import user-agent-feature-detection.xsl -->
  <xsl:import href="../utilities/user-agent-feature-detection.xsl" />
  <xsl:output method="html" omit-xml-declaration="yes" indent="no" />

  <xsl:template match="/">
    <xsl:text disable-output-escaping="yes">&lt;</xsl:text>!DOCTYPE html<xsl:text disable-output-escaping="yes">&gt;</xsl:text>
    <head>
      <!-- call user-agent-feature-detection template -->
      <xsl:call-template name="user-agent-feature-detection" />
      <style type="text/css">
        img {
          width: 100%;
        }
      </style>
    </head>
    <body>
      <h1>Values</h1>
      <ul>
        <li>data/params/feature-detection = “<xsl:value-of select="data/params/feature-detection" />”</li>
        <li>data/params/feature-screen-max = “<xsl:value-of select="data/params/feature-screen-max" />”</li>
        <li>data/params/feature-screen-min = “<xsl:value-of select="data/params/feature-screen-min" />”</li>
        <li>data/params/feature-breakpoint = “<xsl:value-of select="data/params/feature-breakpoint" />”</li>
        <li>data/params/feature-screen-orientation = “<xsl:value-of select="data/params/feature-screen-orientation" />”</li>
      </ul>
      <p>
        <img src="{$root}/image/4/{data/params/feature-breakpoint}/0/1/farm5.staticflickr.com/4107/5001563671_98a40b9606_o.jpg" />
      </p>
    </body>
  </xsl:template>

</xsl:stylesheet>
