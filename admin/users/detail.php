<?php
require '../../connect.php';
require _DIR_('library/session/session');

$get_uid = (isset($_GET['uid'])) ? $_GET['uid'] : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if($data_user['level'] !== 'Admin') exit("No direct script access allowed!");
    $search = $call->query("SELECT * FROM users WHERE id = '$get_uid'");
    if($search->num_rows == 0) exit("User not found!");
    $row = $search->fetch_assoc();
    
    $data_lock = $call->query("SELECT * FROM users_lock WHERE user = '".$row['username']."'");
    if($data_lock->num_rows == 1) $data_lock = $data_lock->fetch_assoc();
    
    $out_status = '<i class="feather icon-x-circle text-danger"></i> Account is Not Active!';
    if($row['status'] == 'active') $out_status = '<i class="feather icon-check-circle text-success"></i> Account is Active!';
    if($row['status'] == 'active' && is_array($data_lock)) $out_status = ' <i class="feather icon-lock text-danger"></i> '.$data_lock['reason'];

    $data_uplink = $call->query("SELECT * FROM users WHERE referral = '".$row['uplink']."'");
    if($data_uplink->num_rows == 1) $data_uplink = $data_uplink->fetch_assoc();
    $total_referral = $call->query("SELECT * FROM users WHERE uplink = '".$row['referral']."'")->num_rows;
    
    $out_regby = $row['uplink'].' <i class="feather icon-help-circle text-warning"></i>';
    if(is_array($data_uplink)) $out_regby = $data_uplink['name'].' - '.$data_uplink['username'].' <i class="feather icon-check-circle text-success"></i>';
    
    $search_location = $call->query("SELECT * FROM users_location WHERE user = '".$row['username']."'");
?>
<div class="card-body card-dashboard">
    <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="profile-tab-fill" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="false">Detail</a>
        </li>
        <? if($search_location->num_rows > 0) { ?>
        <li class="nav-item">
            <a class="nav-link" id="home-tab-fill" data-toggle="tab" href="#location" role="tab" aria-controls="location" aria-selected="false">Location</a>
        </li>
        <? } ?>
    </ul>
    <div class="tab-content">
        <div class="tab-pane show active" id="detail">
            <div class="table-responsive">
                <table class="table table-bordered" style="border:1px solid #dee2e6;">
                    <tbody>
                        <tr><th>Full Name</th><td><?= $row['name'] ?></td></tr>
                        <tr><th>Email Address</th><td><?= $row['email'] ?></td></tr>
                        <tr><th>Phone Number</th><td><?= $row['phone'] ?></td></tr>
                        <tr><th>Username</th><td><?= $row['username'] ?></td></tr>
                        <tr><th>Balance</th><td><?= 'Rp '.currency($row['balance']) ?></td></tr>
                        <tr><th>Point</th><td><?= 'Rp '.currency($row['point']) ?></td></tr>                       
                        <tr><th>Level</th><td><?= $row['level'] ?></td></tr>
                        <tr><th>Referral</th><td><?= $row['referral'].' ('.currency($total_referral).')' ?></td></tr>
                        <tr><th>Registered By</th><td><?= $out_regby ?></td></tr>
                        <tr><th>Status</th><td><?= $out_status ?></td></tr>
                        <tr><th>Joined</th><td><?= format_date('en',$row['date']) ?></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <? if($search_location->num_rows > 0) { ?>
        <div class="tab-pane" id="location">
            <iframe src="<?= ajaxlib('iframe/users-location?__v=2&u='.$row['username']) ?>" style="border:none;" loading="lazy" width="100%" height="400"></iframe>
        </div>
        <? } ?>
    </div>
</div>
<?php
} else {
    exit("No direct script access allowed!");
}
?>