<?php
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/shennboku.app/admin-addon-transaction-notifier');
require _DIR_('library/layout/header.admin');
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center">
                This is an additional feature, to get it you will be charged an additional fee of IDR 80,000. This price is not negotiable!
                To use this feature, you must subscribe to the Whatsapp API in Atlantic-Group.
            </div>
        </div>
    </div>
    <div class="col-12 col-md-5">
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Shortcut</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>{{ name }}</td><td>Buyer Name, sample: Afdhalul Ichsan Y.</td></tr>
                        <tr><td>{{ username }}</td><td>Buyer Username, sample: ShennBoku</td></tr>
                        <tr><td>{{ trxid }}</td><td>Order ID, sample: <?= date('YmdHis').random_number(2) ?>.</td></tr>
                        <tr><td>{{ service }}</td><td>Order Service, sample: Pulsa Indosat 10.000.</td></tr>
                        <tr><td>{{ data }}</td><td>Order Target, sample: 085772906190.</td></tr>
                        <tr><td>{{ amount }}</td><td>Order Amount, for games & pulsa this will return 1.</td></tr>
                        <tr><td>{{ date }}</td><td>Time, sample: <?= $date ?>.</td></tr>
                        <tr><td>{{ date-f-id }}</td><td>Date, sample: <?= format_date('id',$date) ?>.</td></tr>
                        <tr><td>{{ date-f-en }}</td><td>Date, sample: <?= format_date('en',$date) ?>.</td></tr>
                        <tr><td>{{ time-f }}</td><td>Time, sample: <?= substr($time,0,5).' WIB' ?>.</td></tr>
                        <tr><td>{{ time }}</td><td>Time, sample: <?= $time ?>.</td></tr>
                        <tr><td>{{ date-time }}</td><td>Date and Time, sample: <?= $dtme ?>.</td></tr>
                    </tbody>
                </table>
                <small class="text-danger">Please pay attention to the capitalization of the letters, because it is very influential.</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-7">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Transaction Notifier</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                    <div class="form-group">
                        <label>Phone Number / Group Name</label>
                        <input type="text" class="form-control" name="number" value="<?= conf('addon1',1) ?>" placeholder="6285772906190">
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea class="form-control" rows="8" id="message" name="message"><?= base64_decode(conf('addon1',2)) ?></textarea>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" name="reset" class="btn btn-danger waves-effect waves-light">Reset</button>
                        <button type="submit" name="save" class="btn btn-primary waves-effect waves-light">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<? require _DIR_('library/layout/footer.user'); ?>