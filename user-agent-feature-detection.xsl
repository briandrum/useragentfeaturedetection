<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template name="user-agent-feature-detection">
  <xsl:if test="data/params/feature-detection = 0">
    <xsl:if test="data/params/feature-maxwidth">
      <script>
        // Check maximum width of device
        document.cookie = 'feature_maxwidth=' + Math.round(Math.max(screen.width,screen.height) * ('devicePixelRatio' in window ? devicePixelRatio : 1)) + '; path=/';
      </script>
    </xsl:if>
    <script>
      // Prevent page from reloading again
      document.cookie = 'feature_detection=1; path=/';

      // If the feature detection cookie has been successfully set, reload the page
      if (document.cookie.indexOf('feature_detection=1') !=-1) location.reload(true);
    </script>
  </xsl:if>
</xsl:template>

</xsl:stylesheet>
