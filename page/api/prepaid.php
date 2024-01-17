<?php 
require '../../connect.php';
require _DIR_('library/session/session');
require _DIR_('library/layout/header.user');
?>
<div class="sidebar-right sidebar-sticky d-none d-md-block">
    <div class="sidebar">
        <div class="pt-2 pr-2">
            <div class="sidebar-content p-1 affix" data-spy="affix" data-offset-top="-77">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Prepaid</h6>
                    </div>
                    <div class="card-content" aria-expanded="true">
                        <div class="card-body">
                            <nav id="sidebar-page-navigation">
                                <ul id="page-navigation-list" class="nav">
                                    <li class="nav-item"><a class="nav-link" href="#order">Order</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#status">Status</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#services">Service</a></li>
                                </ul>
                            </nav>
                        </div>
                        <h6 class="border-top-grey border-top-lighten-2 p-1 mt-1 mb-0">
                            <a class="nav-link display-block text-muted" href="#top">Back to top
                                <i class="float-right fa fa-arrow-circle-o-up font-medium-3"></i>
                            </a>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-detached content-left">
    <div class="content-body">
        <div class="card">
            <div class="card-header">
                <h4 id="order" class="card-title">Place an Order</h4>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                        <li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show" aria-expanded="true">
                <div class="card-body">
                    <div class="card-text">
                        <p>[<code>POST</code>] <?= base_url('api/prepaid') ?></p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless mb-0">
                            <thead>
                                <tr>
                                    <th>Parameter</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                    <th>Req.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>key</td>
                                    <td><code>string</code></td>
                                    <td>berisi apikey anda.</td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>sign</td>
                                    <td><code>string</code></td>
                                    <td>berisi formula md5(API ID + API KEY).</td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>type</td>
                                    <td><code>string</code></td>
                                    <td><i>order</i></td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>service</td>
                                    <td><code>string</code></td>
                                    <td>berisi kode layanan, <a href="<?= base_url('page/product') ?>" target="blank">cek disini</a>.</td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>data_no</td>
                                    <td><code>string</code></td>
                                    <td>berisi data tujuan</td>
                                    <td>Yes</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <h4 class="mt-3">Example Response</h4>
                    <hr>
                    <pre>
                        <code class="language-json">
<?= json_encode([
    'result' => true,
    'data' => [
        'trxid' => 'some1d',
        'data' => '085716432179',
        'code' => '25',
        'service' => 'Xl 25.000',
        'status' => 'waiting',
        'note' => '',
        'balance' => 100000,
        'price' => 25000
    ],
    'message' => 'Pesanan berhasil, pesanan akan diproses.'
], JSON_PRETTY_PRINT) ?>
                        </code>
                    </pre>
                </div>
            </div>
        </div>
        <!--/ Melakukan Pemesanan Structure -->
        <!-- Melakukan Cek Status Pesanan Structure -->
        <div class="card">
            <div class="card-header">
                <h4 id="status" class="card-title">Melakukan Cek Status Pesanan</h4>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                        <li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show" aria-expanded="true">
                <div class="card-body">
                    <div class="card-text">
                        <p>[<code>POST</code>] <?= base_url('api/prepaid') ?></p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless mb-0">
                            <thead>
                                <tr>
                                    <th>Parameter</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                    <th>Req.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>key</td>
                                    <td><code>string</code></td>
                                    <td>berisi apikey anda.</td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>sign</td>
                                    <td><code>string</code></td>
                                    <td>berisi formula md5(API ID + API KEY).</td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>type</td>
                                    <td><code>string</code></td>
                                    <td><i>status</i></td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>trxid</td>
                                    <td><code>string</code></td>
                                    <td>berisi id transaksi</td>
                                    <td>No</td>
                                </tr>
                                <tr>
                                    <td>limit</td>
                                    <td><code>integer</code></td>
                                    <td>berisi limit transaksi, hapus parameter 'trxid' jika ingin melihat banyak transaksi sekaligus.</td>
                                    <td>No</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <h4 class="mt-3">Example Response</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <pre>
                                <code class="language-json">
<?= json_encode([
    'result' => true,
    'data' => [[
        'trxid' => 'some1d',
        'data' => '085716432179',
        'code' => '25',
        'service' => 'Xl 25.000',
        'status' => 'success',
        'note' => '',
        'price' => 25000
    ]],
    'message' => 'Detail transaksi berhasil didapatkan.'
], JSON_PRETTY_PRINT) ?>
                                </code>
                            </pre>
                        </div>
                        <div class="col-md-6 col-12">
                            <pre>
                                <code class="language-json">
<?= json_encode([
    'result' => true,
    'data' => [
        [
            'trxid' => 'some1d',
            'data' => '085716432179',
            'code' => '25',
            'service' => 'Xl 25.00',
            'status' => 'success',
            'note' => '436846846',
            'price' => 25000
        ], [
            'trxid' => 'some1d',
            'data' => '085716432179',
            'code' => '50',
            'service' => 'Xl 50.00',
            'status' => 'error',
            'note' => 'Nomor tujuan salah.',
            'price' => 50000
        ]
    ],
    'message' => 'Detail transaksi berhasil didapatkan.'
], JSON_PRETTY_PRINT) ?>
                                </code>
                            </pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 id="services" class="card-title">Mendapatkan Layanan</h4>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                        <li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show" aria-expanded="true">
                <div class="card-body">
                    <div class="card-text">
                        <p>[<code>POST</code>] <?= base_url('api/prepaid') ?></p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless mb-0">
                            <thead>
                                <tr>
                                    <th>Parameter</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                    <th>Req.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>key</td>
                                    <td><code>string</code></td>
                                    <td>berisi apikey anda.</td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>sign</td>
                                    <td><code>string</code></td>
                                    <td>berisi formula md5(API ID + API KEY).</td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>type</td>
                                    <td><code>string</code></td>
                                    <td><i>services</i></td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>filter_type</td>
                                    <td><code>string</code></td>
                                    <td><ul>
                                        <li>type</li>
                                        <li>brand</li>
                                    </ul></td>
                                    <td>No</td>
                                </tr>
                                <tr>
                                    <td>filter_value</td>
                                    <td><code>string</code></td>
                                    <td>berisi tipe atau brand yang ingin diambil</td>
                                    <td>No</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <h4 class="mt-3">Example Response</h4>
                    <hr>
                    <pre>
                        <code class="language-json">
<?= json_encode([
    'result' => true,
    'data' => [
        [
            'brand' => 'XL',
            'code' => '25',
            'name' => 'Xl 25.000',
            'note' => 'Pulsa Xl Rp 25.000',
            'price' => 25000,
            'status' => 'available',
            'type' => 'pulsa-reguler'
        ], [
            'brand' => 'XL',
            'code' => '50',
            'name' => 'Xl 50.000',
            'note' => 'Pulsa Xl Rp 50.000',
            'price' => 50000,
            'status' => 'empty',
            'type' => 'pulsa-reguler'
        ]
    ],
    'message' => 'Daftar layanan berhasil didapatkan.'
], JSON_PRETTY_PRINT) ?>
                        </code>
                    </pre>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-5"></div>
<? require _DIR_('library/layout/footer.user'); ?>