<?php 
require '../connect.php';
require _DIR_('library/session/user');
require _DIR_('library/shennboku.app/account-signin-access');
require _DIR_('library/layout/header.user');
?>
<section id="basic-datatable">
    <style type="text/css">input[type='text']{font-size:12px}table.datatable td{font-size: 12px;vertical-align:middle}</style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        SignIn Access
                        <br>
                        <font class="text-danger" size="1rem">*Allow this website to get your location every time you log in.</font>
                    </h4>
                </div>
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration datatable" id="datatable" width="100%">
                            <thead>
                                <tr>
                                    <th colspan="3">Where You're Logged In</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$search = $call->query("SELECT * FROM users_cookie WHERE username = '$sess_username' ORDER BY active DESC");
while($row = $search->fetch_assoc()) {
    $devExp = explode('; ',explode(')',explode('(',$row['ua'])[1])[0]);
    $devModel = (!in_array(strtolower($row['ud']),['mobile','tablet'])) ? ucfirst($row['dev']) : end($devExp);
    $activeNow = ($row['cookie'] <> $_COOKIE['token'])
                ? (date_diffs($row['active'],$dtme,'second') < 86400)
                    ? timeAgo($row['active'])
                    : format_date('en',$row['active'])
                : '<b class="text-success">Active now</b>';
    $data_coor = explode(', ', $row['coor']);
    $devIcon = "icon-help-circle";
    if(strtolower($row['ud']) == 'desktop') $devIcon = 'feather icon-monitor';
    if(strtolower($row['ud']) == 'tablet') $devIcon = 'feather icon-tablet';
    if(strtolower($row['ud']) == 'mobile') $devIcon = 'feather icon-smartphone';
?>
                                <tr>
                                    <td width="2%"><center><i class="<?= $devIcon ?> font-large-1"></i></center></td>
                                    <td class="text-bold-500">
                                        <?= $devModel ?> &middot; <?= $row['ip'] ?><br>
                                        <?= ucfirst($row['browser']) ?> &middot; <?= $activeNow ?>
                                    </td>
                                    <td>
                                        <center>
                                            <? if(isset($data_coor[1])) { ?>
                                            <a href="javascript:;" class="font-medium-5 mr-1" style="text-decoration:none;" <?= onclick_modal('SignIn Location', base_url('account/geolocation?__c='.$row['cookie']), 'lg') ?>>
                                                <i class="feather icon-map-pin"></i>
                                            </a>
                                            <? } ?>
                                            <a href="javascript:;" class="font-medium-5 <?= (isset($data_coor[1])) ? 'ml-1' : '' ?>" style="text-decoration:none;" <?= onclick_modal('SignOut', base_url('account/del-cookie?__c='.$row['cookie']), 'md') ?>>
                                                <i class="feather icon-power"></i>
                                            </a>
                                        </center>
                                    </td>
                                </tr>
<?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<? require _DIR_('library/layout/modal'); require _DIR_('library/layout/footer.user'); ?>