=== Simple Error Handler ===
Contributors: pkwooster
Donate link: http://devondev.com/wordpress/
Tags: debugging, development
Requires at least: 3.0
Tested up to: 3.8
Stable tag: 1.1

A simple plugin that reports the call stack trace when PHP errors occur.

== Description ==

This plugin allows developers to debug PHP errors. 

*Features for Developers*

* You can get call stack trace when PHP errors are triggered.
* This is particularly helpful in finding errors that are triggered by the WordPress deprecation and 
doing_it_wrong code.  These errors are reported in the WordPress core instead of at the location 
where the incorrect usage actually occurs. 
* You can set the error level from the Settings page, the default is trap Notice and Deprecation errors

*Additional Features*

There are no additional features supported by Simple Error Handler.  The code is simple, small and well documented, 
so you can use it as a starting point for your own error reporting or logging plugin.

== Installation ==

1. Use the Plugins, Add New menu in WordPress to install the plugin or upload the `simple-error_handler` folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. if you are currently unable to access the WordPress Admin pages due to a PHP error or warning, turn off debugging before attempting to install this plugin
and then turn it back on after the plugin is enabled.  

== Changelog ==

= 1.1 =
* Testing for WordPress 3.8 - new wp-admin interface

= 1.0 =
* First release.

= 1.0.1 =
* add two newlines at beginning of report to make top line visible on admin pages.

== Upgrade Notice ==
