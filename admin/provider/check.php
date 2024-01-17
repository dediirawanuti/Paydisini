<?php
require '../../connect.php';
require _DIR_('library/session/session');
require _DIR_('library/shennboku.app/admin-provider');

$code = isset($_GET['s']) ? filter(base64_decode($_GET['s'])) : '';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if($data_user['level'] !== 'Admin') exit("No direct script access allowed!");
    if(!isset($code) || !$code) exit("No direct script access allowed!");
    $search = $call->query("SELECT * FROM provider WHERE code = '$code'");
    if($search->num_rows == 0) exit("No data found from the Code!");
    $data = $search->fetch_assoc();
    $res = ShennCheck($code,$data['userid'],$data['apikey']);
?>
<form method="POST">
    <?php if($res['type'] == true) { ?>
    <div class="alert bg-primary text-white border-0" style="border-radius:5px" role="alert">
        <font style="font-size: 0.9rem;">Response: </font>Success!<br>
        <font style="font-size: 0.9rem;">Message: </font>Connection Test Successful!
        <?php
        if(isset($res['data'])) {
            print '<hr>';
            foreach($res['data'] as $key => $value) {
                $value = is_numeric($value) ? currency($value) : $value;
                print '<font style="font-size: 0.9rem;">'.ucfirst($key).': </font>'.$value.'<br>';
            }
        }
        ?>
    </div>
    <?php } else if($res['type'] == false) { ?>
    <div class="alert bg-danger text-white border-0" style="border-radius:5px" role="alert">
        <font style="font-size: 0.9rem;">Response: </font>Failed!<br>
        <font style="font-size: 0.9rem;">Message: </font><?= $res['msg'] ?>
    </div>
    <?php } ?>
    <div class="form-group">
        <button type="button" class="btn btn-dark btn-block" data-dismiss="modal"> CLOSE </button>
    </div>
</form>
<?php
} else {
    exit("No direct script access allowed!");
}
?>