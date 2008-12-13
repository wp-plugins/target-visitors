=== Target Visitors ===
Contributors: Abanova Olga
Donate link: http://www.getincss.ru/
Tags: seo, target visitors, search engines, google, yandex, msn, yahoo
Requires at least: 2.3.2
Tested up to: 2.7
Stable tag: 1.1.1

Plugin shows a special message for users coming from search engines like Google, Yandex, MSN, Yahoo, etc.

== Description ==

Plugin shows a special message(s) to your blog's visitors, who coming from search engines (Google, Yandex, MSN, Yahoo, Mail.ru, Altavista, Liveinternet, Rambler).
It's really important to attract visitors attention. You can add any message to display it, for example "Like this article? Follow my blog! (rss link here)". So, you visitors will be more interested to follow your blog updates and you will see how your rss counter growing up.


== Installation ==

1. Upload folder `wp-target-visitors` to `/wp-content/plugins/` directory.
2. Activate the plugin `Target Visitors`.
3. Open Plugin options.  
4. "Message" area is message that will be display to your target visitors. Here you can use tags:

    **[PERMALINK]** - current page's URL

    **[SE_REQUEST]** - search engine request that user coming from

    **[RSS_URL]** - you RSS url 

5. Check if the css file in `/wp-content/plugins/wp-target-visitors/` directory writable. If yes, change styles as you need for display message.
6. Tick the checkbox if you want to set up `wp_target_visitors` funcion automaticaly to your single.php page.
7. If you want to show message on another pages (like search.php, archives.php) place this code: `&lt;? if(function_exists('wp_target_visitors')) wp_target_visitors(); &gt;` in your templates.

== Frequently Asked Questions ==

> I have a question about your plugin

> > Please, describe you problem [here][]
[here]: http://www.getincss.ru/wp-target-visitors_en/

== Screenshots ==

1. Here you can see how plugin options looks.
2. And on this screen shot you can see what your visitors will see.

== Features ==

1. It's easy way to attract you target visitors to subscribe you feed.
2. All found requests will be highlighting in title, content and comments text.
3. It's absolutely free :)
