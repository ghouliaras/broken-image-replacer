=== Broken Image Replacer ===
Contributors: ghouliaras
Tags: images, broken images, placeholder, performance, admin
Tested up to: 6.6
Requires at least: 5.4
Requires PHP: 7.2
Stable tag: 1.0.0
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Automatically detects and replaces broken images with a customizable placeholder to maintain a professional appearance.

== Description ==
A tiny, native plugin that listens for image load errors and swaps broken sources with your chosen placeholder (clearing srcset/sizes to avoid loops). Includes a simple settings page to pick a placeholder from the Media Library. Non-bloated, no front-end jQuery, and supports dynamically inserted images via MutationObserver.

== Installation ==
1. Upload the `broken-image-replacer` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Go to **Settings → Broken Image Replacer** to configure your placeholder

== Frequently Asked Questions ==
= How do I exclude an image? =
Add the attribute `data-bir-ignore="1"` to the `<img>` element.

== Changelog ==
= 1.0.0 =
* First release.
