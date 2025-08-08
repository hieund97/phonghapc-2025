<?php

use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Support\Arr;
use Peidgnad\TagWrapper\TagWrapper;
use App\Models\Option;
use Cart as CartClass;

if (!function_exists('logMethodDisplay')) {
    function logMethodDisplay($method)
    {
        $methodColors = [
            'GET'    => 'green',
            'POST'   => 'yellow',
            'PUT'    => 'blue',
            'DELETE' => 'red',
        ];
        $color        = Arr::get($methodColors, $method, 'grey');
        echo "<span class=\"badge bg-$color\">$method</span>";
    }
}
if (!function_exists('logInputDisplay')) {
    function logInputDisplay($input)
    {
        $input = json_decode($input, true);
        if (empty($input)) {
            $out = '<code>{}</code>';
        } else {
            $input = Arr::except($input, ['_pjax', '_token', '_method', '_previous_']);
            if (empty($input)) {
                $out = '<code>{}</code>';
            } else {
                $out = '<pre>' . json_encode($input, JSON_PRETTY_PRINT | JSON_HEX_TAG) . '</pre>';
            }
        }
        echo $out;
    }
}
if (!function_exists('formatDateToDB')) {
    function formatDateToDB($date = '', $format = 'Y-m-d')
    {
        if ($date == '' || $date == null) {
            return;
        }
        $date = str_replace('/', '-', $date);

        return date($format, strtotime(trim($date)));
    }
}
if (!function_exists('formatDateShow')) {
    function formatDateShow($date = '')
    {
        if ($date == '' || $date == null) {
            return;
        }
        $format = config('admin.format_date');

        return date($format, strtotime(trim($date)));
    }
}
if (!function_exists('formatDateTimeShow')) {
    function formatDateTimeShow($date = '')
    {
        if ($date == '' || $date == null) {
            return;
        }
        $format = config('admin.format_date_time');

        return date($format, strtotime(trim($date)));
    }
}
if (!function_exists('dateRangePicker')) {
    function dateRangePicker($strRange, $strSplit = '-')
    {
        $range = explode($strSplit, $strRange);
        $from  = formatDateToDB(trim($range[0]));
        $to    = formatDateToDB(trim($range[1]));

        return [$from, $to];
    }
}

if (!function_exists('get_youtube_id_from_url')) {
    function get_youtube_id_from_url($url)
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
            $url, $match);

        if (empty($match[1])) {
            return $url;
        }

        return $match[1];
    }
}

if (!function_exists('round_by_place')) {
    function round_by_place($number, $place)
    {
        return round($number, (strlen($number) - $place) * -1);
    }
}

if (!function_exists('array_partition')) {
    function array_partition(array $a, $np, $pad = true)
    {
        $np = (int)$np;
        if ($np <= 0) {
            trigger_error('partition count must be greater than zero', E_USER_NOTICE);

            return [];
        }
        $c         = count($a);
        $per_array = (int)floor($c / $np);
        $rem       = $c % $np;
        // special case for an empty array
        if ($c === 0) {
            if ($pad) {
                $result = array_fill(0, $np, []);
            } else {
                $result = [];
            }
        } // array_chunk will work if the remainder is 0 or np-1, or if there are more partitions than elements in the array
        elseif ($rem === 0 || $rem == $np - 1 || $np >= $c) {
            // if there is a remainder each partition will need 1 more
            $result = array_chunk($a, $per_array + ($rem > 0 ? 1 : 0));

            // if necessary, pad out the array with empty arrays
            if ($pad && $np > $c) {
                $result = array_merge($result, array_fill(0, $np - $c, []));
            }
        }
        // use the slower case if 0 < remainder < np-1 and there are more elements in the array than paritions
        // ($rem > 0 && $rem < $np - 1 && $np < $c)
        else {
            $split = $rem * ($per_array + 1);
            // the first $rem partitions will have $per_array + 1
            $result = array_chunk(array_slice($a, 0, $split), $per_array + 1);
            // the rest of the partitions will have per_array
            $result = array_merge($result, array_chunk(array_slice($a, $split), $per_array));
            // no padding is necessary if the conditions for this case are met
        }

        return $result;
    }
}

if (!function_exists('number_input')) {
    function number_input($value)
    {
        if (empty($value)) {
            return 0;
        }

        return (int)str_replace(',', '', $value);
    }
}

if (!function_exists('replace_tags')) {
    function replace_tags($tags, $subject)
    {
        foreach (collect($tags)->sortByDesc([fn($tag) => strlen($tag['name'])]) as $tag) {
            $subject = preg_replace_callback(
                "/\b({$tag['name']})\b(?![^<]*<\/a>)/imu",
                function ($matches) use ($tag) {
                    return '<a href="' . config("admin.frontend_url") . '/tags/' . $tag['slug'] . '">' . $matches[0] . '</a>';
                },
                $subject
            );
        }

        return $subject;
    }
}

if (!function_exists('get_addresses')) {
    function get_addresses($request)
    {
        if (!empty($request->address) && is_array($request->address)) {
            Validator::make($request->all(), [
                'address.province' => 'required|integer|exists:provinces,id',
                'address.district' => 'required|integer|exists:districts,id',
                'address.ward'     => 'nullable|integer|exists:wards,id',
            ])->validate();

            $province = Province::findOrFail($request->address['province'] ?? '');
            $district = District::findOrFail($request->address['district'] ?? '');

            if (!empty($request->address['ward'])) {
                $ward = Ward::findOrFail($request->address['ward']);
            }

            $request->merge([
                'address' => array_merge($request->address, [
                    'province' => $province->name,
                    'district' => $district->name,
                    'ward'     => $ward->name ?? null,
                ]),
            ]);

            $request->merge([
                'address' => !empty($request->address['country']) ? $request->address : array_merge($request->address, [
                    'country' => 'Việt Nam',
                ]),
            ]);
        } else {
            $request->merge(['address' => null]);
        }
    }
}

if (!function_exists('order_status_color')) {
    function order_status_color($status)
    {
        $colours = [
            1 => 'dark',
            2 => 'info',
            3 => 'warning',
            4 => 'danger',
            5 => 'success',
            6 => 'warning',
            7 => 'success',
            8 => 'danger',
        ];

        return $colours[$status];
    }
}

if (!function_exists('getFilterUrl')) {
    function getFilterUrl($key, $value)
    {
        $params = request()->input();

        if (isset($params['page'])) {
            return request()->fullUrlWithQuery([
                $key   => $value,
                'page' => 1,
            ]);
        } else {
            return request()->fullUrlWithQuery([
                $key => $value,
            ]);
        }
    }
}
if (!function_exists('isFilterCurrent')) {
    function isFilterCurrent($key, $value)
    {
        $params = request()->input();

        if (isset($params[$key]) && $value == $params[$key]) {
            return true;
        }

        return false;
    }
}

if (!function_exists('customRequestCaptcha')) {
    function customRequestCaptcha()
    {
        return new \ReCaptcha\RequestMethod\Post();
    }
}

if (!function_exists('getTextLink')) {
    function getTextLink($description, $textLinks)
    {
        return $description;
        /* foreach ($textLinks as $textLink) {
             $test = [$textLink->text => $textLink->link];
             $wrapper = TagWrapper::find($textLink->text, $description);
            $prepend = function ($keyword) {
                return '<a href="'.$keyword.'">';
            };
            $wrapper->wrapWith($prepend, '</a>');
            $wrapper->ignoreIndex([0,1]);
            $result = $wrapper->exec();
         }
         function replaceTextLink($result, $value) {
                    $arr = [];
                    foreach ($result[0] as $key=>$val) {
                        foreach ($value as $val1) {
                            if($key === (int)$val1) {
                                array_push($arr, $val[1]);
                            }
                        }
                    }
                   return $arr;
                }
         function replace_tagss($tags, $subject, $entities = true) {
                    if ($entities) {
                        $tags = array_unique(array_merge($tags, array_map(function ($tag) {
                            return htmlentities($tag);
                        }, $tags)));
                    }
                    usort($tags, function ($a, $b) {
                        return strlen($b) - strlen($a);
                    });
                    foreach ($tags as $tag) {
                        $subject = preg_replace_callback(
                            "/\b({$tag})\b(?![^<]*<\/a>)/imu",
                            function ($matches) use ($tag) {
                                return '<a href="tags/' . $tag . '">' . $matches[0] . '</a>';
                            },
                            $subject
                        );
                    }
                    return $subject;
                }
                $description= html_entity_decode(replace_tagss(['xe', 'oled'], $decodeDescription))
                 if (!empty($textLinks)) {
                         foreach ($textLinks as $textLink) {
                             $valueTextLink = preg_match_all("/" . $textLink->text . "/" , $description, $matches, PREG_OFFSET_CAPTURE);
                             if(!empty($textLink->list_id)){
                                 if(in_array($product->id, explode(',', $textLink->list_id,))) {
                                     //dd(($textLink->index != null));
                                     //dd($matches);
                                     if ($textLink->index !== null) {
                                         foreach (replaceTextLink($matches, explode(",", $textLink->index)) as $value) {
                                             $description = substr_replace($description, '<a href="'.$textLink->link.'">'.$textLink->text.'</a>', $value, strlen($textLink->text));
                                         }
                                     }
                                 }
                                 // $description = str_replace($textLink->text, '<a href="'.$textLink->link.'">'.$textLink->text.'</a>', $product->description);
                             } else if(empty($textLink->list_id)) {
                                 // $description = str_replace($textLink->text, '<a href="'.$textLink->link.'">'.$textLink->text.'</a>', $product->description);
                             }
             }
             */

        $descriptionNew = $description;
        foreach ($textLinks as $textLink) {
            $rel = '';
            if ($textLink->rel) {
                $rel = 'rel="' . $textLink->rel . '"';
            }
            if (empty($textLink->index)) {
                $descriptionNew = str_replace($textLink->text,
                    '<a ' . $rel . ' href="' . $textLink->link . '">' . $textLink->text . '</a>', $descriptionNew);
            } else {
                $arrContent = explode($textLink->text, $descriptionNew);
                dd($textLink->index);
                $index = $textLink->index - 1;
                if (isset($arrContent[$index])) {
                    $descriptionNew = '';
                    foreach ($arrContent as $key => $str) {
                        if ($key == $index) {
                            $descriptionNew .= $str . '<a ' . $rel . ' href="' . $textLink->link . '">' . $textLink->text . '</a>';
                        } else {
                            $descriptionNew .= $str . $textLink->text;
                        }
                    }
                }
            }
        }

        return $descriptionNew;
    }
}

if (!function_exists('checkHasConfig')) {
    function checkHasConfig($arrayConfig)
    {
        if(!empty($arrayConfig)) {
            foreach ($arrayConfig as $index => $config) {
                if ($index == 1 && (empty($config['name'] || $config['price']))) {
                    return false;
                }
            }
        }


        return true;
    }
}

if (!function_exists('checkRobotNoIndexNoFollow')) {
    function checkRobotNoIndexNoFollow($string)
    {
        $string      = strtolower($string);
        $posNoFollow = strpos($string, 'nofollow');
        $posNoIndex  = strpos($string, 'noindex');
        if ($posNoFollow !== false && $posNoIndex !== false) {
            return true;
        } else {
            return false;
        }
    }
}


if (!function_exists('getMetaRobots')) {
    // type:0 la binh thuong 
    function getMetaRobots($seo, $type = 0)
    {
        $robotsInput = Cache::rememberForever('meta_robots_global', function () {
            return Option::where('option_name', 'robots')->pluck('option_value');
        });
        $robots      = '';
        if ($seo) {
            foreach (config('admin.robots_meta') as $key => $row) {
                if ($seo->$key) {
                    $robots .= $key . ',';
                }
            }
        }
        $robots     = rtrim(trim($robots), ',');
        $metaRobots = '';
        if ($robots) {
            $metaRobots = $robots;
        } else {
            if (!empty($robotsInput[0])) {
                $metaRobots = $robotsInput[0];
            }
        }

        $metaRobots = rtrim(trim($metaRobots), ',');
        $check      = checkRobotNoIndexNoFollow($metaRobots);
        if ($metaRobots && $type == 1 && !$check) {
            $metaRobots .= ',max-snippet:-1, max-image-preview:large, max-video-preview:-1';
        }

        $metaRobots = rtrim($metaRobots, ',');

        return $metaRobots;
    }
}

function addNofollowContent($content)
{
    $content = preg_replace_callback('/]*href=["|\']([^"|\']*)["|\'][^>]*>([^<]*)<\/a>/i', function ($m) {
        if (strpos($m[1], "phonghacomputer.vn") === false) {
            return ' href="' . $m[1] . '" rel="nofollow" target="_blank">' . $m[2] . '</a>';
        } else {
            return ' href="' . $m[1] . '">' . $m[2] . '</a>';
        }
    }, $content);

    return $content;
}


if (!function_exists('isJson')) {
    function isJson($string) {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}

if (!function_exists('checkNeedCheckOut')) {
    function checkNeedCheckOut($product) {
        $aryCart =  CartClass::getContent();
        $aryConfig = $product->config;

        foreach ($aryCart as $item) {
            if ($product->id == $item->id && $item->attributes->config != 'original' && !empty($aryConfig[$item->attributes->config]['name'])) {
                return true;
            }
        }

        return false;
    }
}


