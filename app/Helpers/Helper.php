<?php
use Carbon\Carbon;

/**
 * Default password hash method
 * @param   string
 * @return  string
 */
if (!function_exists('hash_password')) {
    function hash_password($password)
    {
        return sha1(config('auth.salt') . $password);
    }
}

if (!function_exists('resultToArray')) {
    function resultToArray($result)
    {
        return json_decode(json_encode($result), true);
    }
}

if (!function_exists('params_check')) {
    /**
     * 必須チェック
     *
     * @params array $params パラメータ
     * @params array $requires 必須項目のキー
     */
    function params_check($params = array(), $requires = array())
    {
        foreach ($requires as $require) {
            if (!isset($params[$require]) || $params[$require] == '') {
                throw new \OneException(4, "Missing : {$require}");
            }
        }

        return true;
    }
}

if (!function_exists('rounding')) {
    /**
     * 丸め処理
     * @param mixed $value 値
     * @param integer $digits ○未満切り捨て / 切り上げ / 四捨五入
     * @param string $type
     */
    function rounding($value, $digits, $type = 'ceil')
    {
        $digits_value = bcpow(10, $digits);

        switch ($type) {
            case 'ceil': // 切上げ
                // string にキャストしないと不具合がでる。詳しくは→http://www.psi-net.co.jp/blog/?p=277
                return bcdiv(ceil(bcmul($value, $digits_value)), $digits_value, 10);
            case 'floor': // 切捨て
                // string にキャストしないと不具合がでる。詳しくは→http://www.psi-net.co.jp/blog/?p=277
                if ($value > 0) {
                    return bcdiv(floor(bcmul($value, $digits_value)), $digits_value, 10);
                } else {
                    // マイナスの時は、数学的な切り捨てではなく、省略にする
                    $string_value = "".$value;
                    // . の位置を探す
                    $point_pos = strpos($string_value, '.');
                    if ($point_pos === false) {
                        // 小数点以下がない
                        return $value;
                    }
                    return substr($string_value, 0, $point_pos + $digits + 1);
                }
                break;
            case 'round': // 四捨五入
                return round($value, $digits);
            default:
                break;
        }
    }
}

if (!function_exists('get_now_jst')) {
    /**
     * @return string|false
     */
    function get_now_jst($format = 'Y-m-d H:i:s')
    {
        return date($format, time());
    }
}

if (!function_exists('get_date_jst')) {
    /**
     * @return string|false
     */
    function get_date_jst($format = 'Y-m-d')
    {
        return date($format, time());
    }
}

if (!function_exists('get_array_value')) {
    /**
     * 引数の型（null、bool、int、floatまたはresource）の判断して、NULLを返す
     */
    function get_array_value($var, $key)
    {
        // 引数の型がnull、bool、int、floatまたはresource場合、NULLを返す
        if (is_resource($var) || $var == null || gettype($var) === "boolean"
            || gettype($var) === "double" || gettype($var) === "integer" || gettype($var) === "float"
        ) {
            return null;
        } else {
            return $var[$key];
        }
    }
}

if (!function_exists('csv_escape')) {
    // CSV出力するため、セル対象を"で囲める
    function csv_escape($cell)
    {
        $is_all_number = false;
        if ($cell === 0 ||($cell !== null && $cell != '' && preg_match('/^[0-9]+$/', $cell))) {
            $is_all_number = true;
        }
        $cell = str_replace('"', '""', $cell);  // ダブルコーテーションを２つにする
        if ($is_all_number) {
            $cell = '="'. $cell. '"';  // すべて数値の場合、頭の0をエクセルで自動的に消されるのを避けるために=を付ける
        } else {
            $cell = '"'. $cell. '"';
        }
        return $cell;
    }
}

if (!function_exists('age')) {
    /**
     * 現在時間から年齢取得
     *
     * @param string $birthday  EX. 20200101 , 2020-01-01 , 2020.01.01 , 2020/01/01
     *
     * @return int age (無効/未来誕生日の場合はnull)
     */
    function age($birthday)
    {
        $search="/\.|\/|-/";
        $birthday=preg_replace($search, "", $birthday);

        if (empty($birthday)||strlen($birthday)!=8) {
            return null;
        }

        $dt=Carbon::parse($birthday);

        return $dt->isFuture() ? null : $dt->age;
    }
}

if (! function_exists('string_format')) {
    /**
     * Smarty string_format modifier plugin
     *
     */
    function string_format(...$params)
    {
        return sprintf($params[1], $params[0]);
    }
}

if (! function_exists('dateFormat')) {
    /**
     * Smarty date_format modifier plugin
     * Ex. dateFormat('2019/01/31 0:21:55', 'Y-m-d H:i:s')
     * Ex. dateFormat(1668412613, 'Y-m-d H:i:s')
     */

    function dateFormat($datetime, $format)
    {
        if (gettype($datetime) == "string") {
            if ($datetime == "0000-00-00 00:00:00"){
                return null;
            }
            $dateTime = strtotime($datetime);
        } else {
            $dateTime = $datetime;
        }
        if (!$dateTime) {
            return null;
        }

        return  date($format, $dateTime);
    }
}

if (! function_exists('comcount')) {
    /**
     * 変数に含まれるすべての要素、あるいはオブジェクトに含まれる何かの数を数える
     */
    function comcount($var)
    {
        if (is_countable($var)) {
            // 変数に含まれるすべての要素、あるいはオブジェクトに含まれる何かの数を数える
            return count($var);
        } elseif (is_null($var)) {
            return 0;
        } else {
            // countable ではない型は1を返す
            return 1;
        }
    }
}

if (! function_exists('string_replace')) {
    /**
     * @param   string  string to parse
     * @param   array   params to str_replace
     * @return  string
     */
    function string_replace($string, $array = array())
    {
        if (is_string($string)) {
            $tr_arr = array();
            foreach ($array as $from => $to) {
                substr($from, 0, 1) !== ':' and $from = ':'.$from;
                $tr_arr[$from] = $to;
            }
            unset($array);
            return strtr($string, $tr_arr);
        } else {
            return $string;
        }
    }
}
if (! function_exists('ktkana_to_upper')) {
    /*
     * カタカナの小文字を大文字に変換（全角半角変換なし）
         * @param string $str_to_convert The string being converted.
         * @return string The converted string.
     */
    function ktkana_to_upper($str_to_convert = '')
    {
        try {
            $arr_lower_to_upper = array(
                                        //全角
                                        "ァ" => "ア", "ィ" => "イ", "ゥ" => "ウ", "ェ" => "エ", "ォ" => "オ",
                                        "ッ" => "ツ", "ャ" => "ヤ", "ュ" => "ユ", "ョ" => "ヨ",
                                        //全角、ただし半角文字なし
                                        "ヮ" => "ワ", "ヵ" => "カ", "ヶ" => "ケ",
                                        //半角
                                        "ｧ" => "ｱ", "ｨ" => "ｲ", "ｩ" => "ｳ", "ｪ" => "ｴ", "ｫ" => "ｵ",
                                        "ｯ" => "ﾂ", "ｬ" => "ﾔ", "ｭ" => "ﾕ", "ｮ" => "ﾖ",
                                        //環境依存
                                        "ㇰ" => "ク", "ㇱ" => "シ", "ㇲ" => "ス", "ㇳ" => "ト", "ㇴ" => "ヌ",
                                        "ㇵ" => "ハ", "ㇶ" => "ヒ", "ㇷ" => "フ", "ㇸ" => "ヘ", "ㇹ" => "ホ",
                                        "ㇺ" => "ム", "ㇻ" => "ラ", "ㇽ" => "ル", "ㇾ" => "レ", "ㇿ" => "ロ",
                                    );
            return str_replace(array_keys($arr_lower_to_upper), array_values($arr_lower_to_upper), $str_to_convert);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

if (!function_exists('floordec')) {
    /**
     * 小数点以下第N位を切上げ
     * from modifier.floordec.php ::smarty_modifier_floordec()
     *
     * @param string|int|float $val    丸める数値
     * @param int              $digits 精度
     *
     * @return string
     */
    function floordec($val, $digits)
    {
        if ($val == '') {
            return '';
        }

        $digits_value = bcpow(10, $digits);

        $val = bcmul($val, $digits_value);
        $val = floor($val);
        $val = bcdiv($val, $digits_value, $digits);
        if ($val == 0) {
            return '0.00';
        }

        return $val;
    }
}

if (!function_exists('getRandomNumber')) {
    /**
     * Default password hash method
     *
     * @param string
     * @return  string
     */
    function getRandomNumber($str_num)
    {
        $code = "";
        for ($i = 0; $i < $str_num; $i++) {
            if ($i == 0) {
                $code .= rand(1, 9);
            } else {
                $code .= rand(0, 9);
            }
        }
        return $code;
    }
}

if (!function_exists('getFilterVar')) {
    /**
     * @param string
     */
    function getFilterVar($str)
    {
        if (filter_var($str, FILTER_VALIDATE_URL)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('getPage')) {
    /**
     * @param string
     */
    function getPage($page,$allpage,$iswh=array())
    {
        if($allpage==1) {
            return "";
        }
        $wh="?";
        foreach ($iswh as $key => $value) {
            if($key!="page") {
                $wh.=$key."=".$value."&";
            }
        }
        $number='';
        if($allpage<6) {
            for ($i=1; $i <$allpage+1 ; $i++) {
                if($i==$page) {
                    $number.='<li><a class="on">'.$i.'</a></li>';
                } else {
                    $number.='<li><a href="'.$wh.'page='.$i.'">'.$i.'</a></li>';
                }
            }
        } else {
            if($page<4) {
                for ($i=1; $i <6 ; $i++) {
                    if($i==$page) {
                        $number.='<li><a class="on">'.$i.'</a></li>';
                    } else {
                        $number.='<li><a href="'.$wh.'page='.$i.'">'.$i.'</a></li>';
                    }
                }
            } else if($page>$allpage-3) {
                for ($i=$allpage-4; $i <$allpage+1 ; $i++) {
                    if($i==$page) {
                        $number.='<li><a class="on">'.$i.'</a></li>';
                    } else {
                        $number.='<li><a href="'.$wh.'page='.$i.'">'.$i.'</a></li>';
                    }
                }
            } else {
                for ($i=$page-2; $i <$page+3 ; $i++) {
                    if($i==$page) {
                        $number.='<li><a class="on">'.$i.'</a></li>';
                    } else {
                        $number.='<li><a href="'.$wh.'page='.$i.'">'.$i.'</a></li>';
                    }
                }
            }
        }
        $html='<ul class="page_soto mt50 mb50">
					    <li><a href="'.$wh.'page='.($page>1?$page-1:1).'">＜</a></li>
					    '.$number.'
					    <li><a href="'.$wh.'page='.($allpage>$page?$page+1:$allpage).'">＞</a></li>
				</ul>';
        return $html;
    }
}
