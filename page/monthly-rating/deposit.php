<?php 
require '../../connect.php';
require _DIR_('library/session/user');
if(conf('xtra-fitur',4) <> 'true') exit(redirect(0,base_url()));
require _DIR_('library/layout/header.user');

$order_month = $call->query("SELECT SUM(deposit.amount) AS tamount, count(deposit.id) AS tcount, deposit.user, users.name FROM deposit JOIN users ON deposit.user = users.username WHERE MONTH(deposit.date) = '".date('m')."' AND YEAR(deposit.date) = '".date('Y')."' AND deposit.status = 'paid' GROUP BY deposit.user ORDER BY tamount DESC LIMIT 5");
$order_day = $call->query("SELECT SUM(deposit.amount) AS tamount, count(deposit.id) AS tcount, deposit.user, users.name FROM deposit JOIN users ON deposit.user = users.username WHERE deposit.date LIKE '$date%' AND deposit.status = 'paid' GROUP BY deposit.user ORDER BY tamount DESC LIMIT 5");
?>
<div class="row">
    <div class="col-12 text-center mb-2">
        <h3><i class="fas fa-award fa-fw"></i>PENGGUNA TERATAS</h3>
        <p>Dibawah Ini Merupakan Top Pengguna Dengan Total Deposit Tertinggi Bulan Ini.<br>Terima Kasih Telah Menjadi Pelanggan Setia Kami!</p>
    </div>
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="header-title">
                    <i class="feather icon-award mr-1"></i>TOP 5 Today
                </h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? $rank = 1; while($row = $order_day->fetch_assoc()) { ?>
							<tr<?= ($rank == 1) ? ' style="background-color:#F3E2A9"' : '' ?>>
								<td class="text-center"><?= $rank ?></td>
								<td><?= ($rank == 1) ? '<i class="fas fa-crown text-warning mr-1"></i>'.$row['name'] : $row['name'] ?></td>
								<td>Rp <?= currency($row['tamount']) ?> (<?= currency($row['tcount']) ?>)</td>
							</tr>
							<? $rank++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="header-title">
                    <i class="feather icon-award mr-1"></i>TOP 5 This Month
                </h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? $rank = 1; while($row = $order_month->fetch_assoc()) { ?>
							<tr<?= ($rank == 1) ? ' style="background-color:#F3E2A9"' : '' ?>>
								<td class="text-center"><?= $rank ?></td>
								<td><?= ($rank == 1) ? '<i class="fas fa-crown text-warning mr-1"></i>'.$row['name'] : $row['name'] ?></td>
								<td>Rp <?= currency($row['tamount']) ?> (<?= currency($row['tcount']) ?>)</td>
							</tr>
							<? $rank++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<? require _DIR_('library/layout/footer.user'); ?>