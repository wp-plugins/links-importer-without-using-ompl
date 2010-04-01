=== Links Importer Without Using Opml ===
Contributors: leebird
Donate link: none
Tags: links, import, no-opml
Requires at least: 2.8.5
Tested up to: 2.9.2
Stable tag: trunk

This plugin is a links import tool for blogs that doesn't support ompl output. 

== Description ==

This plugin is a links import tool for blogs that doesn't support ompl output. Though now WordPress already has the method to insert links from an opml file or URL conviniently, not all blogs would support the opml method and thus a more simple tool is necessary. I develop this tool for my personal need firstly, and now I want to make it more practical and hope more people can get some help from this tool.

== Installation ==

1. Upload the links_import_online.php to wp-admin/import/
2. Then login your blog, you will find the tool at tools/import named "Import Links Online"


== Frequently Asked Questions ==

= How to use it? =

1. Input the URL from which you want get links
2. Click on "get links", a list of links will be showed. 
3. Just choose which links you want to import and click on "add links". Then the links will be added.

= How to uninstall it? =

   Just delete it from wp-admin/import. In fact it does no changes to the database or other core codes.

= What does the option "Filter with the first word of domain name" mean? =

   This option means a filter for a better links list. Since the plugin get links through "fuzzy match" by using regular expression, the list may contain some links that are not you want. Anyway, if you are not sure whether to choose it, just leave it unticked and an entire links list will be showed.



== Changelog ==

= 1.0 =
* The first vesion of Links Importer Without Using Opml