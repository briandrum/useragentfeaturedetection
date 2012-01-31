# User Agent Feature Detection

* Version: 0.4
* Author: Brian Drum
* Release Date: 18 December 2011
* Requirements: Symphony 2.2.5

## Description

The User Agent Feature Detection extension makes information about user agent features available in the param pool for the purposes of responsive web design.

## How it works

On page load the extension checks for the presence of a cookie called `feature_detection`. If none is found (as on the first page request) the value of `data/params/feature-detection` is set to `0`. In the XSL template if the value of `data/params/feature-detection` is `0` a script block is written to the head of the page which creates a cookie called `feature_detection` with a value of `1` to prevent the script block being inserted in subsequent pages during this session.

For each feature test that has been enabled on System » Preferences, a unique param node is created. In the XSL template if a test’s param node is present a corresponding JavaScript block is written to the page containing a test that creates a cookie for that feature. On subsequent page loads the extension checks for the presence of those cookies and adds the values to the param pool. After all test have been run the page is immediately reloaded.

## Installation

1. Upload the `useragentfeaturedetection` folder in this archive to your Symphony `extensions` folder
2. Enable it by selecting “User Agent Feature Detection” on the System » Extensions page, choose “Enable/Install” from the “With Selected…” menu, then click “Apply”
3. On System » Preferences enable the tests you want to use and verify that `feature-detection` and any other test params are being included in your page XML
4. Add `user-agent-feature-detection.xsl` to Blueprints » Components » Utilities

## Usage

1. Import the feature detection utility it to your stylesheet: `<xsl:import href="../utilities/user-agent-feature-detection.xsl" />`
2. Call the feature detection utility early in the `<head>` of your HTML: `<xsl:call-template name="user-agent-feature-detection" />`
3. Define your image breakpoints in `user-agent-feature-detection.xsl` (default `[480, 600, 768, 1024, 1200]`). The array value just larger than `feature-screen-max` will be returned for use with [JIT images](http://symphony-cms.com/learn/concepts/view/jit-image-manipulation/). This restricts the number of sizes of images that are created and cached on your server.
4. Use the information contained in `/data/params/feature-…` to customize your layout or content. For example, you can use the value of `/data/params/feature-breakpoint` in your [JIT image](http://symphony-cms.com/learn/concepts/view/jit-image-manipulation/) source attribute to create [responsive images](http://unstoppablerobotninja.com/entry/responsive-images/): `<img src="{$root}/image/4/{data/params/feature-breakpoint}/0/1/path/to/image.jpg" />`

## Notes

With this release the screen dimensions (`integer`, in pixels) and orientation (`landscape`, `portrait`, or `unknown`) of the device is returned, along with a user defined breakpoint. Future versions may add additional feature detection.

## Changelog

* 0.4, 18 December 2011
  * Added `feature-breakpoint`
* 0.3, 1 December 2011
  * Changed `feature-maxwidth` to `feature-screen-max`
	* Added `feature-screen-min`
	* Added `feature-screen-orientation`
* 0.2, 29 November 2011
	* Add preference for default maxwidth
	* Move feature detection JavaScript to utility
	* Add ability to enable or disable individual tests
* 0.1, 28 November 2011
	* Initial release

## Credits

* Ethan Marcotte, for [Responsive Web Design](http://www.alistapart.com/articles/responsive-web-design/)
* Luke Wroblewski, for [RESS: Responsive Design + Server Side Components](http://www.lukew.com/ff/entry.asp?1392)
* Matt Wilcox, for [Adaptive Images in HTML](http://adaptive-images.com/)
* Matt Stauffer, for [Simple-RESS](https://github.com/jiolasa/Simple-RESS)
