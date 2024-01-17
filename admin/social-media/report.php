<?php 
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/shennboku.app/admin-transaction-report');
require _DIR_('library/layout/header.admin');
?>
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-end">
                    <h4 class="card-title mb-0">Financial Report - <?= countDay($SDate,$EDate) ?> Days</h4>
                    <a href="javascript:;" <?= onclick_modal('Detail Report', base_url('admin/social-media/report-detail'), 'lg') ?>>
                        <p class="font-medium-5 mb-0"><i class="feather icon-database text-primary cursor-pointer"></i></p>
                    </a>
                </div>
                <div class="card-body card-dashboard">
                    <form method="POST">
                        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                        <div class="row">
                            <div class="form-group col-md-5 col-12">
                                <input type="date" class="form-control" name="start_date" value="<?= $SDate ?>">
                            </div>
                            <div class="form-group col-md-5 col-12">
                                <input type="date" class="form-control" name="end_date" value="<?= $EDate ?>">
                            </div>
                            <div class="form-group col-md-2 col-12">
                                <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">See</button>
                            </div>
                        </div>
                    </form>
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
                                    <td><?= currency(squery("SELECT id FROM trx_socmed WHERE status IN ('partial', 'success') AND DATE(date_cr) BETWEEN '$SDate' AND '$EDate'")->num_rows) ?></td>
                                    <td><?= 'Rp '.currency(squery("SELECT SUM(price) AS x FROM trx_socmed WHERE status IN ('partial', 'success') AND DATE(date_cr) BETWEEN '$SDate' AND '$EDate'")->fetch_assoc()['x']).',-' ?></td>
                                    <td><?= 'Rp '.currency(squery("SELECT SUM(profit) AS x FROM trx_socmed WHERE status IN ('partial', 'success') AND DATE(date_cr) BETWEEN '$SDate' AND '$EDate'")->fetch_assoc()['x']).',-' ?></td>
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
                                    <td><?= currency(squery("SELECT id FROM trx_socmed WHERE provider = '".$row['code']."' AND status IN ('partial', 'success') AND DATE(date_cr) BETWEEN '$SDate' AND '$EDate'")->num_rows) ?></td>
                                    <td><?= 'Rp '.currency(squery("SELECT SUM(price) AS x FROM trx_socmed WHERE provider = '".$row['code']."' AND status IN ('partial', 'success') AND DATE(date_cr) BETWEEN '$SDate' AND '$EDate'")->fetch_assoc()['x']).',-' ?></td>
                                    <td><?= 'Rp '.currency(squery("SELECT SUM(profit) AS x FROM trx_socmed WHERE provider = '".$row['code']."' AND status IN ('partial', 'success') AND DATE(date_cr) BETWEEN '$SDate' AND '$EDate'")->fetch_assoc()['x']).',-' ?></td>
                                </tr>
<? } ?>
                            </tbody>
                        </table>
                    </div>
                    <? if(countDay($SDate,$EDate) >= 2 && countDay($SDate,$EDate) <= 31) { ?>
                    <div id="revenue-chart"></div>
                    <? } else if(countDay($SDate,$EDate) < 2) { ?>
                    <small class="text-danger">Unable to load chart, please extend the timeframe.</small>
                    <? } else if(countDay($SDate,$EDate) > 31) { ?>
                    <small class="text-danger">Unable to load chart, please shorten the timeframe.</small>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<? require _DIR_('library/layout/modal'); require _DIR_('library/layout/footer.user'); ?>
<? if(countDay($SDate,$EDate) >= 2 && countDay($SDate,$EDate) <= 31) { ?>
<script type="text/javascript">
$(window).on("load", function () {
    new ApexCharts(document.querySelector("#revenue-chart"), {
        chart: { height: 270, toolbar: { show: !1 }, type: "line" },
        stroke: { curve: "smooth", dashArray: [0, 8], width: [4, 2] },
        grid: { borderColor: "#e7e7e7" },
        legend: { show: !1 },
        colors: ["#f29292", "#b9c3cd"],
        fill: { type: "gradient", gradient: { shade: "dark", inverseColors: !1, gradientToColors: ["#7367F0", "#b9c3cd"], shadeIntensity: 1, type: "horizontal", opacityFrom: 1, opacityTo: 1, stops: [0, 100, 100, 100] } },
        markers: { size: 0, hover: { size: 5 } },
        xaxis: { labels: { style: { colors: "#b9c3cd" } }, axisTicks: { show: !1 }, categories: [<?php
            for($i = 0; $i < count($dateList); $i++) print '"'.date('d/m', strtotime($dateList[$i])).'",';
        ?>], axisBorder: { show: !1 }, tickPlacement: "on" },
        yaxis: {
            tickAmount: 5,
            labels: {
                style: { color: "#b9c3cd" },
                formatter: function (e) {
                    return 999 < e ? (e / 1e3).toFixed(1) + "k" : e;
                },
            },
        },
        tooltip: { x: { show: !1 } },
        series: [
            { name: "Total Profit", data: [<?php
                for($i = 0; $i < count($dateList); $i++) {
                    $sum = squery("SELECT SUM(profit) AS x FROM trx_socmed WHERE status IN ('partial', 'success') AND date_cr LIKE '".$dateList[$i]."%'")->fetch_assoc()['x'];
                    print ($sum > 0) ? "$sum," : '0,';
                }
            ?>] },
            <? while($row = $search->fetch_assoc()) { ?>
            { name: "<?= $row['name'] ?>", data: [<?php
                for($i = 0; $i < count($dateList); $i++) {
                    $sum = squery("SELECT SUM(profit) AS x FROM trx_socmed WHERE provider = '".$row['code']."' AND status IN ('partial', 'success') AND date_cr LIKE '".$dateList[$i]."%'")->fetch_assoc()['x'];
                    print ($sum > 0) ? "$sum," : '0,';
                }
            ?>] },
            <? } ?>
        ],
    }).render();
});
</script>
<? } ?>