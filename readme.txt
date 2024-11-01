=== Show Support Ribbon ===

Plugin Name: Show Support Ribbon
Plugin URI: https://perishablepress.com/show-support-ribbon/
Description: Displays a customizable "show support" ribbon, banner, or badge on your site.
Tags: badge, banner, button, ribbon, support
Author: Jeff Starr
Author URI: https://plugin-planet.com/
Donate link: https://monzillamedia.com/donate.html
Contributors: specialk
Requires at least: 4.6
Tested up to: 6.7
Stable tag: 20241010
Version:    20241010
Requires PHP: 5.6.20
Text Domain: show-support-ribbon
Domain Path: /languages
License: GPL v2 or later

Displays a customizable "show support" ribbon, banner, or badge on your site.



== Description ==

Show support for your favorite cause, event, charity, political event, or anything else that&rsquo;s awesome. Show Support Ribbon includes four built-in ribbon styles and makes it easy to customize with your own CSS. 

**Features**

* Plug-n-play functionality
* No configuration required
* Regularly updated and "future proof"
* Shortcode and template tag to display the ribbon anywhere
* Limit display of the ribbon to any URL(s)
* Choose one of four built-in ribbon styles
* Customize the ribbon with your own CSS
* Control the link text, link URL, and title text
* Includes copy/paste CSS recipes to customize the ribbon
* Includes option to restore default settings
* Super-slick toggling settings page
* Works with or without Gutenberg Block Editor

**Ribbon Styles**

Choose one of the following ways to display your ribbon:

* Badge
* Banner
* Ribbon
* Link
* Custom (any text/HTML/CSS)

Much more is possible via the Custom option, which enables you to add your own CSS for custom styling.

**Privacy**

This plugin does not collect or store any user data. It does not set any cookies, and it does not connect to any third-party locations. Thus, this plugin does not affect user privacy in any way.

Show Support Ribbon is developed and maintained by [Jeff Starr](https://twitter.com/perishable), 15-year [WordPress developer](https://plugin-planet.com/) and [book author](https://books.perishablepress.com/).

**Support development**

I develop and maintain this free plugin with love for the WordPress community. To show support, you can [make a donation](https://monzillamedia.com/donate.html) or purchase one of my books: 

* [The Tao of WordPress](https://wp-tao.com/)
* [Digging into WordPress](https://digwp.com/)
* [.htaccess made easy](https://htaccessbook.com/)
* [WordPress Themes In Depth](https://wp-tao.com/wordpress-themes-book/)
* [Wizard's SQL Recipes for WordPress](https://books.perishablepress.com/downloads/wizards-collection-sql-recipes-wordpress/)

And/or purchase one of my premium WordPress plugins:

* [BBQ Pro](https://plugin-planet.com/bbq-pro/) - Super fast WordPress firewall
* [Blackhole Pro](https://plugin-planet.com/blackhole-pro/) - Automatically block bad bots
* [Banhammer Pro](https://plugin-planet.com/banhammer-pro/) - Monitor traffic and ban the bad guys
* [GA Google Analytics Pro](https://plugin-planet.com/ga-google-analytics-pro/) - Connect WordPress to Google Analytics
* [Simple Ajax Chat Pro](https://plugin-planet.com/simple-ajax-chat-pro/) - Unlimited chat rooms
* [USP Pro](https://plugin-planet.com/usp-pro/) - Unlimited front-end forms

Links, tweets and likes also appreciated. Thank you! :)



== Installation ==

**Installation**

1. Upload the plugin to your blog and activate
2. Visit the settings to configure your options

[More info on installing WP plugins](https://wordpress.org/support/article/managing-plugins/#installing-plugins)

**Custom Markup**

Note: For the "Custom" markup option, you can use the following shortcodes to display related information:

	{{css_div}} = adds the CSS from the custom option, "CSS for <div>"
	{{css_a}}   = adds the CSS from the custom option, "CSS for <a>"
	{{url}}     = adds the URL from the option, "Link URL"
	{{title}}   = adds the title from the option, "Link title"
	{{text}}    = adds the text from the option, "Link text"


**Upgrades**

To upgrade Show Support Ribbon, remove the old version and replace with the new version. Or just click "Update" from the Plugins screen and let WordPress do it for you automatically.

__Note:__ uninstalling the plugin from the WP Plugins screen results in the removal of all settings from the WP database. 


**Restore Default Options**

To restore default plugin options, either uninstall/reinstall the plugin, or visit the plugin settings &gt; Restore Default Options.


**Uninstalling**

Show Support Ribbon cleans up after itself. All plugin settings will be removed from your database when the plugin is uninstalled via the Plugins screen.


**Like the plugin?**

If you like Show Support Ribbon, please take a moment to [give a 5-star rating](https://wordpress.org/support/plugin/show-support-ribbon/reviews/?rate=5#new-post). It helps to keep development and support going strong. Thank you!



== Upgrade Notice ==

To upgrade Show Support Ribbon, remove the old version and replace with the new version. Or just click "Update" from the Plugins screen and let WordPress do it for you automatically.

__Note:__ uninstalling the plugin from the WP Plugins screen results in the removal of all settings from the WP database. 



== Screenshots ==

1. Show Support Ribbon: Plugin Settings (panels toggle open/closed)

More screenshots available at the [SSR Homepage](https://perishablepress.com/show-support-ribbon/).



== Frequently Asked Questions ==

**Where do I place the image for the button? How do I include a graphic for the button?**

Images may be displayed using CSS. Upload the desired file and then display it using CSS, like so:

`background-image { url(/path/to/image.png) fixed no-repeat center top; }`

Fine-tune as needed to dial it in. To add via plugin settings, select "Custom" for the "Select your style" option and include for either `<div>` or `<a>` styles.


**What is the Targeted Display option?**

That setting enables you to limit the display of the ribbon to any specified URLs. So if you enter some URLs (separated by a comma), the plugin will display the ribbon only on those pages. Otherwise if no URLs are entered and the option is empty/blank, then the ribbon will be displayed on all pages on the site.


**How to override inline custom styles?**

First, you can customize any of the CSS/HTML for the "Custom" button option. For the other predefined options, you can override the default inline styles as follows:

To override the button's outer `<div>` tag:

`.show-support-ribbon[style] { font-size: 14px !important; }`

To override the button's inner `<a>` tag:

`.show-support-ribbon a[style] { font-size: 14px !important; }`

Then you can change the `font-size` to whatever properties are required.


**How to make a plain-text badge with no link?**

Select "Custom" for the option "Select your style". Then replace the "Markup" option with the following code:

`<div id="show-support-ribbon" class="show-support-ribbon" style="{{css_div}}">{{text}}</div>`

Actually you can customize the markup however you want. And as explained in the Installation section of these docs, you can use `{{css_div}}` and other shortcodes to display related information from the plugin options. Or you can just skip the shortcodes and add whatever text/markup is required.


**How to style the ribbon on mobile (small screens)?**

This can be done with a CSS `@media` query. Here is an example that you can add via the plugin settings:

	@media (max-width: 400px) {
		.show-support-ribbon[style] { right: 15px !important; top: 15px !important; }
	}

That will apply to screens up to 400px wide, so you can adjust to whatever is needed. You can add whatever styles you want. In the example, we're just moving the ribbon a little bit on the page. The `!important` declaration is needed only if overriding default styles.


**How to make a non-linked ribbon?**

By default, the message displayed in the ribbon/badge is linked. To change that to display the message only (with no link), follow these steps:

1) For the option, "Select your style" choose "Custom"

2) In the "Markup" setting that appears, replace whatever is there with this:

	<div id="show-support-ribbon" class="show-support-ribbon" style="{{css_div}}">{{text}}</div>

3) Then in the "CSS for div" setting, replace whatever is there with this:

	position:fixed;right:-60px;top:30px;z-index:9999;box-sizing:border-box;display:block;width:220px;padding:10px 0;color:#fff;background:rgba(102,153,204,.9);font-size:12px;line-height:16px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans',Geneva,Verdana,sans-serif;text-align:center;text-decoration:none;border:1px solid rgba(255,255,255,.7);transform:rotate(40deg);box-shadow:1px 1px 3px 0 rgba(0,0,0,.3);

Save changes and done. You may want to customize the CSS and/or other settings as desired. Results in a non-linked ribbon.


**Got a question?**

To ask a question, suggest a feature, or provide feedback, [contact me directly](https://plugin-planet.com/support/#contact).



== Changelog ==

If you like Show Support Ribbon, please take a moment to [give a 5-star rating](https://wordpress.org/support/plugin/show-support-ribbon/reviews/?rate=5#new-post). It helps to keep development and support going strong. Thank you!


**Version 20241010**

* Tests on WordPress 6.7


Full changelog @ [https://plugin-planet.com/wp/changelog/show-support-ribbon.txt](https://plugin-planet.com/wp/changelog/show-support-ribbon.txt)
