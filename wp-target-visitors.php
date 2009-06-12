﻿<?php
/*
Plugin Name: Target Visitors
Plugin URI: http://www.getincss.ru/2008/07/13/wp-target-visitors/
Description: Показывает ваше специальное сообщение для пользователей пришедших с поисковых систем Google, Yandex, Mail, Yahoo, Liveinternet, Rambler, Altavista, Msn.
Author: Abanova Olga
Version: 1.1.1
Author URI: http://www.getincss.ru
*/
include_once 'functions.php';

if ( ! defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
      define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
      define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );


// Adding stylesheet in head
function target_visitors_head() {
  echo "<link rel=\"stylesheet\" href=\"".WP_PLUGIN_URL."/target-visitors/target-visitors.css\" type=\"text/css\" media=\"screen\" />\n";
}

function autosetfunc($content) {
	if(is_single()): 
		$wp_target_code = wp_target_visitors_auto ();
		$content=$wp_target_code.$content;
	endif;
	return $content;
}

//init on activate plugin
if (!function_exists('target_visitors_set')) {
    function target_visitors_set() {
        $text_code = "<div class=\"se_request\">Вы зашли на эту страницу по запросу: <a href=\"[PERMALINK]\"><b>[SE_REQUEST]</b></a>.<br />Нашли полезную информацию? Следить за новыми статьями вам поможет подписка на <a href=\"[RSS_URL]\"><b>RSS</b></a>.</div>";
		$autoset = '0';
		if(@$_POST['target_visitors_update']):
				update_option("text_code", $_POST['text_code']);
				update_option("autoset", $_POST['autoset']);
		else:
			if(!get_option("text_code") or !get_option("autoset"))
				add_option("text_code", $text_code);
				add_option("autoset", $autoset);
		endif;		
			
		add_action('wp_head','target_visitors_head');
    }
}

//adding options in admin menu
function target_visitors_add_pages() {
   add_options_page('Настройки Target Visitors', 'Target Visitors', 8, __FILE__, 'target_visitors_options_page');
}

//plugin options
function target_visitors_options_page() { 
	if (@$_POST['target_visitors_update']) {
	   if (empty($_POST['text_code']) or empty($_POST['css_code'])) {
			if (empty($_POST['text_code'])) {
				  $text_code = "";
				  update_option('text_code', $text_code);
				  $msg_status = "HTML код удален";
			}			
	
			if (empty($_POST['css_code'])){
				$filename = WP_PLUGIN_DIR."/target-visitors/target-visitors.css";
				  if (is_writable($filename)) {
						$css_open_file = fopen($filename, "w");					
						if (fwrite($css_open_file, $css_code) === FALSE) {
							$msg_status = "Ошибка записи в файл CSS";
							exit;
						}					
						fclose($css_open_file);						
						//remove_action('wp_head','target_visitors_head');
			      		$msg_status.="CSS код удален";
				   } else {
					   $msg_status = "CSS файл недоступен для записи";
					   exit;
				   }			      
			?>
            <div id="message" class="updated fade"><p><?=$msg_status?></p></div>
			<?
			}
		} else {	
			$text_code = stripcslashes($_POST['text_code']);
			update_option('text_code', $text_code);
			$msg_status = "Текст сохранен. ";
			$css_code = stripcslashes($_POST['css_code']);
			$filename = WP_PLUGIN_DIR."/target-visitors/target-visitors.css";
			  if (is_writable($filename)) {
					$css_open_file = fopen($filename, "w");					
					if (fwrite($css_open_file, $css_code) === FALSE) {
						$msg_status.="Ошибка записи CSS файла.";
						exit;
					}					
					fclose($css_open_file);						
					$msg_status.="CSS код сохранен.";
			   } else {
			   $msg_status.="CSS файл недоступен для записи. ";
			   }			 
		} 
		
		if ($_POST['autoset']) {
		  update_option('autoset', $_POST['autoset']);
		  $msg_status.="Автоматическое подключение функции включено";
		  add_filter('the_content', 'autosetfunc');
		} else {
			$msg_status.="Автоматическое подключение функции отключено";
		}
		
		?>
        <div id="message" class="updated fade"><p><?=$msg_status?></p></div>
		<?
	}
	
	else {
		// Fetch code from options
		$text_code = get_option('text_code');
		$text_code= stripcslashes($text_code);	
		$autoset = get_option('autoset');
		$filename = WP_PLUGIN_DIR."/target-visitors/target-visitors.css";
		  if (is_readable($filename)) {
				$css_open_file = fopen($filename, "r");
				$css_code = fread($css_open_file, filesize($filename));					
				fclose($css_open_file);						
		   } else {
		   $msg_status.="Css file is not readable.";
		   ?><div id="message" class="updated fade"><p><?=$msg_status?></p></div> <?
		   }		
	} 
?>
<div class="wrap">
     <h2>Target visitors</h2>
	  <div style="float:right; width:250px; border:solid 1px #ccc; padding:10px;">
        <h3 style="font-size:16px; background:#eee">Саппорт</h3>
        <p>Если у вас появились вопросы или идеи по использованию плагина, оставляйте ваши комментарии на домашней странице <a href="http://www.getincss.ru/2008/07/13/wp-target-visitors/">Target Visitors</a>.<br /><br />Вы также можете написать на мой электронный адрес webmaster(dog)getincss.ru<br /><br /><b>Понравился плагин?</b><br />Вы можете поддержать дальнейшую работу над ним. Webmoney:<br />Z102896061935<br />R144897054561</p>
        </div>
        <div style="margin-right:300px;">
            <p>Плагин "Target Visitors" позволяет вывести специальное сообщение для пользователей пришедших с поисковых систем Google, Yandex, Mail, Yahoo, Liveinternet, Rambler, Altavista, Msn. В тексте вы можете использовать следующие сокращения:<br />
            <br><b>[PERMALINK]</b> - URL текущей статьи, страницы, на которую зашел пользователь<br><br>
            <b style="color:red">[SE_REQUEST]</b> - тот самый поисковый запрос, по которому пришел пользователь<br><br>
            <b>[RSS_URL]</b> - адрес вашей RSS ленты<br><br>
            После сохранения данных, разместите следующий код:<br><b><code>&lt;? if(function_exists("wp_target_visitors")) wp_target_visitors(); ?&gt;</code></b><br> на станицах single.php, search.php, archive.php и других, где вы хотите показывать целевым посетителям свое сообщение.
            </p>                                
            <form name="form_target_visitors" method="post" action="<?=$_SERVER['REQUEST_URI']?>">
                    <p>Ваш текст:<br /><textarea name="text_code" id="text_code" cols="40" rows="10" style="width: 80%; font-size: 14px;" class="code"><?=stripslashes($text_code);?></textarea></p>
                    <p>CSS код (CSS файл в рабочей папке плагина должен быть доступен для записи):<br /><textarea name="css_code" id="css_code" cols="40" rows="10" style="width: 80%; font-size: 14px;" class="code"><?=stripslashes($css_code);?></textarea></p>
                    <p><input type="checkbox" name="autoset" value="1" <? if (get_option('autoset')=="1") echo "checked";?> /> Автоматически подключить функцию на страницу single.php</p>
            <p class="submit">
                <input type="submit" name="target_visitors_update" value="Сохранить код &raquo;" />
            </p>			
     </div>
</div>
<?    
}



function get_search_query_terms() {
	$query_array = array();
	if(@$_GET['s']):
		$se=$_GET['s'];
		while (ereg('%([0-9A-F]{2})',$se)){
			$val=ereg_replace('.*%([0-9A-F]{2}).*','\1',$se); 
			$newval=chr(hexdec($val)); 
			$se=str_replace('%'.$val,$newval,$se);
		}
		if (strstr($se,"+")) $se = str_replace("+"," ",$se);
		$query_array = explode(" ", $se);
	else:
		$se=getenv("HTTP_REFERER");		
		$se_array = array("?q="=>"3","&q="=>"3","text="=>"5","words="=>"6","ask="=>"4","&p="=>"3","?p="=>"3");	
		foreach ($se_array as $se_item=>$se_item_num):
			if(strstr($se,$se_item)):
				while (ereg('%([0-9A-F]{2})',$se)){
					$val=ereg_replace('.*%([0-9A-F]{2}).*','\1',$se); 
					$newval=chr(hexdec($val)); 
					$se=str_replace('%'.$val,$newval,$se);
				}
				$text_pos = strpos($se,$se_item)+$se_item_num;
				break;
			endif;
		endforeach;
		if($text_pos):
			$text_pos_amp = strpos($se,"&",$text_pos);
			if (!$text_pos_amp) $text_pos_amp=strlen($se);
			$se=substr($se,$text_pos,($text_pos_amp-$text_pos));			
			if (strstr($se,"+")) $se = str_replace("+"," ",$se);	
			if (!detect_utf($se)) $se = win_utf8($se);		
			$query_array = explode(" ", $se);
		else:
			$query_array=false;
		endif;
	endif;
	return $query_array;
}

function html_words_highlight($s)
{
	$query_array = get_search_query_terms();
	
	if($query_array!=false):
		$new_query_array=array();
		foreach ($query_array  as $term):
			$term2=utf8_to_unicode($term);
			if((strlen($term2)/6)>1):
				 $new_query_array[]=$term;
			endif;
		endforeach;
		$words=$new_query_array;
		
		$is_match_case = false;
		$tpl = '<span class="hightlite">%s</span>';
		#оптимизация для пустых значений
		if (! strlen($s) || ! $words) return $s;

    #оптимизация "Ту  134" = "Ту 134"
    #{{{
    $s2 = utf8_convert_case($s, CASE_LOWER);
    foreach ($words as $k => $word)
    {
        $word = utf8_convert_case(trim($word, "\x20\r\n\t*"), CASE_LOWER);
        if ($word == '' || strpos($s2, $word) === false) unset($words[$k]);
    }
    if (! $words) return $s;
    #}}}

    #d($words);
    #кеширование построения рег. выражения для "подсвечивания" слов в функции при повторных вызовах
    static $func_cache = array();
    $cache_id = md5(serialize(array($words, $is_match_case)));
    if (! array_key_exists($cache_id, $func_cache))
    {
        #буквы в кодировке UTF-8 для разных языков:
        static $re_utf8_letter = '#английский алфавит:
                                  [a-zA-Z]
                                  #русский алфавит (A-я):
                                  | \xd0[\x90-\xbf\x81]|\xd1[\x80-\x8f\x91]
                                  #+ татарские буквы из кириллицы:
                                  | \xd2[\x96\x97\xa2\xa3\xae\xaf\xba\xbb]|\xd3[\x98\x99\xa8\xa9]
                                  #+ турецкие буквы из латиницы (татарский латиница):
                                  | \xc3[\x84\xa4\x87\xa7\x91\xb1\x96\xb6\x9c\xbc]|\xc4[\x9e\x9f\xb0\xb1]|\xc5[\x9e\x9f]
                                  ';
        #регулярное выражение для атрибутов тагов
        #корректно обрабатывает грязный и битый HTML в однобайтовой или UTF-8 кодировке!
        static $re_attrs_fast_safe =  '(?> (?>[\x20\r\n\t]+|\xc2\xa0)+  #пробельные символы (д.б. обязательно)
                                           (?>
                                             #правильные атрибуты
                                                                            [^>"\']+
                                             | (?<=[\=\x20\r\n\t]|\xc2\xa0) "[^"]*"
                                             | (?<=[\=\x20\r\n\t]|\xc2\xa0) \'[^\']*\'
                                             #разбитые атрибуты
                                             |                              [^>]+
                                           )*
                                       )?';

        $re_words = array();
        foreach ($words as $word)
        {
            if ($is_mask = (substr($word, -1) === '*')) $word = rtrim($word, '*');

            $is_digit = ctype_digit($word);

            #рег. выражение для поиска слова с учётом регистра или цифр:
            $re_word = preg_quote($word, '/');

            #рег. выражение для поиска слова НЕЗАВИСИМО от регистра:
            if (! $is_match_case && ! $is_digit)
            {
                #для латинских букв
                if (preg_match('/^[a-zA-Z]+$/', $word)) $re_word = '(?i:' . $re_word . ')';
                #для русских и др. букв
                else
                {
                    $re_word_cases = array(
                        'lowercase' => utf8_convert_case($re_word, CASE_LOWER),  #word
                        'ucfirst'   => utf8_ucfirst($re_word),                   #Word
                        'uppercase' => utf8_convert_case($re_word, CASE_UPPER),  #WORD
                    );
                    $re_word = '(?>' . implode('|', $re_word_cases) . ')';
                }
            }

            #d($re_word);
            if ($is_digit) $append = $is_mask ? '(?>\d*)' : '(?!\d)';
            else $append = $is_mask ? '(?>' . $re_utf8_letter . ')*' : '(?! ' . $re_utf8_letter . ')';
            $re_words[$is_digit ? 'digits' : 'words'][] = $re_word . $append;
        }#foreach
        #d($re_words);

        if (! empty($re_words['words']))
        {
            #поиск вхождения слова:
            $re_words['words'] = '(?<!' . $re_utf8_letter . ')  #просмотр назад
                                  (' . implode("\r\n|\r\n", $re_words['words']) . ')   #=$m[3]
                                  ';
        }
        if (! empty($re_words['digits']))
        {
            #поиск вхождения цифры:
            $re_words['digits'] = '(?<!\d)  #просмотр назад
                                   (' . implode("\r\n|\r\n", $re_words['digits']) . ')   #=$m[4]
                                   ';
        }
        #d($re_words);

        $func_cache[$cache_id] = '/#встроенный PHP, Perl, ASP код:
                                   <([\?\%]) .*? \\1>

                                   #блоки CDATA:
                                   | <\!\[CDATA\[ .*? \]\]>

                                   #MS Word таги типа "<![if! vml]>...<![endif]>",
                                   #условное выполнение кода для IE типа "<!--[if lt IE 7]>...<![endif]-->":
                                   | <\! (?>--)?
                                         \[
                                         (?> [^\]"\']+ | "[^"]*" | \'[^\']*\' )*
                                         \]
                                         (?>--)?
                                     >

                                   #комментарии:
                                   | <\!-- .*? -->

                                   #парные таги вместе с содержимым:
                                   | <((?i:noindex|script|style|comment|button|map|iframe|frameset|object|applet))' . $re_attrs_fast_safe . '>.*?<\/(?i:\\2)>  #=$m[2]

                                   #парные и непарные таги:
                                   | <[\/\!]?[a-zA-Z][a-zA-Z\d]*' . $re_attrs_fast_safe . '\/?>
								   
                                   #html сущности:
                                   | &(?> [a-zA-Z][a-zA-Z\d]+
                                        | \#(?> \d{1,4}
                                              | x[\da-fA-F]{2,4}
                                            )
                                      );
                                   | ' . implode("\r\n|\r\n", $re_words) . '  #3 or 4
                                  /sx';
        #d($func_cache[$cache_id]);
    }
    $GLOBALS['HTML_WORDS_HIGHLIGHT_TPL'] = $tpl;
    $s = preg_replace_callback($func_cache[$cache_id], '_html_words_highlight_callback', $s);
    unset($GLOBALS['HTML_WORDS_HIGHLIGHT_TPL']);
	endif;
    return $s;
}

function _html_words_highlight_callback($m)
{
    foreach (array(3, 4) as $i)
    {
        if (array_key_exists($i, $m) && strlen($m[$i]) > 0)
        {
            //d($m);
            return sprintf($GLOBALS['HTML_WORDS_HIGHLIGHT_TPL'], $m[$i]);
        }
    }#foreach

    #пропускаем таги
    return $m[0];
}


//main plugin function
function wp_target_visitors_auto () {
	$text_code = "";
	$text_code = get_option('text_code');
	$text_code=stripcslashes($text_code);
	$terms_array = get_search_query_terms();
	if($terms_array!=false){
		$se="";
		foreach ($terms_array as $term) {
			$se.=$term." ";
		}
		$se=substr($se,0,(strlen($se)-1));
		$text_code = str_replace("[SE_REQUEST]",$se,$text_code);
		$rss_url = get_bloginfo('rss2_url');
		$text_code = str_replace("[RSS_URL]",$rss_url,$text_code);
		$permalink = get_bloginfo('siteurl').$_SERVER['REQUEST_URI'];			
		$text_code = str_replace("[PERMALINK]",$permalink,$text_code);
		return $text_code;
	}
		
}

function wp_target_visitors() {
	$text_code = wp_target_visitors_auto ();
	echo $text_code;
}
  
function hilite_head() {
	echo "
<style type='text/css'>
.hightlite {
	color: #fff;
	background-color: #f93;
}
</style>
";
}   

    
add_action('admin_menu', 'target_visitors_add_pages');
add_action('init', 'target_visitors_set');

add_filter('comment_text', 'html_words_highlight');
add_filter('the_content', 'html_words_highlight');
add_filter('the_excerpt', 'html_words_highlight');
add_filter('the_title', 'html_words_highlight');
add_action('wp_head', 'hilite_head');
if (get_option('autoset')=="1"): 
	add_filter('the_content', 'autosetfunc',1);
endif;
?>