=== Simple Links Importer ===
Contributors: leebird
Tags: links, import, no-opml, importer, link, links import, import links
Requires at least: 2.8.5
Tested up to: 2.9.2
Stable tag: 1.1

A links import tool for all blogs. 

== Description ==

= I'm not maintaining this tool anymore. Please don't download it because it's outdated and won't be compatible with the latest WordPress versions. =

This plugin is a links import tool for blogs that doesn't support ompl output. Though now WordPress already has the method to insert links from an opml file or URL conviniently, not all blogs would support the opml method and thus a simpler tool is necessary. I developed this tool for my personal need firstly, and now I want to make it more practical and hope more people can get some help from it.

== Installation ==

1. Upload the links_import_online.php to wp-admin/import/

2. Login your blog, you will find it at tools/import named "Import Links Online"


== Frequently Asked Questions ==

= How to use it? =

1. Input the URL from which you want get links
2. Click on "get links", a list of links will be showed. 
3. Just choose which links you want to import and click on "add links". Then the links will be added.

= How to uninstall it? =

Just delete it from wp-admin/import. In fact it does no changes to the database or other core codes.

= What does the option "Links Filter" mean? =

This option means a filter for a better links list. Since the plugin get links through "fuzzy match" by using regular expression, the list may contain some links you don't need. Anyway, if you are not sure, just leave it unticked and an entire list will be showed.

== Changelog ==

= 1.1 =
* Improve UI
* Improve links filter

= 1.0 =
Initial release of Simple Links Importer
