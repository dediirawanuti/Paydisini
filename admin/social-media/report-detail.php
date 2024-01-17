<?php
require '../../connect.php';
require _DIR_('library/session/session');

$get_id = (isset($_GET['id'])) ? $_GET['id'] : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if($data_user['level'] !== 'Admin') exit("No direct script access allowed!");
?>
<div class="table-responsive">
    <table class="table table-striped table-bordered zero-configuration" width="100%">
        <thead>
            <tr>
                <th>Total Order</th>
                <th>Gross Income</th>
                <th>Net Income</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= currency(squery("SELECT id FROM trx_socmed WHERE status IN ('partial', 'success')")->num_rows) ?></td>
                <td><?= 'Rp '.currency(squery("SELECT SUM(price) AS x FROM trx_socmed WHERE status IN ('partial', 'success')")->fetch_assoc()['x']).',-' ?></td>
                <td><?= 'Rp '.currency(squery("SELECT SUM(profit) AS x FROM trx_socmed WHERE status IN ('partial', 'success')")->fetch_assoc()['x']).',-' ?></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="table-responsive">
    <table class="table table-striped table-bordered zero-configuration" width="100%">
        <thead>
            <tr>
                <th>Provider</th>
                <th>Total Order</th>
                <th>Gross Income</th>
                <th>Net Income</th>
            </tr>
        </thead>
        <tbody>
<?php
$search = $call->query("SELECT code, name FROM provider ORDER BY name ASC");
while($row = $search->fetch_assoc()) {
?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= currency(squery("SELECT id FROM trx_socmed WHERE provider = '".$row['code']."' AND status IN ('partial', 'success')")->num_rows) ?></td>
                <td><?= 'Rp '.currency(squery("SELECT SUM(price) AS x FROM trx_socmed WHERE provider = '".$row['code']."' AND status IN ('partial', 'success')")->fetch_assoc()['x']).',-' ?></td>
                <td><?= 'Rp '.currency(squery("SELECT SUM(profit) AS x FROM trx_socmed WHERE provider = '".$row['code']."' AND status IN ('partial', 'success')")->fetch_assoc()['x']).',-' ?></td>
            </tr>
<? } ?>
        </tbody>
    </table>
</div>
<?php
} else {
    exit("No direct script access allowed!");
}
?>