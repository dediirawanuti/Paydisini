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
    $data_coor = explode(', ', $row['coor']);
    if(!isset($data_coor[1])) exit('Location Access not found.');
?>
<iframe src="<?= ajaxlib('iframe/users-location?__v=3&u='.$row['username'].'&c='.$get_cookie) ?>" style="border:none;" loading="lazy" width="100%" height="400"></iframe>
<?php
} else {
    exit("No direct script access allowed!");
}
?>