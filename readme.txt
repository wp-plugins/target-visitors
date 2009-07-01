=== Target Visitors ===
Contributors: Abanova Olga (www.getincss.ru)
Donate link: http://www.getincss.ru/
Tags: seo, target visitors, search engines, google, yandex, msn, yahoo, highlight words, highlight search, highlight, welcome visitors
Requires at least: 2.3.2
Tested up to: 2.8
Stable tag: 1.2.5

Plugin shows a special message to your blog's visitors, who coming from search engines (Google, Yandex, MSN, Yahoo, Mail.ru, Altavista, Liveinternet, Rambler) and highlight words (search engine request) in post, comments, title, tags and others.

== Description ==

Wanna attract more visitors and RSS readers? Plugin "Target Visitors" will help you to grow up your counters!

Plugin shows a special message to your blog's visitors, who coming from search engines (Google, Yandex, MSN, Yahoo, Mail.ru, Altavista, Liveinternet, Rambler) and highlight words (search engine request) in post, comments, title, tags and others.

It's really important to attract visitors attention. You can add any message to display it, for example:

> **Like this article? Follow my blog! (rss link here).** 

So, your visitors will be more interested to follow your blog updates and you will see how your rss counter growing up :)

**For Russian users:**

Плагин показывает специальное сообщение для пользователей пришедших с поисковых систем Google, Yandex, Mail, Yahoo, Liveinternet, Rambler, Altavista, Msn. Найденные слова подствечиваются (см. скриншоты)

[Домашняя страница плагина][]

[Домашняя страница плагина]:http://www.getincss.ru/2008/07/13/wp-target-visitors/

== Installation ==

1. Upload folder `target-visitors` to `/wp-content/plugins/` directory.
2. Activate the plugin `Target Visitors`.
3. Open Plugin options.  
4. "Message" field contain the message that will be display to your target visitors. Here you can use tags:

    **[PERMALINK]** - current page's URL

    **[SE_REQUEST]** - search engine request that user coming from

    **[RSS_URL]** - your RSS url 

5. Check if the css file writable in `/wp-content/plugins/target-visitors/` directory . If yes, change styles as you need for display message.
6. Tick the checkbox if you want to set up `wp_target_visitors` funcion automaticaly to your single.php page.
7. If you want to show message on another pages (like search.php, archives.php) place this code: `<? if(function_exists('wp_target_visitors')) wp_target_visitors(); ?>` in your templates.

== Frequently Asked Questions ==

> if you have questions about plugin, please, describe you problem [here][]
[here]: http://www.getincss.ru/wp-target-visitors_en/

== Screenshots ==

1. Here you can see how plugin options looks.
2. And on this screenshot you can see what your visitors will see.

== Features ==

1. It's easy way to attract you target visitors to subscribe you feed.
2. All found requests will be highlighting in title, content and comments text.
3. It's absolutely free :)

== Changelog ==

= 1.2.5 =
* Fixed russian lang.

= 1.2.1 =
* Fixed for WP 2.8, fixed bugs with BOM.

= 1.0 =
* First version