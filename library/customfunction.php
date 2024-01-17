<?php
function conf($code,$number) {
    global $call;
    $code=strtolower($code);$number=strtolower($number);
    $query = (stristr($number,'c')) ? "SELECT $number FROM conf WHERE code = '$code'" : "SELECT c$number FROM conf WHERE code = '$code'";
    $data = (stristr($number,'c')) ? $number : "c$number";
    return ($call->query($query)->num_rows == 1) ? $call->query($query)->fetch_assoc()[$data] : '';
}

function sessResult($sts,$msg) {
    $alert = ($sts == true) ? 'success' : 'danger';
    $status = ($sts == true) ? 'Success!' : 'Failed!';
    return '<div class="alert bg-'.$alert.' text-white border-0" role="alert"><font style="font-size: 0.9rem;"><strong>Response:</strong> '.$status.'</font><br><font style="font-size: 0.9rem;"><strong>Message:</strong> '.$msg.'</font></div>';
}

function select_opt($select,$opt_val,$opt_name) {
    $selected = ($select == $opt_val) ? ' class="text-primary" style="font-weight:600" selected' : '';
    return '<option value="'.$opt_val.'"'.$selected.'>'.$opt_name.'</option>';
}

function data_user($u, $r = '') {
    $s = squery("SELECT * FROM users WHERE username = '$u'");
    if($s->num_rows == 0) return false; $fa = $s->fetch_assoc();
    if(!empty($r) && !isset($fa[$r])) return false;
    return (!empty($r)) ? $fa[$r] : $fa;
}

function last_trx($u, $t) {
    if($t == 'game') {
        $fa = squery("SELECT date_cr FROM trx_game WHERE user = '$u' ORDER BY id DESC LIMIT 1");
        return ($fa->num_rows == 1) ? $fa->fetch_assoc()['date_cr'] : rdate('Y-m-d H:i:s', '-7 seconds');
    } if($t == 'ppob') {
        $fa = squery("SELECT date_cr FROM trx_ppob WHERE user = '$u' ORDER BY id DESC LIMIT 1");
        return ($fa->num_rows == 1) ? $fa->fetch_assoc()['date_cr'] : rdate('Y-m-d H:i:s', '-7 seconds');
    } if($t == 'socmed') {
        $fa = squery("SELECT date_cr FROM trx_socmed WHERE user = '$u' ORDER BY id DESC LIMIT 1");
        return ($fa->num_rows == 1) ? $fa->fetch_assoc()['date_cr'] : rdate('Y-m-d H:i:s', '-7 seconds');
    }
    return false;
}

function point($price,$profit,$type) {
    if(!in_array($type,['game','ppob','socmed'])) return 0;
    if($type == 'game') { $hlp = conf('trxpoint',1); $amn = conf('trxpoint',2); }
    if($type == 'ppob') { $hlp = conf('trxpoint',3); $amn = conf('trxpoint',4); }
    if($type == 'socmed') { $hlp = conf('trxpoint',5); $amn = conf('trxpoint',6); }
    
    if($hlp == '+') {
        return ($profit < $amn) ? $profit : $amn;
    } else if($hlp == '%') {
        $point = $price * $amn;
        return ($profit < $point) ? $profit : $point;
    } else {
        return 0;
    }
}

function getFCMtoken($u) {
    $search = squery("SELECT token FROM users_cookie WHERE token != '' AND username = '$u'");
    if($search->num_rows > 0) {
        while($row = $search->fetch_assoc()) $token[] = $row['token'];
        return $token;
    }
    return '';
}

function getUserNotif($user, $app, $type) {
    $search = squery("SELECT info FROM users WHERE username = '$user'");
    if($search->num_rows == 1) {
        $data = json_decode($search->fetch_assoc()['info'], true);
        if(isset($data['notification'][$app][$type])) return ($data['notification'][$app][$type] == 'true') ? true : false;
        else return false;
    } else {
        return false;
    }
}

function sendFCMnotif($FCM, $user, $message, $app, $type) {
    global $_CONFIG;
    if($_CONFIG['firebase'] == 'true' && getUserNotif($user, $app, $type) == true)
        $FCM->notifBrowserMulti(getFCMtoken($user), $_CONFIG['title'], $message);
}

function gravatar($email,$s = 80,$d = 'mp',$r = 'x',$img = false,$atts = []) { // default (mail,80,mp,g,false,[])
    $url = 'https://www.gravatar.com/avatar/'.md5(strtolower(trim($email)))."?s=$s&d=$d&r=$r";
    if($img) {
        $url = '<img src="'.$url.'"';
        foreach($atts as $key => $val) $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

function timeProcess($start,$end,$shennsana = false) {
    if($start === $end) {
        return '0 second';
    } else {
        $diff = abs(strtotime($end) - strtotime($start));
        
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

        $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
        $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60) / 60);
        $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));

        $years = ($years >= 1) ? "$years year, " : '';
        $months = ($months >= 1) ? "$months month, " : '';
        $days = ($days >= 1) ? "$days day, " : '';
        $hours = ($hours >= 1) ? "$hours hour, " : '';
        $minutes = ($minutes >= 1) ? "$minutes minute, " : '';
        $seconds = ($seconds >= 1) ? "$seconds seconds" : '';
        $shennboku = "$years$months$days$hours$minutes$seconds";
        
        $out = ''; $array = explode(', ',$shennboku);
        for($i = 0; $i <= count($array)-1; $i++) {
            if($i !== (count($array)-1)) {
                $out .= ($i == (count($array)-2)) ? $array[$i] : $array[$i].', ';
            } else if(stristr($array[$i],'seconds') && $shennsana == true) {
                $out .= ', '.$array[$i];
            }
        }

        return $out;
    }
}

function ulhead($x) {
    print '<li class=" navigation-header"><span>'.$x.'</span></li>';
}

function ul($x) {
    global $_SERVER;$url = 'https://'.$_SERVER['SERVER_NAME'];$li = '';
    for($i = 0; $i <= count($x['content'])-1; $i++) {
        if(isset($x['content'][$i]['name'])) {
            $li .= '<li class="has-submenu';
            if(visited() == $url.$x['content'][$i]['page']) $li .= ' active';
            $li .= '"><a href="'.$url.$x['content'][$i]['page'].'">'.$x['content'][$i]['name'].'</a>';
        }
    }
    $act = (stristr($li,'has-submenu active')) ? ' active' : '';
    print '<li class="has-submenu'.$act.'"><a href="#"><i class="'.$x['icon'].'"></i>'.$x['name'].'</a><ul class="submenu">'.$li.'</ul></li>';
}

function li($name,$icon,$page = '') {
    global $_SERVER;$url = 'https://'.$_SERVER['SERVER_NAME'];
    $li = '<li class="has-submenu';
    if(visited() == $url.$page) $li .= ' active';
    $li .= '"><a href="'.$url.$page.'"><i class="'.$icon.'"></i><span class="nav-label">'.$name.'</span></a>';
    print $li;
}

function lifoot($page = '') {
    global $_SERVER;$url = 'https://'.$_SERVER['SERVER_NAME'];
    if(visited() == $url.$page) $str = 'active-nav';
    return isset($str) ? $str : '';
}

function datatable($x,$y = false,$ms = '3000') {
    $TblId = isset($x['id']) ? $x['id'] : 'datatable';
    $TblCol = isset($x['columns']) ? ',
        "columnDefs": ['.$x['columns'].']' : '';
    if($y == true) {
        return '<script type="text/javascript">
$(document).ready(function() {
    var ShennBoku4102_'.$TblId.' = $(\'#'.$TblId.'\').DataTable({
        "order": [['.$x['sort'].', \''.$x['type'].'\']],
        "processing": false,
        "serverSide": true,
        "paging": true,
        "pagingType": "simple_numbers",
        "ajax": "'.$x['url'].'",
        "keys": !0,
        "drawCallback": function() { $(".dataTables_paginate > .pagination").addClass("pagination-rounded") },
        "language": {
            "emptyTable": "No data in table",
            "info": "Showing _START_ to _END_ of _TOTAL_ data",
            "infoEmpty": "Ex: Paydisini",
            "infoFiltered": "",
            "infoPostFix": "",
            "thousands": ".",
            "lengthMenu": "Show _MENU_ data",
            "loadingRecords": "Waiting...",
            "processing": "Processing...",
            "search": "Search:",
            "searchPlaceholder": "Ex: Paydisini",
            "zeroRecords": "Data not found",
            "paginate": {"first": "First","last": "Last","next": "<i class=\'fa fa-chevron-right\'>","previous": "<i class=\'fa fa-chevron-left\'>"},
            "aria": {"sortAscending": ": activate to sort column ascending","sortDescending": ": activate to sort column descending"}
        }'.$TblCol.'
    });
    
    setInterval(function() {
        ShennBoku4102_'.$TblId.'.ajax.reload(null,false);
    }, '.$ms.');
});
</script>
        ';
    } else {
        return '<script type="text/javascript">
$(document).ready(function() {
    $(\'#'.$TblId.'\').DataTable({
        "order": [['.$x['sort'].', \''.$x['type'].'\']],
        "processing": false,
        "serverSide": true,
        "paging": true,
        "pagingType": "simple_numbers",
        "ajax": "'.$x['url'].'",
        "keys": !0,
        "drawCallback": function() { $(".dataTables_paginate > .pagination").addClass("pagination-rounded") },
        "language": {
            "emptyTable": "No data in table",
            "info": "Showing _START_ to _END_ of _TOTAL_ data",
            "infoEmpty": "Ex: Paydisini",
            "infoFiltered": "",
            "infoPostFix": "",
            "thousands": ".",
            "lengthMenu": "Show _MENU_ data",
            "loadingRecords": "Waiting...",
            "processing": "Processing...",
            "search": "Search:",
            "searchPlaceholder": "Ex: Paydisini",
            "zeroRecords": "Data not found",
            "paginate": {"first": "First","last": "Last","next": "<i class=\'fas fa-chevron-right\'>","previous": "<i class=\'fas fa-chevron-left\'>"},
            "aria": {"sortAscending": ": activate to sort column ascending","sortDescending": ": activate to sort column descending"}
        }'.$TblCol.'
    });
});
</script>
        ';
    }
    
    // Contoh Penggunaan
    // datatable(['id' => 'datatables','url' => 'url filenya','columns' => '{ className: "dt5p", "targets": [2, 3, 4, 8, 9, 12, 13] },{ className: "dtmw200", "targets": [6, 7] }','sort' => 0,'type' => 'desc'])
    // .dt5p { width: 5%; }
    // .dtmw200 { min-width: 200px; }
}

function datatables($x) {
    $TblId = isset($x['id']) ? $x['id'] : 'datatable';
    $TblCol = isset($x['columns']) ? ',
        "columnDefs": ['.$x['columns'].']' : '';
    return '<script type="text/javascript">
$(document).ready(function() {
    $(\'#'.$TblId.'\').DataTable({
        "order": [['.$x['sort'].', \''.$x['type'].'\']],
        "processing": false,
        "serverSide": false,
        "paging": true,
        "pagingType": "simple_numbers",
        "keys": !0,
        "drawCallback": function() { $(".dataTables_paginate > .pagination").addClass("pagination-rounded") },
        "language": {
            "emptyTable": "No data in table",
            "info": "Showing _START_ to _END_ of _TOTAL_ data",
            "infoEmpty": "Ex: Paydisini",
            "infoFiltered": "",
            "infoPostFix": "",
            "thousands": ".",
            "lengthMenu": "Show _MENU_ data",
            "loadingRecords": "Waiting...",
            "processing": "Processing...",
            "search": "Search:",
            "searchPlaceholder": "Ex: Paydisini",
            "zeroRecords": "Data not found",
            "paginate": {"first": "First","last": "Last","next": "<i class=\'fas fa-chevron-right\'>","previous": "<i class=\'fas fa-chevron-left\'>"},
            "aria": {"sortAscending": ": activate to sort column ascending","sortDescending": ": activate to sort column descending"}
        }'.$TblCol.'
    });
});
</script>
    ';
    
    // Contoh Penggunaan
    // datatables(['id' => 'datatables','columns' => '{ className: "dt5p", "targets": [2, 3, 4, 8, 9, 12, 13] },{ className: "dtmw200", "targets": [6, 7] }','sort' => 0,'type' => 'desc'])
    // .dt5p { width: 5%; }
    // .dtmw200 { min-width: 200px; }
}

function ckeditor($x) {
    if(isset($x)) {
        if(is_array($x)) {
            $inc = '<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script><script>';
            for($i = 0; $i <= count($x)-1; $i++) $inc .= "CKEDITOR.replace('".$x[$i]."',{toolbarGroups:[{'name':'basicstyles','groups':['basicstyles']},{'name':'links','groups':['links']},{'name':'paragraph','groups':['list','blocks']},{'name':'document','groups':['mode']},{'name':'insert','groups':['insert']},{'name':'styles','groups':['styles']},{'name':'about','groups':['about']}],removeButtons:'Blockquote,Table,Source,Strike,Subscript,Superscript,Anchor,Styles,SpecialChar,About'});";
            $inc .= '</script>';
            return $inc;
        }
    }
}

function check_lock($user = 'shenn_maintenance_system') {
    global $call;
    if($user == 'shenn_maintenance_system') {
        return ['status' => false];
    } else {
        $s = $call->query("SELECT * FROM users_lock WHERE user = '$user'");
        if($s->num_rows == 1) {
            $d = $s->fetch_assoc();
            return ['status' => true,'reason' => ($d['reason'] == '-') ? 'Account is locked, you do not have access to use this feature.' : $d['reason']];
        } else {
            return ['status' => false];
        }
    }
}

function TrxNotifier($u,$s,$d,$q = '1') {
    global $WATL; global $date; global $time; global $ShennTRX;
    $msg = strtr(base64_decode(conf('addon1',2)), [
        '{{ name }}' => data_user($u,'name'),'{{ username }}' => $u,'{{ service }}' => $s,'{{ trxid }}' => $ShennTRX,'{{ data }}' => $d,'{{ amount }}' => $q,'{{ date }}' => $date,'{{ time }}' => $time,'{{ date-time }}' => "$date $time",
        '{{ date-f-id }}' => format_date('id',$date), '{{ date-f-en }}' => format_date('en',$date), '{{ time-f }}' => substr($time,0,5).' WIB'
    ]);
    return $WATL->sendMessage(conf('addon1',1), $msg);
}

function ShennXit($x = false,$y = 'Safalian Novandika') {
    $z = ($y == 'Safalian Novandika') ? visited() : $y;
    if(is_array($x)) $_SESSION['result'] = $x;
    exit(redirect(0,$z));
}

function ShennDie($x = []) {
    exit(json_encode($x, JSON_PRETTY_PRINT));
}

function delCookie($name) {
    global $_SERVER;
    setcookie($name, '', 1);
    setcookie($name, '', 1, '/');
    setcookie($name, '', 1, '/', '');
    setcookie($name, '', 1, '/', $_SERVER['HTTP_HOST']);
}

function LannSess($x = false,$y = 'Null') {
    $z = ($y == 'Null') ? visited() : $y;
    if(is_array($x)) $_SESSION['result'] = $x;
    exit(redirect(0,$z));
}

function LannGreen($x) { 
  return '<font color="green"><pre>'.$x.'</pre></font>';
}

function LannRed($x) { 
  return '<font color="red"><pre>'.$x.'</pre></font>';
}

function LannCurr($x) {
  return number_format($x, 0, ".", ".");
}

function LannCenter($x) {
  return '<center>'.$x.'</center>';
}

function LannStat($x) {
  if ($x == 'UNREAD') {
    return '<div class="badge badge-danger">Unread</div>';
  } else {
    return '<div class="badge badge-success">Read</div>';
    }
}

function LannStatus($__sta) {
  if ($__sta == "waiting") {
    return '<small><i class="fas fa-circle-notch fa-spin text-warning"></i> Waiting</small>'; 
  } else if ($__sta == "success") {
    return '<small><i class="far fa-check-circle text-success"></i> Success</small>';
  } else if ($__sta == "error") {
    return '<small><i class="far fa-times-circle text-danger"></i> Error</small>';
    }
}

function LannStatusGame($__stagame) {
  if ($__stagame == "waiting") {
    return '<small><i class="fas fa-circle-notch fa-spin text-warning"></i> Waiting</small>'; 
  } else if ($__stagame == "success") {
    return '<small><i class="far fa-check-circle text-success"></i> Success</small>';
  } else if ($__stagame == "error") {
    return '<small><i class="far fa-times-circle text-danger"></i> Error</small>';
    }
}

function LannStatusSocmed($__stasoc) {
  if ($__stasoc == "waiting") {
    return '<small><i class="fas fa-circle-notch fa-spin text-warning"></i> Waiting</small>'; 
  } else if ($__stasoc == "success") {
    return '<small><i class="far fa-check-circle text-success"></i> Success</small>';
  } else if ($__stasoc == "error") {
    return '<small><i class="far fa-times-circle text-danger"></i> Error</small>';
  } else if ($__stasoc == "processing") {
    return '<small><i class="fas fa-circle-notch fa-spin text-info"></i> Processing</small>';
  } else {
    return '<small><i class="far fa-times-circle text-danger"></i> Partial</small>';
    }    
}

function LannGopay($am,$total) {
    return (in_array($am,explode(',',$total))) ? true : false;
}