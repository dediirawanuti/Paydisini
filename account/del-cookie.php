<?php
require '../connect.php';
require _DIR_('library/session/session');

$get_cookie = isset($_GET['__c']) ? filter($_GET['__c']) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if(!$get_cookie) exit('No direct script access allowed!');
    $search = $call->query("SELECT * FROM users_cookie WHERE cookie = '$get_cookie' AND username = '$sess_username'");
    if($search->num_rows == false) exit('SignIn Access not found.');
    $row = $search->fetch_assoc();
    
    $activeNow = ($row['cookie'] <> $_COOKIE['token'])
                ? (date_diffs($row['active'],$dtme,'second') < 86400)
                    ? timeAgo($row['active'])
                    : format_date('en',$row['active'])
                : '<b class="text-success">Active now</b>';
?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($row['cookie']) ?>">
    <table style="font-size:0.8rem;border-collapse:separate;border-spacing:1px;">
        <tbody>
            <tr>
                <td>OS</td>
                <td>:</td>
                <td><?= ucfirst($row['dev']) ?></td>
            </tr>
            <tr>
                <td>Device</td>
                <td>:</td>
                <td><?= ucfirst($row['ud']) ?></td>
            </tr>
            <tr>
                <td>IP Locate</td>
                <td>:</td>
                <td><?= $row['ip'].' ['.$row['loc'].']' ?></td>
            </tr>
            <tr>
                <td>Last Active</td>
                <td>:</td>
                <td><?= $activeNow ?></td>
            </tr>
        </tbody>
    </table>
    <hr>
    <div class="row">
        <div class="form-group col-6">
            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
        </div>
        <div class="form-group col-6">
            <button type="submit" name="del_cookie" class="btn btn-primary btn-block"> SIGNOUT </button>
        </div>
    </div>
</form>
<?php
} else {
    exit("No direct script access allowed!");
}
?>