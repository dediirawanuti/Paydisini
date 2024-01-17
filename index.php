<?php
require 'connect.php';

if(!isset($_SESSION['user'])) {
    if(isset($_COOKIE['token']) && isset($_COOKIE['ssid'])) {
        $call->query("DELETE FROM users_cookie WHERE DATEDIFF(expired,'$date') < 0");
        $ShennUID = preg_replace('/[^\d]+/i','',$_COOKIE['ssid']) + 0;
        $ShennKey = $_COOKIE['token'];
        $ShennSSO = sha1(sha1(strtotime(date('Y-m-d H:i:s'))));
        $ShennUser = $call->query("SELECT * FROM users WHERE id = '$ShennUID'")->fetch_assoc();
        if(is_array($ShennUser)) {
            $ShennCheck = $call->query("SELECT * FROM users_cookie WHERE cookie = '$ShennKey' AND username = '".$ShennUser['username']."'");
            if($ShennCheck->num_rows == 1) {
                if($ShennUser['level'] <> 'Admin' && $_CONFIG['mt']['web'] == 'true') {
                } else {
                    $_SESSION['sso'] = $ShennSSO;
                    $_SESSION['user'] = $ShennUser;
                    redirect(0,visited());
                    $call->query("UPDATE users SET sso = '$ShennSSO' WHERE id = ".$ShennUser['id']."");
                    $call->query("UPDATE users_cookie SET active = '$date $time', ua = '$user_agent', ip = '$client_ip' WHERE cookie = '$ShennKey'");
                }
            } else {
                exit(redirect(0,base_url('auth/logout')));
            }
        } else {
            exit(redirect(0,base_url('auth/logout')));
        }
    }
}

if(!isset($_SESSION['user'])) {
    redirect(0,base_url('landing'));
} else {
    require _DIR_('library/session/user');
    
    $check_user22 = mysqli_query($call, "SELECT * FROM trx_socmed WHERE user = '$sess_username'");
	$data_order22 = mysqli_num_rows($check_user22); 
	
	$check_order = mysqli_query($call, "SELECT SUM(price) AS total FROM trx_socmed WHERE user = '$sess_username'");
	$data_order = mysqli_fetch_assoc($check_order);
	
	$check_worder2w2 = mysqli_query($call, "SELECT * FROM deposit WHERE user = '$sess_username'");
	$data_worder22 = mysqli_num_rows($check_worder2w2);
	
	$check_worder = mysqli_query($call, "SELECT SUM(amount) AS total FROM deposit WHERE user = '$sess_username'");
	$data_worder = mysqli_fetch_assoc($check_worder);

    function OBX($x) {
        if(is_array($x)) {
            for($i = 0; $i <= count($x)-1; $i++) {
                $display = isset($x[$i]['display']) ? $x[$i]['display'] : '';
                if(isset($x[$i]['action']) && isset($x[$i]['image']) && isset($x[$i]['name']) && $display == 'true') {
                    $ShennOut['view'][] = base64_encode('
            <div class="_24EoF">
                <a href="javascript:;" '.onclick_href(base_url($x[$i]['action'])).'>
                    <div class="avatar avatar-40 no-shadow border-0">
                        <div class="overlay gradient-primary"><img class="img-fluid" src="'.$x[$i]['image'].'" alt="'.$x[$i]['name'].'" style="height: 30px;"></div>
                    </div><span title="'.$x[$i]['name'].'">'.$x[$i]['name'].'</span>
                </a>
            </div>');
                }
            }
            $count = count($ShennOut['view'])/4;
            $count = (stristr($count,'.')) ? 4*(explode('.',$count)[0] + 1) : 4*$count;
            for($i = 0; $i <= $count-1; $i++) print (isset($ShennOut['view'][$i])) ? base64_decode($ShennOut['view'][$i]) : '<div class="_3xM0V"></div>';
        }
    }
    
    $search_banner = $call->query("SELECT * FROM information WHERE `type` = 'banner'");
    if($search_banner->num_rows == 0) {
        $banner[] = base_url('library/assets/banner/LannJPG.jpg');
    } else {
        while($row_banner = $search_banner->fetch_assoc()) {
            $banner[] = $row_banner['content'];
        }
    }

    require _DIR_('library/layout/header.user');
?>
<div class="row">
    <div class="col-lg-6">
        <div class="card-box tilebox-one">
            <i class="mdi mdi-cart float-right"></i>
            <h6 class="text-muted text-uppercase mb-3">Total Pesanan</h6>
            <h4 class="mb-3"><?php echo $data_order22; ?></h4>
            <span> Dengan Total Harga</span> <span class="text-muted ml-2 vertical-middle">Rp <?php echo number_format($data_order['total'],0,',','.'); ?></span>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card-box tilebox-one">
            <i class="mdi mdi-cart float-right"></i>
            <h6 class="text-muted text-uppercase mb-3">Total Deposit</h6>
            <h4 class="mb-3"><?php echo $data_worder22; ?></h4>
            <span> Dengan Total Deposit</span> <span class="text-muted ml-2 vertical-middle">Rp <?php echo number_format($data_worder['total'],0,',','.'); ?></span>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card m-b-30">
        <h6 class="card-header"><i class="mdi mdi-newspaper"></i> Berita & Informasi</h6>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-box">
                    <thead>
                    <tr>
                        <th style="width: 200px;">Tanggal & Waktu</th>
                        <th style="width: 150px;">Kategori</th>
                        <th>Konten</th>
                    </tr>
                    </thead>
                        <tbody>
                             <?php
                                $check_news = mysqli_query($call, "SELECT * FROM information WHERE `type` != 'banner' ORDER BY id DESC LIMIT 5");
                                $no = 1;
                                while ($data_news = mysqli_fetch_assoc($check_news)) {
                                    if($data_news['type'] == "news") {
                                        $label = "primary";
                                    } else if($data_news['type'] == "info") {
                                        $label = "info";
                                    } else if($data_news['type'] == "update") {
                                        $label = "danger";
                                    } else if($data_news['type'] == "maintenance") {
                                        $label = "danger";
                                    }
                                ?>
                                <tr>
                                <td><?= format_date('id',$data_news['date']) ?></td>                                                  
                                <td align="center"><label class="badge badge-<?php echo $label; ?>"><?php echo strtoupper($data_news['type']); ?></label></td>
                                <td><?= base64_decode($data_news['content']) ?></td>
                                </tr>
                            <?php
                            $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<? require _DIR_('library/layout/footer.user'); } ?>