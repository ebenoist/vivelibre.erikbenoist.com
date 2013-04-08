=== KB Countdown Widget ===
Contributors: adamrbrown
Donate link: http://adambrown.info/b/widgets/donate/
Tags: widget, time, fun, age, date, countdown, graph, timer, count, post
Requires at least: 2.0
Tested up to: 2.5
Stable tag: trunk

Displays years/months/days since, until, or between events. Great for tracking a pregnancy (with a bar graph!), time until an election, or whatever. Use as widget, in template, or in a page/post.

== Description ==

Ever wanted to track a pregnancy, or the time until the next elections, or your baby's precise age, or something else that will surely fascinate all your readers? Maybe you even wanted a cool bargraph showing how far you've progressed between two dates? Introducing KB Countdown, which does just that. You give it a start date, an end date, or both. You then write in a message like this:

> Janelle will have the baby in TIME\_UNTIL!

In your sidebar (or anywhere else you choose to put it), visitors see this:

> Janelle will have the baby in 3 months and 4 days!

You can use a single date, or you can read dates in automatically from an iCal file. Years, months, and days will automatically show up as either singular or plural (in any language, not just in English).

Though there are a few other count down plugins out there, KB Countdown was created to give you much greater control over how your counter looks. It also lets you count either up or down. You can see examples in the sidebar at the [KB Countdown plugin page](http://adambrown.info/b/widgets/category/kb-countdown/).

This plugin was originally only a widget, but can now be used either as a widget, in a page/post, or anywhere in your template. For non-widget uses, see instructions in the download. For widget uses, you need to be using either WP v2.2+ or the [Wordpress sidebar widgets plugin](http://wordpress.org/extend/plugins/widgets/).

= Basic Features =

* You can use the time tags (like TIME\_UNTIL and TIME\_SINCE) in either the widget's title or in its text.
* Use iCal data (e.g. Google Calendar) if you want
* Easy to localize (i.e. use on non-English sites).
* As with the RSS and text widgets, you can have up to 9 KB Countdown widgets. (If you are using the plugin in your template or in a page/post, you can have an unlimited number of countdowns.)
* You can customize the width, height, border size, and colors of the bargraph (if you choose to use one).
* You can track any date within 2,147,483,648 years of today. To use bargraphs, your dates must be no more than 2,147,483,648 years apart. Probably not a problem unless you're a paleogeologist.
* Standard tags you can use: TIME\_UNTIL, TIME\_SINCE, PERCENT\_DONE, BARGRAPH.
* Safe for WP-MU installations. Users cannot put script or anything into their message; their countdown message is scrubbed the same way that text widgets are.

= Support =

Be advised: **If you post your support questions as comments below, I probably won't see them.** If the FAQs don't answer your question, you can post support questions at the [KB Countdown plugin page](http://adambrown.info/b/widgets/category/kb-countdown/) on my site.

== Installation ==

To use this plugin as a widget (recommended), you must have either Wordpress v2.2+ or the Sidebar Widgets plugin installed and running.

1. Upload `kb_countdown.php` and `kb_countdown\kb_countdown_bargraph.php` (preserving directory structure) to the `/wp-content/plugins/` directory. The second file is necessary only if you want to use the bargraph feature.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. To use as a widget, add the new KB Countdown widget to your sidebar through the `Presentation (or Design) => Widgets` menu in WordPress. You'll find that the widget has several options, but only the first couple are required. If you want more (up to 9) KB Countdown widgets, scroll down and increase the allotment, just like you would with text or RSS widgets.

You don't have to use this as a widget; you can also use it in a page/post or in your template. To do so, read the instructions in `kb_countdown.php`. Note that this is an advanced use and will require moderate familiarity with PHP.

If you plan to use iCal data, you will also need to have the [iCal Events plugin](http://wordpress.org/extend/plugins/ical-events/) activated.

= Support =

Be advised: **If you post your support questions as comments below, I probably won't see them.** If the FAQs don't answer your question, you can post support questions at the [KB Countdown plugin page](http://adambrown.info/b/widgets/category/kb-countdown/) on my site.

== Screenshots ==

You can see examples in the sidebar at the [KB Countdown plugin page](http://adambrown.info/b/widgets/category/kb-countdown/).

== Frequently Asked Questions ==

= It doesn't work!! =

As of v3.0 of the plugin, you MUST be running PHP 5 or higher. If you are using PHP 4 (or older), you need to use v2.3.4 of the plugin. You can get this older version at the [download page](http://wordpress.org/extend/plugins/kb-countdown-widget/download/).

= What code do I need to place in my sidebar? =

None, this is a widget. If you are using pre-WP v2.2, you'll need to have WP the [sidebar widgets plugin](http://wordpress.org/extend/plugins/widgets/) running. You also need to be using a widgetized theme. You can control all options for KB Countdown from the widgets administration menu.

If you want to use this plugin in a post/page or in your template somewhere, look in `kb_countdown.php` for instructions.

= Do I need to specify both a start and an end date? =

No. You need to specify only a start date or an end date. But if you want to have a bargraph, you need to specify both.

= What happens if I give the program an invalid date? =

If your start date hasn't happened yet or your end date has already passed, PERCENT\_DONE will return 0 or 100 (respectively) and TIME\_SINCE/TIME\_UNTIL will say "0 days."

= Exactly what tags can I include in my message? =

* Standard tags you can use: TIME\_UNTIL, TIME\_SINCE, PERCENT\_DONE, BARGRAPH. The latter two require that you specify both a start and an end date.
* Additional tags for power users: YEARS\_UNTIL, YEARS\_SINCE, MONTHS\_UNTIL, MONTHS\_SINCE, DAYS\_UNTIL, DAYS\_SINCE.
* A note about the additional tags for power users. If your event is 1 year, 2 months, and 4 days away, then DAYS\_UNTIL will return 4, MONTHS\_UNTIL returns 2, and YEARS\_UNTIL returns 1. Note that DAYS\_UNTIL will not return 429 (or whatever it is); use TOTAL\_DAYS\_UNTIL or TOTAL\_DAYS\_SINCE instead.
* In most cases, you'll do better sticking with the four standard tags, not the additional tags for power users. Why? Because TIME\_UNTIL and TIME\_SINCE will make "year," "month," and "day" plural or singular as needed. Also, these two standard tags will drop the "years" bit entirely if it's less than one year until/since your date. But you might want the additional tags if you're using a language with unusual singular/low-plural/high-plural grammar, like Russian, or if you don't want words to follow the numbers immediately.

= How do I change the colors in the bargraph? =

Override the default bargraph colors using the same red-green-blue system employed in CSS files, with one change. Instead of writing in hex (e.g. #ff00ff) write numerals between 0 and 255, separated by commas without spaces (e.g. 255,0,255). Even if you aren't familiar with this system, you can probably find colors that you like by just tinkering with the numbers. The first number gives you more red, the second is green, the third is blue. Red, for example, will be 255,0,0. And for gray, set all three numbers equal (e.g. 100,100,100).

= The program isn't finding the bargraph URI correctly =

You may override this manually. Look at the top of the kb_countdown.php file for a setting.

= Can I Enter in Multiple Dates? =

Only if you use an iCal file. Read on...

= Can I use an iCal file? =

Absolutely, as of version 3.1 of the plugin. You will also need the [iCal Events plugin](http://wordpress.org/extend/plugins/ical-events/) installed and activated, since it does the iCal processing. From the widget's control panel, look for a button that says "multi-date mode."

In iCal mode, you can only count down (using the _UNTIL tags), not up (with the _SINCE tags), and you can't use any bargraphs.

In addition to the counting tags discussed above, you can also use the following event tags: SUMMARY, DESCRIPTION, LOCATION, MONTH, DATE, YEAR. These tags will be replaced with corresponding information from the iCal file. Usually, SUMMARY is the event's title. An example of what you could write in the "message" box:

> SUMMARY (MONTH-DATE-YEAR) will happen in TIME_UNTIL.

Which might produce something like this:

> Halloween (10-31-2007) will happen in 4 months and 7 days.

Fiddle around with it, you'll figure it out.

= My iCal file isn't being read right =

Contact the [iCal Events plugin](http://wordpress.org/extend/plugins/ical-events/) people.

= I have a question that isn't addressed here. =

You may ask questions by posting a comment to the [KB Countdown plugin page](http://adambrown.info/b/widgets/category/kb-countdown/).

= Support =

Be advised: **If you post your support questions as comments below, I probably won't see them.** If the FAQs don't answer your question, you can post support questions at the [KB Countdown plugin page](http://adambrown.info/b/widgets/category/kb-countdown/) on my site.