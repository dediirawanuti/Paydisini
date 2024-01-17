<?php 
require '../../connect.php';
require _DIR_('library/session/session');
require _DIR_('library/layout/header.user');
?>
<div class="content-detached content-left">
    <div class="content-body">
        <div class="card m-b-30">
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
                        <p>[<code>POST</code>] <?= base_url('api/social-media') ?></p>
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
                                    <td>quantity</td>
                                    <td><code>integer</code></td>
                                    <td>berisi jumlah pemesanan</td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>data</td>
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
        'data' => 'support@demotest.com',
        'service' => 'Akun Netflix Premium Private [30 DAY][GARANSI]',
        'quantity' => 100,
        'status' => 'waiting',
        'note' => '',
        'balance' => 100000,
        'price' => 45000
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
        <div class="card m-b-30">
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
                        <p>[<code>POST</code>] <?= base_url('api/social-media') ?></p>
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
        'data' => 'support@demotest.com',
        'service' => 'Akun Netflix Premium Private [30 DAY][GARANSI]',
        'quantity' => 100,
        'status' => 'processing',
        'remain' => 0,
        'count' => 0,
        'note' => '',
        'price' => 45000
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
            'data' => 'support@demotest.com',
            'service' => 'Akun Netflix Premium Private [30 DAY][GARANSI]',
            'quantity' => 100,
            'status' => 'success',
            'remain' => 0,
            'count' => 0,
            'note' => '',
            'price' => 45000
        ], [
            'trxid' => 'some1d',
            'data' => 'support@demotest.com',
            'service' => 'Akun Netflix Premium Private [30 DAY][GARANSI]',
            'quantity' => 100,
            'status' => 'error',
            'remain' => 0,
            'count' => 0,
            'note' => 'Email tidak valid.',
            'price' => 45000
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
        <div class="card m-b-30">
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
                        <p>[<code>POST</code>] <?= base_url('api/social-media') ?></p>
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
                                    <td><ul><li>category</li></ul></td>
                                    <td>No</td>
                                </tr>
                                <tr>
                                    <td>filter_value</td>
                                    <td><code>string</code></td>
                                    <td>berisi category yang ingin diambil</td>
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
            'category' => 'Akun Premium Netflix/Spotify/Canva/Youtube',
            'id' => '1',
            'max' => 1000,
            'min' => 1000,
            'name' => 'Akun Admin Spotify Premium [1 BULAN ]',
            'note' => '-Bersifat Akun Admin Sp...',
            'price' => 20110,
            'status' => 'available'
        ], [
            'category' => 'Akun Premium Netflix/Spotify/Canva/Youtube',
            'id' => '2',
            'max' => 1000,
            'min' => 1000,
            'name' => 'Akun Canva Pro/Premium',
            'note' => '-Canva Pro/Pre...',
            'price' => 4110,
            'status' => 'empty'
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