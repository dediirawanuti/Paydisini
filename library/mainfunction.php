<?php
$client_ip = client_ip();
$client_iploc = client_iploc($client_ip);
$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'unknown';
$device = isset($_SERVER['HTTP_USER_AGENT']) ? devices() : 'unknown';

##########################################################################################################################################

function onclick_modal($x,$y,$z = 'md') { return 'onclick="modal(\''.$x.'\',\''.$y.'\',\''.$z.'\')"'; }
function onclick_href($x) { return 'onclick="javascript:location.href=\''.$x.'\'"'; }
function SpaceGhost($v) { return preg_replace('/\s+/', ' ', $v); }
function currency($value) { return number_format($value, 0, ".", "."); }
function squery($x) { global $call; return $call->query($x); }
function rdate($f,$x = '-0 days') { return date($f, strtotime($x, strtotime(date('Y-m-d H:i:s')))); }

function bcrypt($password,$cost = 'default') {
    $x = (!is_numeric($cost)) ? '10' : $cost;
    return password_hash($password, PASSWORD_DEFAULT, ['cost' => $x]);
}

function check_bcrypt($post,$hashed) {
    return (password_verify($post, $hashed)) ? true : false;
}

function date_diffs($start,$end,$opt = '?') {
    $diff = date_diff(date_create($start),date_create($end));
    $diffY = $diff->y;
    $diffM = $diff->m;
    $diffD = $diff->d;
    $diffH = $diff->h;
    $diffI = $diff->i;
    $diffS = $diff->s;
    $array = [
        'year' => ($diffY + $diffM / 12 + $diffD / 365.25),
        'month' => ($diffY * 12 + $diffM + $diffD/30 + $diffH / 24),
        'day' => ($diffY * 365.25 + $diffM * 30 + $diffD + $diffH/24 + $diffI / 60),
        'hour' => (($diffY * 365.25 + $diffM * 30 + $diffD) * 24 + $diffH + $diffI/60),
        'minute' => ((($diffY * 365.25 + $diffM * 30 + $diffD) * 24 + $diffH) * 60 + $diffI + $diffS/60),
        'second' => (((($diffY * 365.25 + $diffM * 30 + $diffD) * 24 + $diffH) * 60 + $diffI)*60 + $diffS)
    ];
    return (isset($array[$opt])) ? (($diff->invert) ? (-1 * $array[$opt]) : $array[$opt]) : '';
}


function timeAgo($time) {
    global $_SERVER;
    date_default_timezone_set('Asia/Jakarta');
    $time_difference = (!strtotime($time)) ? time() - $time : time() - strtotime($time);

    if($time_difference < 1 ) return '1 sec ago';
    $condition = [
        12 * 30 * 24 * 60 * 60  => 'year',
        30 * 24 * 60 * 60       => 'month',
        24 * 60 * 60            => 'day',
        60 * 60                 => 'hour',
        60                      => 'min',
        1                       => 'sec'
    ];

    foreach($condition as $secs => $str ) {
        $d = $time_difference / $secs;
        if($d >= 1) {
            $t = round($d);
            return $t.' '.$str.($t > 1 ? 's' : '').' ago';
        }
    }
}

function redirect($sec,$loc) {
    if($sec == 0 || $sec == '0') {
        return header("Location: $loc");
    } else {
        echo "<meta http-equiv='refresh' content='$sec;url=$loc'>";
    }
}

function countDay($start,$end) {
    $diff = date_diff(date_create($start),date_create($end));
    return str_replace('+','',$diff->format("%R%a"));
}

function visited() {
    global $_SERVER;
    $base = (isset($_SERVER['REDIRECT_URL'])) ? 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['REDIRECT_URL'] : 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    return explode('?',$base)[0];
}

function random($length) {
    $str = '';
    $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
    $max = count($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}

function random_number($length) {
    $str = ""; $characters = array_merge(range('0','9'));
    $max = count($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}

function RandomKey($value,$max) {
    $apikey1 = str_shuffle(hash('whirlpool',md5(password_hash(date("dmY").rand(100000,900000),PASSWORD_DEFAULT)).bin2hex(random_bytes(100))));
    $apikey2 = str_shuffle(hash('whirlpool',md5(password_hash(date("h:i:s").rand(100000,900000),PASSWORD_DEFAULT)).bin2hex(random_bytes(100))));
    $apikey3 = str_shuffle(hash('whirlpool',md5(password_hash(date("dmY h:i:s").rand(100000,900000),PASSWORD_DEFAULT)).bin2hex(random_bytes(100))));
    $apikey4 = md5(password_hash($value,PASSWORD_DEFAULT)).md5($apikey3.$apikey2.$apikey1).hash('whirlpool',$apikey3.$apikey2.$apikey1);
    $apikey5 = $apikey4.$apikey1.$apikey2.$apikey3.hash('whirlpool',$apikey1.$apikey2.$apikey3).md5($apikey1.$apikey2.$apikey3);
    $apikey6 = str_shuffle(hash('whirlpool',$apikey1).bin2hex(random_bytes(100)));
    $apikey7 = str_shuffle(hash('whirlpool',$apikey2).bin2hex(random_bytes(100)));
    $apikey8 = str_shuffle(hash('whirlpool',$apikey3).bin2hex(random_bytes(100)));
    $apikey = $apikey1.$apikey8.$apikey2.$apikey7.$apikey3.$apikey6.$apikey4.$apikey5;
    return substr($apikey, 0, $max);
}

function devices() {
    global $_SERVER;
    $ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$ua)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($ua,0,4))){
        return 'mobile';
    } else {
        return 'desktop';
    }
}

function base64($type,$data) {
    if($type == 'encode') return base64_encode($data);
    if($type == 'decode') return base64_decode($data);
    if($type == 'check') return (base64_encode(base64_decode($data)) == $data) ? (!trim(stripslashes(strip_tags(htmlspecialchars(base64_decode($data),ENT_QUOTES))))) ? false : true : false;
    if($type == 'auto') return (base64_encode(base64_decode($data)) == $data) ? (!trim(stripslashes(strip_tags(htmlspecialchars(base64_decode($data),ENT_QUOTES))))) ? base64_encode($data) : $data : base64_encode($data);
    if(!in_array($type,['encode','decode','check','auto'])) return false;
}

function validate_date($date) {
	$d = DateTime::createFromFormat('Y-m-d', $date);
	$v = $d && $d->format('Y-m-d') == $date;
	return ($v == true) ? true : false;
}

function format_date($lang,$ymd_format) {
    $ymdhis = explode(' ',$ymd_format);
    if($lang == 'id') {
        $month = [
            1 => 'Januari','Februari','Maret','April','Mei','Juni',
            'Juli','Agustus','September','Oktober','November','Desember'
        ];
        $explode = explode('-', $ymdhis[0]);
        $formatted = $explode[2].' '.$month[(int)$explode[1]].' '.$explode[0];
        $format = isset($ymdhis[1]) ? $formatted.' ('.substr($ymdhis[1],0,5).' WIB)' : $formatted;
    } else if($lang == 'en') {
        $month = [
            1 =>   'January','February','March','April','May','June',
            'July','August','September','October','November','December'
        ];
        $explode = explode('-', $ymdhis[0]);
        $formatted = $month[(int)$explode[1]].' '.$explode[2].', '.$explode[0];
        $format = isset($ymdhis[1]) ? $formatted.' ('.substr($ymdhis[1],0,5).' WIB)' : $formatted;
    } else {
        $format = '';
    }
    
    return $format;
}

function base_url($x = '') {
    global $_SERVER;
    return 'https://'.$_SERVER['SERVER_NAME'].'/'.$x;
}

function base_api_url($x = '') {
    global $_SERVER;
    return 'https://api.'.str_replace('www.','',$_SERVER['SERVER_NAME']).'/'.$x;
}

function assets($x) {
    return base_url('library/assets/'.$x);
}

function ajaxlib($x) {
    return base_url('library/ajax/'.$x);
}

function filter($data) {
    global $call;
    return $call->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)))));
}

function filter_entities($data) {
    global $call;
    return $call->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars(htmlentities($data,ENT_QUOTES))))));
}

function filter_phone($type,$number) {
    $phone = preg_replace("/[^0-9]/", '', filter_entities($number));
    $change = '';
    if($type == '0') {
        if(substr($phone,0,3) == '+62'){ $change = '0'.substr($phone,3); }
        else if(substr($phone, 0, 2) == '62'){ $change = '0'.substr($phone,2); }
        else if(substr($phone, 0, 1) == '0') { $change = $phone; }
    } else {
        if(substr($phone,0,3) == '+62'){ $change = substr($phone,1); }
        else if(substr($phone, 0, 2) == '62'){ $change = $phone; }
        else if(substr($phone, 0, 1) == '0') { $change = '62'.substr($phone,1); }
    }
    return $change;
}

function client_ip() {
    if(getenv('HTTP_CLIENT_IP')) { $str = getenv('HTTP_CLIENT_IP'); } 
    else if(getenv('HTTP_X_FORWARDED_FOR')) { $str = getenv('HTTP_X_FORWARDED_FOR'); } 
    else if(getenv('HTTP_X_FORWARDED')) { $str = getenv('HTTP_X_FORWARDED'); } 
    else if(getenv('HTTP_FORWARDED_FOR')) { $str = getenv('HTTP_FORWARDED_FOR'); } 
    else if(getenv('HTTP_FORWARDED')) { $str = getenv('HTTP_FORWARDED'); } 
    else if(getenv('REMOTE_ADDR')) { $str = getenv('REMOTE_ADDR'); } 
    else { $str = 'Unknown'; }
    return explode(',',$str)[0];
}

function client_iploc($ip) {
    $get1 = @file_get_contents("http://www.geoplugin.net/php.gp?ip=$ip");
    if($get1 === false) {
        $get2 = @file_get_contents("http://ip-api.com/php/$ip"); // limit 150/minutes
        if($get2 === false) {
            $ref = 'Unknown';
        } else {
            $get2u = @json_decode($get2, true);
            if(isset($get2u['countryCode'])) {
                $ref = ($get1u['city'] == '') ? $get1u['countryCode'] : $get1u['city'].' '.$get1u['countryCode'];
                if(!$ref) $ref = 'Unknown';
            } else {
                $ref = 'Unknown';
            }
        }
    } else {
        $get1u = @json_decode($get1, true);
        if(isset($get1u['geoplugin_countryCode'])) {
            $ref = ($get1u['geoplugin_city'] == '') ? $get1u['geoplugin_countryCode'] : $get1u['geoplugin_city'].' '.$get1u['geoplugin_countryCode'];
            if(!$ref) $ref = 'Unknown';
        } else {
            $ref = 'Unknown';
        }
    }
    return $ref;
}

function check_ip($ip,$wl) {
    return (in_array($ip,explode(',',$wl))) ? true : false;
}

function LannCheckVocOwn($voc,$xwl) {
    return (in_array($voc,explode(',',$xwl))) ? true : false;
}