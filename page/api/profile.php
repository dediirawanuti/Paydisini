<?php 
require '../../connect.php';
require _DIR_('library/session/session');
require _DIR_('library/layout/header.user');
?>
<div class="content-detached content-left">
    <div class="content-body">
        <div class="card m-b-30">
            <div class="card-header">
                <h4 id="order" class="card-title">Detail</h4>
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
                        <p>[<code>POST</code>] <?= base_url('api/profile') ?></p>
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
        'full_name' => isset($data_user) ? $data_user['name'] : 'your full name',
        'username' => isset($data_user) ? $data_user['username'] : 'some1d',
        'balance' => isset($data_user) ? (int)$data_user['balance'] : 0,
        'point' => isset($data_user) ? (int)$data_user['point'] : 0,
        'level' => isset($data_user) ? $data_user['level'] : 'Basic',
        'registered' => isset($data_user) ? $data_user['date'] : $dtme,
    ],
    'message' => 'Successfully got your account details.'
], JSON_PRETTY_PRINT) ?>
                        </code>
                    </pre>
                </div>
            </div>
        </div>
        <!--/ Melakukan Pemesanan Structure -->
    </div>
    <div class="mb-5"></div>
<? require _DIR_('library/layout/footer.user'); ?>