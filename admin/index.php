<?php
require '../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/layout/header.admin');

$session_device_query = "SELECT cookie FROM users_cookie";
$session_device_count = $call->query($session_device_query)->num_rows;
$session_device_unknown = $call->query("$session_device_query WHERE ud = 'unknown'")->num_rows;
$session_device_desktop = $call->query("$session_device_query WHERE ud = 'Desktop'")->num_rows;
$session_device_mobile = $call->query("$session_device_query WHERE ud = 'Mobile'")->num_rows;
$session_device_tablet = $call->query("$session_device_query WHERE ud = 'Tablet'")->num_rows;

$browser_search = $call->query("SELECT browser FROM users_cookie ORDER BY browser ASC");
while($browser_data = $browser_search->fetch_assoc()) {
    if(!isset($browser_stats[$browser_data['browser']])) $browser_stats[$browser_data['browser']] = 1;
    else $browser_stats[$browser_data['browser']] += 1;
    if(!isset($browser_stats['total_stats'])) $browser_stats['total_stats'] = 1;
    else $browser_stats['total_stats'] += 1;
}

$device_search = $call->query("SELECT dev FROM users_cookie ORDER BY dev ASC");
while($device_data = $device_search->fetch_assoc()) {
    if(!isset($device_stats[$device_data['dev']])) $device_stats[$device_data['dev']] = 1;
    else $device_stats[$device_data['dev']] += 1;
    if(!isset($device_stats['total_stats'])) $device_stats['total_stats'] = 1;
    else $device_stats['total_stats'] += 1;
}

$total_active_users = $call->query("SELECT id FROM users WHERE status = 'active'")->num_rows;
$total_deposit_paid = $call->query("SELECT id FROM deposit WHERE status = 'paid'")->num_rows;
$total_success_game = $call->query("SELECT id FROM trx_game WHERE status = 'success'")->num_rows;
$total_success_ppob = $call->query("SELECT id FROM trx_ppob WHERE status = 'success'")->num_rows;
$total_success_socmed = $call->query("SELECT id FROM trx_socmed WHERE status IN ('partial','success')")->num_rows;
$total_price_game = $call->query("SELECT SUM(price) AS x FROM trx_game WHERE status = 'success'")->fetch_assoc()['x'];
$total_price_ppob = $call->query("SELECT SUM(price) AS x FROM trx_ppob WHERE status = 'success'")->fetch_assoc()['x'];
$total_price_socmed = $call->query("SELECT SUM(price) AS x FROM trx_socmed WHERE status IN ('partial','success')")->fetch_assoc()['x'];

$revenue_this_month = $call->query("SELECT SUM(profit) AS x FROM trx_game WHERE status = 'success' AND MONTH(date_cr) = '".date('m')."' AND YEAR(date_cr) = '".date('Y')."'")->fetch_assoc()['x']
                
                    + $call->query("SELECT SUM(profit) AS x FROM trx_ppob WHERE status = 'success' AND MONTH(date_cr) = '".date('m')."' AND YEAR(date_cr) = '".date('Y')."'")->fetch_assoc()['x']
                 
                    + $call->query("SELECT SUM(profit) AS x FROM trx_socmed WHERE status IN ('partial','success') AND MONTH(date_cr) = '".date('m')."' AND YEAR(date_cr) = '".date('Y')."'")->fetch_assoc()['x'];
                    
$revenue_last_month = $call->query("SELECT SUM(profit) AS x FROM trx_game WHERE status = 'success' AND MONTH(date_cr) = '".rdate('m','-1 month')."' AND YEAR(date_cr) = '".rdate('Y','-1 month')."'")->fetch_assoc()['x']
                    + $call->query("SELECT SUM(profit) AS x FROM trx_ppob WHERE status = 'success' AND MONTH(date_cr) = '".rdate('m','-1 month')."' AND YEAR(date_cr) = '".rdate('Y','-1 month')."'")->fetch_assoc()['x']
                    + $call->query("SELECT SUM(profit) AS x FROM trx_socmed WHERE status IN ('partial','success') AND MONTH(date_cr) = '".rdate('m','-1 month')."' AND YEAR(date_cr) = '".rdate('Y','-1 month')."'")->fetch_assoc()['x'];
?>
<div class="row">
    <div class="col-md-4 col-12">
        <div class="card m-b-30">
            <div class="card-header d-flex justify-content-between align-items-end">
                <h4>Sessions By Device</h4>
            </div>
            <div class="card-content">
                <div class="card-body pt-50">
                    <div id="session-by-device" class="mb-1"></div>
                    <div class="chart-info d-flex justify-content-between mb-1">
                        <div class="series-info d-flex align-items-center">
                            <i class="feather icon-monitor font-medium-2 text-primary"></i>
                            <span class="text-bold-600 mx-50">Desktop</span>
                        </div>
                        <div class="series-result">
                            <span><?= round(($session_device_desktop/$session_device_count)*100, 2) ?>%</span>
                        </div>
                    </div>
                    <div class="chart-info d-flex justify-content-between mb-1">
                        <div class="series-info d-flex align-items-center">
                            <i class="feather icon-tablet font-medium-2 text-warning"></i>
                            <span class="text-bold-600 mx-50">Mobile</span>
                        </div>
                        <div class="series-result">
                            <span><?= round(($session_device_mobile/$session_device_count)*100, 2) ?>%</span>
                        </div>
                    </div>
                    <div class="chart-info d-flex justify-content-between mb-50">
                        <div class="series-info d-flex align-items-center">
                            <i class="feather icon-tablet font-medium-2 text-danger"></i>
                            <span class="text-bold-600 mx-50">Tablet</span>
                        </div>
                        <div class="series-result">
                            <span><?= round(($session_device_tablet/$session_device_count)*100, 2) ?>%</span>
                        </div>
                    </div>
                    <div class="chart-info d-flex justify-content-between mb-50">
                        <div class="series-info d-flex align-items-center">
                            <i class="feather icon-help-circle font-medium-2 text-black"></i>
                            <span class="text-bold-600 mx-50">Unknown</span>
                        </div>
                        <div class="series-result">
                            <span><?= round(($session_device_unknown/$session_device_count)*100, 2) ?>%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card m-b-30">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-users text-primary font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1"><?= currency($total_active_users) ?></h2>
                        <p class="mb-0">Active Users</p>
                    </div>
                    <div class="card-content">
                        <div id="users-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card m-b-30">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-success p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-credit-card text-success font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1"><?= currency($total_deposit_paid) ?></h2>
                        <p class="mb-0">Deposits Paid</p>
                    </div>
                    <div class="card-content">
                        <div id="deposit-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card m-b-30">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-danger p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-shopping-cart text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1"><?= currency($total_success_game+$total_success_ppob+$total_success_socmed) ?></h2>
                        <p class="mb-0">Transaction Success</p>
                    </div>
                    <div class="card-content">
                        <div id="transaction-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card m-b-30">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-warning p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-package text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">Rp <?= currency($total_price_game+$total_price_ppob+$total_price_socmed) ?></h2>
                        <p class="mb-0">Shopping Total</p>
                    </div>
                    <div class="card-content">
                        <div id="shopping-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-header d-flex justify-content-between align-items-end">
                <h4 class="card-title">Revenue</h4>
            </div>
            <div class="card-content">
                <div class="card-body pb-0">
                    <div class="d-flex justify-content-start">
                        <div class="mr-2">
                            <p class="mb-50 text-bold-600">This Month</p>
                            <h2 class="text-bold-400">
                                <sup class="font-medium-1">Rp</sup>
                                <span class="text-success"><?= currency($revenue_this_month) ?></span>
                            </h2>
                        </div>
                        <div>
                            <p class="mb-50 text-bold-600">Last Month</p>
                            <h2 class="text-bold-400">
                                <sup class="font-medium-1">Rp</sup>
                                <span><?= currency($revenue_last_month) ?></span>
                            </h2>
                        </div>
                    </div>
                    <div id="revenue-chart"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="card m-b-30">
            <div class="card-header">
                <h4 class="card-title">Device Statistics</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <?php
                    if(isset($device_stats)) {
                        $device_stats_total = $device_stats['total_stats'];
                        foreach ($device_stats as $key => $val) {
                            if($key <> 'total_stats') {
                    ?>
                    <div class="d-flex justify-content-between mb-25">
                        <div class="browser-info">
                            <p class="mb-25"><?= ucfirst($key) ?></p>
                        </div>
                        <div class="stastics-info text-right">
                            <span><?= round(($val/$device_stats_total)*100, 2) ?>%</span>
                        </div>
                    </div>
                    <div class="progress progress-bar-primary mb-2">
                        <div class="progress-bar" role="progressbar" aria-valuenow="<?= (($val/$device_stats_total)*100) ?>" aria-valuemin="<?= (($val/$device_stats_total)*100) ?>" aria-valuemax="100" style="width:<?= (($val/$device_stats_total)*100) ?>%"></div>
                    </div>
                    <? } } } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="card m-b-30">
            <div class="card-header">
                <h4 class="card-title">Browser Statistics</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <?php
                    if(isset($browser_stats)) {
                        $browser_stats_total = $browser_stats['total_stats'];
                        foreach ($browser_stats as $key => $val) {
                            if($key <> 'total_stats') {
                    ?>
                    <div class="d-flex justify-content-between mb-25">
                        <div class="browser-info">
                            <p class="mb-25"><?= ucfirst($key) ?></p>
                        </div>
                        <div class="stastics-info text-right">
                            <span><?= round(($val/$browser_stats_total)*100, 2) ?>%</span>
                        </div>
                    </div>
                    <div class="progress progress-bar-primary mb-2">
                        <div class="progress-bar" role="progressbar" aria-valuenow="<?= (($val/$browser_stats_total)*100) ?>" aria-valuemin="<?= (($val/$browser_stats_total)*100) ?>" aria-valuemax="100" style="width:<?= (($val/$browser_stats_total)*100) ?>%"></div>
                    </div>
                    <? } } } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<? require _DIR_('library/layout/footer.user'); ?>
<script type="text/javascript">
$(window).on("load", function () {
    new ApexCharts(document.querySelector("#session-by-device"), {
        chart: { type: "donut", height: 315, toolbar: { show: !1 } },
        dataLabels: { enabled: !1 },
        series: [
            <?= round(($session_device_desktop/$session_device_count)*100, 2) ?>,
            <?= round(($session_device_mobile/$session_device_count)*100, 2) ?>,
            <?= round(($session_device_tablet/$session_device_count)*100, 2) ?>,
            <?= round(($session_device_unknown/$session_device_count)*100, 2) ?>
        ],
        legend: { show: !1 },
        comparedResult: [2, -3, 8],
        labels: ["Desktop", "Mobile", "Tablet", "Unknown"],
        stroke: { width: 0 },
        colors: ["#7367F0", "#FF9F43", "#EA5455", "#28313B"],
        fill: { type: "gradient", gradient: { gradientToColors: ["#9c8cfc", "#FFC085", "#f29292", "#485461"] } },
    }).render();
    
    new ApexCharts(document.querySelector("#users-chart"), {
        chart: { height: 100, type: "area", toolbar: { show: !1 }, sparkline: { enabled: !0 }, grid: { show: !1, padding: { left: 0, right: 0 } } },
        colors: ["#7367F0"],
        dataLabels: { enabled: !1 },
        stroke: { curve: "smooth", width: 2.5 },
        fill: { type: "gradient", gradient: { shadeIntensity: 0.9, opacityFrom: 0.7, opacityTo: 0.5, stops: [0, 80, 100] } },
        series: [{ name: "Active Users", data: [
            <?php
            for($i = 6; $i >= 0; $i--) {
                $source_date = rdate('Y-m-d',"-$i days");
                print $call->query("SELECT id FROM users WHERE status = 'active' AND date LIKE '$source_date%'")->num_rows.',';
            }
            ?>
        ] }],
        xaxis: { labels: { show: !1 }, axisBorder: { show: !1 } },
        yaxis: [{ y: 0, offsetX: 0, offsetY: 0, padding: { left: 0, right: 0 } }],
        tooltip: { x: { show: !1 } },
    }).render();
    
    new ApexCharts(document.querySelector("#deposit-chart"), {
        chart: { height: 100, type: "area", toolbar: { show: !1 }, sparkline: { enabled: !0 }, grid: { show: !1, padding: { left: 0, right: 0 } } },
        colors: ["#28C76F"],
        dataLabels: { enabled: !1 },
        stroke: { curve: "smooth", width: 2.5 },
        fill: { type: "gradient", gradient: { shadeIntensity: 0.9, opacityFrom: 0.7, opacityTo: 0.5, stops: [0, 80, 100] } },
        series: [{ name: "Deposits Paid", data: [
            <?php
            for($i = 6; $i >= 0; $i--) {
                $source_date = rdate('Y-m-d',"-$i days");
                print $call->query("SELECT id FROM deposit WHERE status = 'paid' AND date LIKE '$source_date%'")->num_rows.',';
            }
            ?>
        ] }],
        xaxis: { labels: { show: !1 }, axisBorder: { show: !1 } },
        yaxis: [{ y: 0, offsetX: 0, offsetY: 0, padding: { left: 0, right: 0 } }],
        tooltip: { x: { show: !1 } },
    }).render();
    
    new ApexCharts(document.querySelector("#transaction-chart"), {
        chart: { height: 100, type: "area", toolbar: { show: !1 }, sparkline: { enabled: !0 }, grid: { show: !1, padding: { left: 0, right: 0 } } },
        colors: ["#EA5455"],
        dataLabels: { enabled: !1 },
        stroke: { curve: "smooth", width: 2.5 },
        fill: { type: "gradient", gradient: { shadeIntensity: 0.9, opacityFrom: 0.7, opacityTo: 0.5, stops: [0, 80, 100] } },
        series: [{ name: "Transaction Success", data: [
            <?php
            for($i = 6; $i >= 0; $i--) {
                $source_date = rdate('Y-m-d',"-$i days");
                $count_game = $call->query("SELECT id FROM trx_game WHERE status = 'success' AND date_cr LIKE '$source_date%'")->num_rows;
                $count_ppob = $call->query("SELECT id FROM trx_ppob WHERE status = 'success' AND date_cr LIKE '$source_date%'")->num_rows;
                $count_socmed = $call->query("SELECT id FROM trx_socmed WHERE status IN ('partial','success') AND date_cr LIKE '$source_date%'")->num_rows;
                print ($count_game+$count_ppob+$count_socmed).',';
            }
            ?>
        ] }],
        xaxis: { labels: { show: !1 }, axisBorder: { show: !1 } },
        yaxis: [{ y: 0, offsetX: 0, offsetY: 0, padding: { left: 0, right: 0 } }],
        tooltip: { x: { show: !1 } },
    }).render();
    
    new ApexCharts(document.querySelector("#shopping-chart"), {
        chart: { height: 100, type: "area", toolbar: { show: !1 }, sparkline: { enabled: !0 }, grid: { show: !1, padding: { left: 0, right: 0 } } },
        colors: ["#FF9F43"],
        dataLabels: { enabled: !1 },
        stroke: { curve: "smooth", width: 2.5 },
        fill: { type: "gradient", gradient: { shadeIntensity: 0.9, opacityFrom: 0.7, opacityTo: 0.5, stops: [0, 80, 100] } },
        series: [{ name: "Shopping Total", data: [
            <?php
            for($i = 6; $i >= 0; $i--) {
                $source_date = rdate('Y-m-d',"-$i days");
                $count_game = $call->query("SELECT SUM(price) AS x FROM trx_game WHERE status = 'success' AND date_cr LIKE '$source_date%'")->fetch_assoc()['x'];
                $count_ppob = $call->query("SELECT SUM(price) AS x FROM trx_ppob WHERE status = 'success' AND date_cr LIKE '$source_date%'")->fetch_assoc()['x'];
                $count_socmed = $call->query("SELECT SUM(price) AS x FROM trx_socmed WHERE status IN ('partial','success') AND date_cr LIKE '$source_date%'")->fetch_assoc()['x'];
                print ($count_game+$count_ppob+$count_socmed).',';
            }
            ?>
        ] }],
        xaxis: { labels: { show: !1 }, axisBorder: { show: !1 } },
        yaxis: [{ y: 0, offsetX: 0, offsetY: 0, padding: { left: 0, right: 0 } }],
        tooltip: { x: { show: !1 } },
    }).render();
    
    new ApexCharts(document.querySelector("#revenue-chart"), {
        chart: { height: 270, toolbar: { show: !1 }, type: "line" },
        stroke: { curve: "smooth", dashArray: [0, 8], width: [4, 2] },
        grid: { borderColor: "#e7e7e7" },
        legend: { show: !1 },
        colors: ["#f29292", "#b9c3cd"],
        fill: { type: "gradient", gradient: { shade: "dark", inverseColors: !1, gradientToColors: ["#7367F0", "#b9c3cd"], shadeIntensity: 1, type: "horizontal", opacityFrom: 1, opacityTo: 1, stops: [0, 100, 100, 100] } },
        markers: { size: 0, hover: { size: 5 } },
        xaxis: { labels: { style: { colors: "#b9c3cd" } }, axisTicks: { show: !1 }, categories: [<?php
            for($i = 7; $i >= 0; $i--) {
                $source_date = rdate('d/m',"-$i days");
                print "\"$source_date\",";
            }
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
            { name: "This Month", data: [<?php
                for($i = 7; $i >= 0; $i--) {
                    $source_date = rdate('Y-m-d',"-$i days");
                    $this_month = $call->query("SELECT SUM(profit) AS x FROM trx_game WHERE status = 'success' AND date_cr LIKE '$source_date%'")->fetch_assoc()['x']
                                        + $call->query("SELECT SUM(profit) AS x FROM trx_ppob WHERE status = 'success' AND date_cr LIKE '$source_date%'")->fetch_assoc()['x']
                                        + $call->query("SELECT SUM(profit) AS x FROM trx_socmed WHERE status IN ('partial','success') AND date_cr LIKE '$source_date%'")->fetch_assoc()['x'];
                    print "$this_month,";
                }
            ?>] },
            { name: "Last Month", data: [<?php
                for($i = 7; $i >= 0; $i--) {
                    $source_date = rdate('Y-m-d',"-$i days, -1 month");
                    $last_month = $call->query("SELECT SUM(profit) AS x FROM trx_game WHERE status = 'success' AND date_cr LIKE '$source_date%'")->fetch_assoc()['x']
                                        + $call->query("SELECT SUM(profit) AS x FROM trx_ppob WHERE status = 'success' AND date_cr LIKE '$source_date%'")->fetch_assoc()['x']
                                        + $call->query("SELECT SUM(profit) AS x FROM trx_socmed WHERE status IN ('partial','success') AND date_cr LIKE '$source_date%'")->fetch_assoc()['x'];
                    print "$last_month,";
                }
            ?>] },
        ],
    }).render();
});
</script>