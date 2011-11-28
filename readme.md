# User Agent Feature Detection

* Version: 0.1
* Author: Brian Drum
* Release Date: 28 November 2011
* Requirements: Symphony 2.2.5

## Description

The User Agent Feature Detection extension makes information about user agent features available in the param pool for the purposes of responsive web design.

## How it works

On page load the extension checks for the presence of a cookie called `feature_detection`. If none is found (as on the first page request) the value of `data/params/feature-detection` is set to `0`.

In the XSL template if the value of `data/params/feature-detection` is `0` a script block is written to the head of the page which:

1. Creates a cookie called `feature_detection` with a value of `1` to prevent the script block being inserted in subsequent pages during this session
2. Creates a second cookie called `feature_maxwidth` with a value of the device’s width or height – whichever is larger
3. Immediately reloads the page

## Installation

1. Upload the `useragentfeaturedetection` folder in this archive to your Symphony `extensions` folder
2. Enable it by selecting “User Agent Feature Detection” on the System » Extensions page, choose “Enable/Install” from the “With Selected…” menu, then click “Apply”
3. Verify that `feature-detection` and `feature-maxwidth` params are being included in your page XML

## Usage

1. Modify your XSL template to include the `<xsl:if test="data/params/feature-detection = 0">` portion of `master.xsl` file in this archive
2. Use the information contained in `/data/params/feature-`’s to customize your layout or content. For example, you can use the value of `/data/params/feature-maxwidth` in your [JIT image](http://symphony-cms.com/learn/concepts/view/jit-image-manipulation/) source attribute to create [responsive images](http://unstoppablerobotninja.com/entry/responsive-images/): `<img src="{$root}/image/4/{data/params/feature-maxwidth}/0/1/path/to/image.jpg" />`

## Notes

With this release only the maximum width of the device is returned. Future versions may add additional feature detection.

## Changelog

* 0.1, 28 November 2011
	* Initial release

## Credits

* Ethan Marcotte, for [Responsive Web Design](http://www.alistapart.com/articles/responsive-web-design/)
* Luke Wroblewski, for [RESS: Responsive Design + Server Side Components](http://www.lukew.com/ff/entry.asp?1392)
* Matt Wilcox, for [Adaptive Images in HTML](http://adaptive-images.com/)
* Matt Stauffer, for [Simple-RESS](https://github.com/jiolasa/Simple-RESS)
