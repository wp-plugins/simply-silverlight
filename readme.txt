=== Simply Silverlight ===
Contributors: david_wp
Author URI: http://www.digitalwindfire.com
Donate link: http://www.digitalwindfire.com/software/simply-silverlight/donate
Tags: silverlight, microsoft
Requires at least: 3.0
Tested up to: 3.4.2
Stable tag: 1.0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Simply Silverlight is a plugin for deploying Silverlight content in WordPress websites.

== Description ==

Bring the power of Microsoft's visually rich Silverlight technology to your WordPress site today! Simply Silverlight makes deploying Silverlight .xap files to your WordPress blog's posts and pages incredibly easy and intuitive. With its sensible default configuration, you'll be up-and-running with Silverlight in no time at all.

Features:

* Easy-to-use administration menu makes configuration a snap.
* Outputs correct HTML markup for Silverlight versions 3, 4 and 5.
* Easily customize the HTML OBJECT (Width, Height and Background) and DIV (Float, Display and Style) tags.
* Supports Silverlight-specific attributes: autoupgrade, onerror and initparams.
* Protect Silverlight applications from being downloaded by unauthorized users.
* Familiar WordPress shortcode can override any global setting for a given instance.
* Translation-ready (i18n) . Portable Object Template (.POT) file included.

= Donations =

Say thanks and encourage future development by [__making a donation__](http://www.digitalwindfire.com/software/simply-silverlight/donate). Thanks a lot!

== Installation ==

1. Install automatically through the `Plugins`, `Add New` menu in WordPress, or upload the `simply-silverlight` folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the `Plugins` menu in WordPress. Look for the `Simply Silverlight` link to configure the settings.
1. Add the shortcode `[simply-silverlight xap=filename.xap]` to any post or page.
1. Updates are automatic. Click on "Upgrade Automatically" if prompted from the admin menu. If you ever have to manually upgrade, simply deactivate, uninstall, and repeat the installation steps with the new version.

== Frequently Asked Questions ==

= Is this plugin available in other languages? =

Not yet. Currently it's only available in English. However, the plugin is ready to be translated. It includes the Portable Object Template (.POT) file needed to make translations. If you would like to translate the plugin into another language, please do so. You may send the translation files to support@digitalwindfire.com and I'll include them in the next release. Thank you for your assistance.

== Screenshots ==

1. The main settings menu (Top).
1. The main settings menu (Bottom).

== Changelog ==

= 1.0.3 =
- FIXED: Silverlight applications won't display when used with Secure Path on some web hosts.

= 1.0.2 =
- FIXED: Settings page displays empty fields on some web hosts.
- FIXED: Clarified error messages with Secure Path access.
- ADDED: Ability to restore default Secure Path without changing other settings.

= 1.0.1 =
- ADDED: Ability to restrict access to Silverlight apps authorized users only.
- ADDED: Silverlight 5 version number included in global settings.

= 1.0 =
- (18 Sep 2011) Initial Release

== Upgrade Notice ==
= 1.0.3 =
This version fixes a bug that prevents Silverlight applications from displaying when using the Secure Path on some web hosts. Please upgrade immediately!

= 1.0.2 =
This version fixes a bug that could cause all settings values to be displayed as empty fields and they cannot be set or reset on some web hosts. Please upgrade immediately!

= 1.0.1 =
This version of Simply Silverlight allows administrators who want to allow only specific users and roles to access their Silverlight apps the granular authentication they've been looking for. Don't delay, upgrade today!
