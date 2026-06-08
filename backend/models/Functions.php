<?php

namespace backend\models;

use common\models\User;

use Yii;
use yii\helpers\StringHelper;
use yii\helpers\Url;

class Functions extends \yii\base\Component
{

    public static function getStatus($status = null, $label = false)
    {
        if ($label) {
            $data = [
                'active' => '<span class="label label-success">' . \Yii::t('yii', 'Active') . '</span>',
                'inactive' => '<span class="label label-danger">' . \Yii::t('yii', 'Inactive') . '</span>',

            ];
        } else {
            $data = [
                'active' => \Yii::t('yii', 'Active'),
                'inactive' => \Yii::t('yii', 'Inactive'),
            ];
        }
        if ($status) {
            return isset($data[$status]) ? $data[$status] : null;
        } else {
            return $data;
        }
    }

    public static function getBool($status = null, $label = false)
    {
        if ($label) {
            $data = [
                0 => '<span class="label label-danger">' . \Yii::t('yii', 'No') . '</span>',
                1 => '<span class="label label-success">' . \Yii::t('yii', 'Yes') . '</span>',
            ];
        } else {
            $data = [
                0 => \Yii::t('yii', 'No'),
                1 => \Yii::t('yii', 'Yes'),
            ];
        }
        if ($status === 0 or $status === 1) {
            return isset($data[$status]) ? $data[$status] : null;
        } else {
            return $data;
        }
    }

    public static function getLanguageValue($value)
    {
        return self::jsonDecode($value, Yii::$app->language, true);
    }

    public static function checkArray($array, $column)
    {
        return ($array and isset($array[$column])) ? $array[$column] : null;
    }

    public static function getStatusComment($status = null, $label = false)
    {
        if ($label) {
            $data = [
                'active' => '<span class="label label-success">' . \Yii::t('yii', 'Active') . '</span>',
                'inactive' => '<span class="label label-warning">' . \Yii::t('yii', 'Inactive') . '</span>',
                'spam' => '<span class="label label-danger">' . \Yii::t('yii', 'Spam') . '</span>',
                'new' => '<span class="label label-info">' . \Yii::t('yii', 'New') . '</span>',

            ];
        } else {
            $data = [
                'active' => \Yii::t('yii', 'Active'),
                'inactive' => \Yii::t('yii', 'Inactive'),
                'spam' => \Yii::t('yii', 'Spam'),
                'new' => \Yii::t('yii', 'New'),
            ];
        }
        if ($status) {
            return isset($data[$status]) ? $data[$status] : null;
        } else {
            return $data;
        }
    }

    public static function getSex($sex = null, $label = false)
    {
        if ($label) {
            $data = [
                'male' => '<span class="fa fa-male font-size-20"></span>',
                'female' => '<span class="fa fa-female font-size-20"></span>',

            ];
        } else {
            $data = [
                'male' => \Yii::t('yii', 'Male'),
                'female' => \Yii::t('yii', 'Female'),
            ];
        }
        if ($sex) {
            return isset($data[$sex]) ? $data[$sex] : null;
        } else {
            return $data;
        }
    }

    public static function sortByKey(array $array, $byKey, $order = 1)
    {
        $sort = [];
        foreach ($array as $key => $row) {
            $sort[$key] = $row[$byKey];
        }
        array_multisort($sort, $order, $array);
        return $array;
    }

    public static function clearEmptyString($str)
    {
        if (($str == null or empty($str) or $str == '') and !is_numeric($str)) {
            return false;
        } else {
            return true;
        }
    }

    public static function jsonDecodeArrayNew($array)
    {
        $current_language = \Yii::$app->language;
        $data = [];
        foreach ($array as $key => $item) {
            $data[self::jsonDecode($key, $current_language, true)] = self::jsonDecodeArray($item, true);
        }
        return $data;

    }

    public static function jsonDecodeArray($array, $not = null, $limit = null, $child = null)
    {
        $current_language = \Yii::$app->language;
        $data = [];
        foreach ($array as $key => $item) {
            if ($not) {
                if (is_array($item) and !static::is_json($item)) {

                    $array_data_key = (array)json_decode($key, true);
                    if (isset($array_data_key[$current_language]) and $array_data_key[$current_language] != "") {

                        if ($limit) {
                            if ($child) {
                                $item = (array)json_decode($item, true);
                                $data[StringHelper::truncateWords($array_data_key[$current_language], $limit)] = $item[$current_language];
                            } else {
                                $data[StringHelper::truncateWords($array_data_key[$current_language], $limit)] = $item;
                            }
                        } else {
                            if ($child) {
                                if (is_array($item)) {
                                    $new = [];
                                    foreach ($item as $k => $v) {
                                        $v = (array)json_decode($v, true);

                                        if (!isset($v[$current_language])) {
                                            $lang = array_values($v);
                                            $lang = self::clearEmpty($lang);
                                            $new[$k] = $lang[0];
                                        } else {
                                            $new[$k] = $v[$current_language];
                                        }
                                    }
                                    $data[$array_data_key[$current_language]] = $new;
                                } else {
                                    $data[$array_data_key[$current_language]] = $item;
                                }
                            } else {
                                $data[$array_data_key[$current_language]] = $item;
                            }
                        }
                    } else {


                        $lang = array_values($array_data_key);

                        $lang = self::clearEmpty($lang);
//                        $data[$lang[0]] = $item;

                        $new = [];
                        if (is_array($item)) {
                            foreach ($item as $k => $v) {
                                $v = (array)json_decode($v, true);
                                if (!isset($v[$current_language])) {
                                    $lang2 = array_values($v);
                                    $lang2 = self::clearEmpty($lang2);
                                    $new[$k] = $lang2[0];
                                } else {
                                    $new[$k] = $v[$current_language];
                                }
                            }
                        } else {
                            $new = $item;
                        }
                        $data[$lang[0]] = $new;
                    }
                } else {

                    $array_data = (array)json_decode($item, true);
                    if (isset($array_data[$current_language])) {
                        $data[$key] = (!empty($array_data[$current_language])) ? $array_data[$current_language] : self::clearEmpty($array_data)[0];
                    } else {
                        $lang = array_values($array_data);
                        $lang = self::clearEmpty($lang);
                        $data[$key] = $lang[0];
                    }
                }
            } else {
                if (is_array($item)) {
                    $array_data_key = (array)json_decode($key, true);
                    if (isset($array_data_key[$current_language])) {
                        $data[$array_data_key[$current_language]] = $item;
                    } else {
                        $lang = array_values($array_data_key);
                        $lang = self::clearEmpty($lang);
                        $data[$lang[0]] = $item;
                    }
                } else {
                    $data[$key] = self::jsonDecode($item, $current_language);
                }
            }
        }
        return $data;
    }

    public static function is_json($string)
    {
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

    public static function clearEmpty($array, $k = false)
    {
        $ar = [];
        if (!is_array($array)) {
            return null;
        }
        foreach ($array as $key => $item) {
            if ($item == null or empty($item) or $item == '') {
                unset($array[$key]);
            } else {
                if ($k) {
                    $ar[$key] = $item;
                } else {
                    $ar[] = $item;
                }
            }
        }
        return $ar;
    }

    public static function jsonDecode($value, $current_language = null, $hard = null)
    {

        if (is_null($value)) {
            return '<em class="text-danger">' . \Yii::t('yii', 'Not set') . '</em>';
        } elseif ($current_language) {

            $array = (array)json_decode($value, true);
            if ($hard) {
                if (isset($array[$current_language]) and $array[$current_language] != "") {
                    return $array[$current_language];
                } else {
                    $lang = array_values($array);
                    $lang = self::clearEmpty($lang);
                    return (isset($lang[0]) and !empty($lang[0])) ? $lang[0] : null;
                }
            } else {
                if (isset($array[$current_language])) {
                    return (!empty($array[$current_language])) ? $array[$current_language] : '<em class="text-danger">' . \Yii::t('yii', 'Not set') . '</em>';
                } else {
                    $lang = array_values($array);
                    $lang = self::clearEmpty($lang);
                    return (isset($lang[0]) and !empty($lang[0])) ? $lang[0] : null;
                }
            }
        }
        return (array)json_decode($value, true);
    }

    public static function makeSlug($title)
    {
        $slug = null;
        if (!is_array($title)) {
            return null;
        }
        if (isset(array_values(static::clearEmpty($title))[0])) {
            $slug = self::ru2lat(array_values(static::clearEmpty($title))[0]);
        }
        return $slug;
    }

    public static function getTranslate($post)
    {
        // $post = trim($post);
        if (!empty(static::clearEmpty($post))) {
            return static::jsonEncode($post);
        } else {
            return null;
        }
    }

    public static function jsonEncode($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public static function asHtml($attribute)
    {
        $translate = static::jsonDecode($attribute);
        $table = '<table class="table m-0 table-bordered table-hover">';
        $languages = \Yii::$app->params['languages'];
        foreach ($languages as $key => $language) {
            if (isset($translate[$key])) {
                $table .= '<tr>
                              <th style="width: 15%">' . $language . '</th>
                              <td>' . $translate[$key] . '</td>
                          </tr>';
            }
        }
        $table .= '</table>';

        return $table;
    }

    public static function getBinaryDataImage($file)
    {
        $file = Yii::$app->basePath . '/web' . $file;
        $mime = mime_content_type($file);
        $contents = file_get_contents($file);
        $base64 = base64_encode($contents);
        return ('data:' . $mime . ';base64,' . $base64);
    }

    public static function getText($position)
    {
        $cache = Yii::$app->cache;
        if ($data = $cache->get($position)) {
            return Functions::jsonDecode($data, Yii::$app->language, true);
        } else {
            $text = User::find()
                ->select(['text'])
                ->asArray()
                ->limit(1)
                ->where(['status' => 'active'])
                ->andWhere(['position' => $position])
                ->one();
            if ($text != null) {
                $text = $text['text'];
                $key = $position;
                $cache->add($key, $text, 300);
                $data = $cache->get($key);
                return Functions::jsonDecode($data, Yii::$app->language, true);
            } else {
                return $position;
            }
        }
    }

    public static function getImage($file, $default = null, $thumb = 'original')
    {
        $path = Yii::$app->basePath . '/web' . $file;
        if (!empty($file) and is_file($path) and self::urlExists($path)
        ) {
            $fileName = explode('/', $file);
            if ($thumb == 'small') {
                return Url::home(true) . 'upload/thumb/small/' . end($fileName);
            } elseif ($thumb == 'medium') {
                return Url::home(true) . 'upload/thumb/medium/' . end($fileName);
            }
            return Url::home(true) . str_replace('/upload', 'upload', $file);
        } else {
            if ($default) {
                return Url::home(true) . 'images/' . $default;
            } else {
                return Url::home(true) . 'images/logo.png';
            }
        }
    }

    public static function getFile($file)
    {
        $path = Yii::$app->basePath . $file;
        if (!empty($file) and $file != '' and is_file($path) and self::urlExists($path)) {
            return $file;
        } else {
            return null;
        }
    }

    public static function urlExists($path)
    {
        if (file_exists($path)) {
            return true;
        } else {
            return false;
        }
    }

    public static function asPhone($number)
    {
        $new_foramat = '+998';
        $numbers = str_split($number);
        foreach ($numbers as $key => $number) {
            if ($key == 6 or $key == 9) {
                $new_foramat .= $number . '-';
            } else {
                $new_foramat .= $number;
            }
        }
        return $new_foramat;
    }

    public static function ru2lat($string)
    {
        $convert = array(
            "А" => "a", "Б" => "b", "В" => "v", "Г" => "g", "Д" => "d",
            "Е" => "e", "Ё" => "yo", "Ж" => "zh", "З" => "z", "И" => "i",
            "Й" => "j", "К" => "k", "Л" => "l", "М" => "m", "Н" => "n",
            "О" => "o", "П" => "p", "Р" => "r", "С" => "s", "Т" => "t",
            "У" => "u", "Ф" => "f", "Х" => "kh", "Ц" => "ts", "Ч" => "ch",
            "Ш" => "sh", "Щ" => "sch", "Ъ" => "", "Ы" => "y", "Ь" => "",
            "Э" => "e", "Ю" => "yu", "Я" => "ya", "а" => "a", "б" => "b",
            "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ё" => "yo",
            "ж" => "zh", "з" => "z", "и" => "i", "й" => "j", "к" => "k",
            "л" => "l", "м" => "m", "н" => "n", "о" => "o", "п" => "p",
            "р" => "r", "с" => "s", "т" => "t", "у" => "u", "ф" => "f",
            "х" => "kh", "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch",
            "ъ" => "_", "ы" => "y", "ь" => "_", "э" => "e", "ю" => "yu",
            "я" => "ya", " " => "-", "." => ".", "," => "_", "/" => "_",
            ":" => "_", ";" => "_", "—" => "_", "–" => "-", "ў" => "o", "Ў" => "o",
            "Қ" => "Q", "қ" => "q", "Ғ" => "G", "ғ" => "g", "Ҳ" => "H", "ҳ" => "h",
            "?" => "", '"' => "_", "№" => "_", "*" => '_', '#' => '',
            '^' => '', '!' => '_', '+' => '', '_' => '_', '[' => '', ']' => '',
            '{' => '', '}' => '', '\'' => '_', '(' => '', ')' => '', '$' => '',
        );
        return strtr(trim($string), $convert);
    }


    public static function getSize($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    public static function getMonth($month)
    {
        $data = [
            'January' => Yii::t('yii', 'January'),
            'February' => Yii::t('yii', 'February'),
            'March' => Yii::t('yii', 'March'),
            'April' => Yii::t('yii', 'April'),
            'May' => Yii::t('yii', 'May'),
            'June' => Yii::t('yii', 'June'),
            'July' => Yii::t('yii', 'July'),
            'August' => Yii::t('yii', 'August'),
            'September' => Yii::t('yii', 'September'),
            'October' => Yii::t('yii', 'October'),
            'November' => Yii::t('yii', 'November'),
            'December' => Yii::t('yii', 'December'),
        ];
        return isset($data[$month]) ? $data[$month] : null;
    }

    public static function getTags($tags, $text = false)
    {
        $tags = self::jsonDecode($tags);
        if (is_array($tags)) {
            $links = '';
            $c = count($tags);
            $i = 1;
            foreach ($tags as $tag) {
                if ($text) {
                    $links .= $tag;
                } else {
                    $links .= '<a href="' . Url::to(['site/search', 'q' => $tag]) . '">' . $tag . '</a>';
                }
                if ($i != $c) {
                    $links .= ', ';
                }
                $i++;
            }
            return $links;
        } else {
            return null;
        }
    }


    public static function changeUrlLang($lang)
    {
        $urlLang = substr(Yii::$app->getRequest()->getUrl(), 1, 2);

        $url = Yii::$app->getRequest()->getUrl();

        if (isset(Yii::$app->params['languages'][$urlLang])) {
                $url = substr($url, 4, strlen($url));

            Yii::$app->session->set('language',  $urlLang);
            Yii::$app->language = $urlLang;
        }

        return '/'.$lang.'/'.$url;
    }

    public static function languageWidget()
    {
        $langArray = [];
        foreach (Yii::$app->params['languages'] as $url => $lang) {
            if ($url !== Yii::$app->language) {
                $langArray[] = [
                    'label' => $lang,
                    'url' => self::language($url),
                    //'options' => ['class' => (Yii::$app->language === $url) ? 'active' : '']
                ];
            }
        }
        $res = ['label' => Yii::$app->params['languages'][Yii::$app->language], 'url' => '#', 'options' => ['class' => 'lang-dropdown'],
            'items' => $langArray
        ];

        return $res;
    }

    public static function getSumma($percent, $sum)
    {
        $summa = ($sum * $percent) / 100;
        return Yii::$app->formatter->asDecimal($summa);
    }

    public static function language($language)
    {
        return self::str_replace_first(Yii::$app->language, $language, Yii::$app->getRequest()->getUrl());


//        $convert = array(
//            "uz" => $language,
//            "uzkr" => $language,
//            "ru" => $language
//        );
//        return strtr(Yii::$app->getRequest()->getUrl(), $convert);
    }

    public static function getOption($key)
    {
        $cache = Yii::$app->cache;
        if ($data = $cache->get($key)) {
            return $data;
        } else {
            $text = Option::find()
                ->asArray()
                ->andWhere(['key' => $key])
                ->one();
            if ($text != null) {
                $text = $text['value'];
                $cache->add($key, $text, 300);
                $data = $cache->get($key);
                return $data;
            } else {
                return null;
            }
        }
    }

    public static function getValue(array $array, $column)
    {
        if ($array) {
            $data = [];
            foreach ($array as $item) {
                $data[] = isset($item[$column]) ? $item[$column] : null;
            }
        } else {
            return null;
        }
        return $data;
    }

    public static function getTagContent($attr, $value, $xml)
    {
        $attr = preg_quote($attr);
        $value = preg_quote($value);
        $tag_regex = '/<div[^>]*' . $attr . '="' . $value . '">(.*?)<\\/div>/si';
        preg_match($tag_regex,
            $xml,
            $matches);

        return trim(strip_tags($matches[1]));
    }

    public static function getNoReplyEmail()
    {
        return isset(Yii::$app->components['mailer']['transport']['username']) ? Yii::$app->components['mailer']['transport']['username'] : null;
    }


    public static function isCyrillicText($text)
    {
        return preg_match('/[А-Яа-яЁё]/u', $text);
    }

    public static function getLineText($str, $type = null, $random = false)
    {
        $doc = new DOMDocument();
        $doc->loadHTML(mb_convert_encoding($str, 'HTML-ENTITIES', 'UTF-8'));
        $text = '<table class="table table-bordered table-text table-condensed">';
        $i = 0;
        $random_lines = [];
        foreach ($doc->getElementsByTagName('p') as $paragraph) {
            $str = trim($paragraph->textContent, "\xC2\xA0");
            if ($type == 'sprint' and $i == 1) {
                break;
            }
            if ($str and $str != '' and !empty($str)) {
                if ($random) {
                    $random_lines[] = $str;
                } else {
                    if ($i % 2 == 0) {
                        $class = 'even';
                    } else {
                        $class = 'odd';
                    }
                    $text .= '<tr class="' . $class . '"><td style="text-align:right;padding-left: 15px;vertical-align: top!important;">' . ($i + 1) . ' </td><td>' . $str . "</td><tr/>";
                }
                $i++;
            }
        }
        $text .= '</table>';
        if ($random) {
            if (count($random_lines) != 0) {
                shuffle($random_lines);
                $line = current($random_lines);
            } else {
                $line = null;
            }
            return $line;
        }
        return $text;
    }

    public static function getCountText($text, $letter = false)
    {
        if ($letter) {
            $count = strlen(trim($text));
        } else {
            $count = count(explode(' ', trim($text)));
        }
        return $count;
    }


    public static function is_image($path)
    {
        $a = getimagesize($path);
        $image_type = $a[2];

        if (in_array($image_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP))) {
            return true;
        }
        return false;
    }

    public static function getDate($date)
    {

        $unix_time = strtotime($date);

        $formatted_date = "";
        $formatted_date .= date('d', $unix_time) . ' ';
        $formatted_date .= Yii::t('yii', date("F", $unix_time)) . ' ';
        $formatted_date .= ltrim(date('Y', $unix_time),'0');

        return $formatted_date;
    }

    public static function toUpperFirst($name)
    {
        return ucwords(strtolower($name));
    }

    public static function getBirthdayText($year)
    {
        $year = intval($year);
        $t1 = $year % 10;
        $t2 = $year % 100;
        return ($t1 == 1 && $t2 != 11 ?
            Yii::t('yii', 'year') :
            ($t1 >= 2 && $t1 <= 4 && ($t2 < 10 || $t2 >= 20) ?
                Yii::t('yii', 'years') :
                Yii::t('yii', 'years_')));
    }

    static function str_replace_first($from, $to, $content)
    {
        $from = '/' . preg_quote($from, '/') . '/';

        return preg_replace($from, $to, $content, 1);
    }

    public static function in_modify($needle, $haystack)
    {
        return in_array(strtolower($needle), array_map('strtolower', $haystack));
    }

    public static function compare($path, $ext)
    {
        return strtolower($path) == strtolower($ext);
    }

    public static function createLikeCondition($directions)
    {
        $outputCondition = '';
        $i = 0;
        if (count($directions) == 1) {
            $outputCondition = 'json_contains(`direction`, \'"' . intval($directions[0]) . '"\') = 1 ';
        } else {
            foreach ($directions as $value) {
                $i++;
                if ($i == 1)
                    $outputCondition .= 'json_contains(`direction`, \'"' . intval($value) . '"\') = 1 ';
                else
                    $outputCondition .= 'OR json_contains(`direction`, \'"' . intval($value) . '"\') = 1 ';
            }
        }

        return $outputCondition;
    }

    public static function getLanguageData($ar,$lang){
        if(array_key_exists($lang, $ar))
            return $ar[$lang];
        else
            return '';
    }

    public static function setSelected($s,$i){
        if($s == $i)
            return 'selected';
        else
            return '';
    }
}