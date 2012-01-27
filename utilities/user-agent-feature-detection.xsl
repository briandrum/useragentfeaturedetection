<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template name="user-agent-feature-detection">
  <xsl:if test="data/params/feature-detection = 0">
    <xsl:if test="data/params/feature-screen-max">
      <script>
        <!-- Check max of screen -->
        document.cookie = 'feature_screen_max=' + Math.round(Math.max(screen.height,screen.width) * ('devicePixelRatio' in window ? devicePixelRatio : 1)) + '; path=/';
      </script>
    </xsl:if>
    <xsl:if test="data/params/feature-screen-min">
      <script>
        <!-- Check min of screen -->
        document.cookie = 'feature_screen_min=' + Math.round(Math.min(screen.height,screen.width) * ('devicePixelRatio' in window ? devicePixelRatio : 1)) + '; path=/';
      </script>
    </xsl:if>
    <xsl:if test="data/params/feature-breakpoint">
      <script>
        <!-- Set breakpoints for JIT images -->
        var b = function() {
          var a = [480, 600, 768, 1024, 1200],
              s = Math.round(Math.max(screen.height,screen.width) * ('devicePixelRatio' in window ? devicePixelRatio : 1));
          for (i in a) if (a[i] >= s) return a[i]; return a.pop();
        }();
        document.cookie = 'feature_breakpoint=' + b + '; path=/';
      </script>
    </xsl:if>
    <xsl:if test="data/params/feature-screen-orientation">
      <script>
        <!-- Check orientation of screen -->
        document.cookie = 'feature_screen_orientation=' + (window.orientation === 0 ? 'portrait' : (window.orientation === 90 ? 'landscape' : 'unknown')) + '; path=/';
      </script>
    </xsl:if>
    <script>
      <!-- Prevent page from reloading again -->
      document.cookie = 'feature_detection=1; path=/';

      <!-- If the feature detection cookie has been successfully set, reload the page -->
      if (document.cookie.indexOf('feature_detection=1') !=-1) location.reload(true);
    </script>
  </xsl:if>
</xsl:template>

</xsl:stylesheet>
