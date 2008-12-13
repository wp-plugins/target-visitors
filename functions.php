<?
function detect_utf($Str) {
 for ($i=0; $i<strlen($Str); $i++) {
  if (ord($Str[$i]) < 0x80) $n=0; # 0bbbbbbb
  elseif ((ord($Str[$i]) & 0xE0) == 0xC0) $n=1; # 110bbbbb
  elseif ((ord($Str[$i]) & 0xF0) == 0xE0) $n=2; # 1110bbbb
  elseif ((ord($Str[$i]) & 0xF0) == 0xF0) $n=3; # 1111bbbb
  else return false; # Does not match any model
  for ($j=0; $j<$n; $j++) { # n octets that match 10bbbbbb follow ?
   if ((++$i == strlen($Str)) || ((ord($Str[$i]) & 0xC0) != 0x80)) return false;
  }
 }
 return true;
}

function win_utf8 ($in_text){
$output="";
$other[1025]="Ё";
$other[1105]="ё";
$other[1028]="Є";
$other[1108]="є";
$other[1030]="I";
$other[1110]="i";
$other[1031]="Ї";
$other[1111]="ї";

for ($i=0; $i<strlen($in_text); $i++){
if (ord($in_text{$i})>191){
  $output.="&#".(ord($in_text{$i})+848).";";
} else {
  if (array_search($in_text{$i}, $other)===false){
   $output.=$in_text{$i};
  } else {
   $output.="&#".array_search($in_text{$i}, $other).";";
  }
}
}
return $output;
}
 function utf8_to_unicode( $str ) {
      
        $unicode = array();        
        $values = array();
        $lookingFor = 1;
        
        for ($i = 0; $i < strlen( $str ); $i++ ) {
            $thisValue = ord( $str[ $i ] );
        if ( $thisValue < ord('A') ) {
            // exclude 0-9

                 $unicode[] = "%u000".dechex($thisValue);
           
        } else {
              if ( $thisValue < 128) 
            $unicode[] = "%u000".dechex($str[ $i ]);
              else {
                    if ( count( $values ) == 0 ) $lookingFor = ( $thisValue < 224 ) ? 2 : 3;                
                    $values[] = $thisValue;                
                    if ( count( $values ) == $lookingFor ) {
                        $number = ( $lookingFor == 3 ) ?
                            ( ( $values[0] % 16 ) * 4096 ) + ( ( $values[1] % 64 ) * 64 ) + ( $values[2] % 64 ):
                            ( ( $values[0] % 32 ) * 64 ) + ( $values[1] % 64 );
                $number = dechex($number);
                $unicode[] = (strlen($number)==3)?"%u0".$number:"%u".$number;
                        $values = array();
                        $lookingFor = 1;
              } // if
            } // if
        }
        } // for
        return implode("",$unicode);

    } // utf8_to_unicode
	
function utf8_convert_case($s, $mode)
{
    #таблица конвертации регистра
    static $trans = array(
        #en (английский латиница)
        #CASE_UPPER => CASE_LOWER
        "\x41" => "\x61", #a
        "\x42" => "\x62", #b
        "\x43" => "\x63", #c
        "\x44" => "\x64", #d
        "\x45" => "\x65", #e
        "\x46" => "\x66", #f
        "\x47" => "\x67", #g
        "\x48" => "\x68", #h
        "\x49" => "\x69", #i
        "\x4a" => "\x6a", #j
        "\x4b" => "\x6b", #k
        "\x4c" => "\x6c", #l
        "\x4d" => "\x6d", #m
        "\x4e" => "\x6e", #n
        "\x4f" => "\x6f", #o
        "\x50" => "\x70", #p
        "\x51" => "\x71", #q
        "\x52" => "\x72", #r
        "\x53" => "\x73", #s
        "\x54" => "\x74", #t
        "\x55" => "\x75", #u
        "\x57" => "\x77", #w
        "\x56" => "\x76", #v
        "\x58" => "\x78", #x
        "\x59" => "\x79", #y
        "\x5a" => "\x7a", #z

        #ru (русский кириллица)
        #CASE_UPPER => CASE_LOWER
        "\xd0\x81" => "\xd1\x91", #ё
        "\xd0\x90" => "\xd0\xb0", #а
        "\xd0\x91" => "\xd0\xb1", #б
        "\xd0\x92" => "\xd0\xb2", #в
        "\xd0\x93" => "\xd0\xb3", #г
        "\xd0\x94" => "\xd0\xb4", #д
        "\xd0\x95" => "\xd0\xb5", #е
        "\xd0\x96" => "\xd0\xb6", #ж
        "\xd0\x97" => "\xd0\xb7", #з
        "\xd0\x98" => "\xd0\xb8", #и
        "\xd0\x99" => "\xd0\xb9", #й
        "\xd0\x9a" => "\xd0\xba", #к
        "\xd0\x9b" => "\xd0\xbb", #л
        "\xd0\x9c" => "\xd0\xbc", #м
        "\xd0\x9d" => "\xd0\xbd", #н
        "\xd0\x9e" => "\xd0\xbe", #о
        "\xd0\x9f" => "\xd0\xbf", #п

        #CASE_UPPER => CASE_LOWER
        "\xd0\xa0" => "\xd1\x80", #р
        "\xd0\xa1" => "\xd1\x81", #с
        "\xd0\xa2" => "\xd1\x82", #т
        "\xd0\xa3" => "\xd1\x83", #у
        "\xd0\xa4" => "\xd1\x84", #ф
        "\xd0\xa5" => "\xd1\x85", #х
        "\xd0\xa6" => "\xd1\x86", #ц
        "\xd0\xa7" => "\xd1\x87", #ч
        "\xd0\xa8" => "\xd1\x88", #ш
        "\xd0\xa9" => "\xd1\x89", #щ
        "\xd0\xaa" => "\xd1\x8a", #ъ
        "\xd0\xab" => "\xd1\x8b", #ы
        "\xd0\xac" => "\xd1\x8c", #ь
        "\xd0\xad" => "\xd1\x8d", #э
        "\xd0\xae" => "\xd1\x8e", #ю
        "\xd0\xaf" => "\xd1\x8f", #я

        #tt (татарский, башкирский кириллица)
        #CASE_UPPER => CASE_LOWER
        "\xd2\x96" => "\xd2\x97", #ж с хвостиком    &#1174; => &#1175;
        "\xd2\xa2" => "\xd2\xa3", #н с хвостиком    &#1186; => &#1187;
        "\xd2\xae" => "\xd2\xaf", #y                &#1198; => &#1199;
        "\xd2\xba" => "\xd2\xbb", #h мягкое         &#1210; => &#1211;
        "\xd3\x98" => "\xd3\x99", #э                &#1240; => &#1241;
        "\xd3\xa8" => "\xd3\xa9", #o перечеркнутое  &#1256; => &#1257;

        #uk (украинский кириллица)
        #CASE_UPPER => CASE_LOWER
        "\xd2\x90" => "\xd2\x91",  #г с хвостиком
        "\xd0\x84" => "\xd1\x94",  #э зеркальное отражение
        "\xd0\x86" => "\xd1\x96",  #и с одной точкой
        "\xd0\x87" => "\xd1\x97",  #и с двумя точками

        #be (белорусский кириллица)
        #CASE_UPPER => CASE_LOWER
        "\xd0\x8e" => "\xd1\x9e",  #у с подковой над буквой

        #tr,de,es (турецкий, немецкий, испанский, французский латиница)
        #CASE_UPPER => CASE_LOWER
        "\xc3\x84" => "\xc3\xa4", #a умляут          &#196; => &#228;  (турецкий)
        "\xc3\x87" => "\xc3\xa7", #c с хвостиком     &#199; => &#231;  (турецкий, французский)
        "\xc3\x91" => "\xc3\xb1", #n с тильдой       &#209; => &#241;  (турецкий, испанский)
        "\xc3\x96" => "\xc3\xb6", #o умляут          &#214; => &#246;  (турецкий)
        "\xc3\x9c" => "\xc3\xbc", #u умляут          &#220; => &#252;  (турецкий, французский)
        "\xc4\x9e" => "\xc4\x9f", #g умляут          &#286; => &#287;  (турецкий)
        "\xc4\xb0" => "\xc4\xb1", #i c точкой и без  &#304; => &#305;  (турецкий)
        "\xc5\x9e" => "\xc5\x9f", #s с хвостиком     &#350; => &#351;  (турецкий)

        #hr (хорватский латиница)
        #CASE_UPPER => CASE_LOWER
        "\xc4\x8c" => "\xc4\x8d",  #c с подковой над буквой
        "\xc4\x86" => "\xc4\x87",  #c с ударением
        "\xc4\x90" => "\xc4\x91",  #d перечеркнутое
        "\xc5\xa0" => "\xc5\xa1",  #s с подковой над буквой
        "\xc5\xbd" => "\xc5\xbe",  #z с подковой над буквой

        #fr (французский латиница)
        #CASE_UPPER => CASE_LOWER
        "\xc3\x80" => "\xc3\xa0",  #a с ударением в др. сторону
        "\xc3\x82" => "\xc3\xa2",  #a с крышкой
        "\xc3\x86" => "\xc3\xa6",  #ae совмещенное
        "\xc3\x88" => "\xc3\xa8",  #e с ударением в др. сторону
        "\xc3\x89" => "\xc3\xa9",  #e с ударением
        "\xc3\x8a" => "\xc3\xaa",  #e с крышкой
        "\xc3\x8b" => "\xc3\xab",  #ё
        "\xc3\x8e" => "\xc3\xae",  #i с крышкой
        "\xc3\x8f" => "\xc3\xaf",  #i умляут
        "\xc3\x94" => "\xc3\xb4",  #o с крышкой
        "\xc5\x92" => "\xc5\x93",  #ce совмещенное
        "\xc3\x99" => "\xc3\xb9",  #u с ударением в др. сторону
        "\xc3\x9b" => "\xc3\xbb",  #u с крышкой
        "\xc5\xb8" => "\xc3\xbf",  #y умляут

        #xx (другой язык)
        #CASE_UPPER => CASE_LOWER
        #"" => "",  #

    );
    #d($trans);

    #вариант с str_replace() должен работать быстрее, чем с strtr()
    if ($mode == CASE_UPPER)
    {
        if (function_exists('mb_strtoupper'))   return mb_strtoupper($s, 'utf-8');
        if (preg_match('/^[\x00-\x7e]*$/', $s)) return strtoupper($s); #может, так быстрее?
        return strtr($s, array_flip($trans));
    }
    elseif ($mode == CASE_LOWER)
    {
        if (function_exists('mb_strtolower'))   return mb_strtolower($s, 'utf-8');
        if (preg_match('/^[\x00-\x7e]*$/', $s)) return strtolower($s); #может, так быстрее?
        return strtr($s, $trans);
    }
    else
    {
        trigger_error('Parameter 2 should be a constant of CASE_LOWER or CASE_UPPER!', E_USER_WARNING);
        return $s;
    }
    return $s;
}

function utf8_lowercase($s)
{
    return utf8_convert_case($s, CASE_LOWER);
}

function utf8_uppercase($s)
{
    return utf8_convert_case($s, CASE_UPPER);
}


function utf8_ucfirst($s, $is_other_to_lowercase = true)
{
    if (preg_match('/^([a-zA-Z]  #английский (all)
                       | [a-zA-Z]|\xc3[\xa4\xa7\xb1\xb6\xbc\x84\x87\x91\x96\x9c]|\xc4[\x9f\xb1\x9e\xb0]|\xc5[\x9f\x9e]  #турецкие буквы (татарский латиница) (all)
                       | \xd0[\x90-\xbf\x81]|\xd1[\x80-\x8f\x91]  #русский А-я (all)
                       | \xd2[\x96\x97\xa2\xa3\xae\xaf\xba\xbb]|\xd3[\x98\x99\xa8\xa9]  #татарские буквы (all)
                      )     #1
                      (.*)  #2
                     $/sx', $s, $m))
    {
        if (! function_exists('utf8_convert_case'))  #оптимизация скорости include_once
        {
            include_once 'utf8_convert_case.php';
        }
        return utf8_convert_case($m[1], CASE_UPPER) . ($is_other_to_lowercase ? utf8_convert_case($m[2], CASE_LOWER) : $m[2]);
    }
    return $s;
} ?>