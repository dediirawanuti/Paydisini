<?php
require '../../connect.php';
require _DIR_('library/session/session');

$get_uid = (isset($_GET['uid'])) ? $_GET['uid'] : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if($data_user['level'] !== 'Admin') exit("No direct script access allowed!");
    $search = $call->query("SELECT * FROM users WHERE id = '$get_uid'");
    if($search->num_rows == 0) exit("User not found!");
    $row = $search->fetch_assoc();
    
    $data_lock = $call->query("SELECT * FROM users_lock WHERE user = '".$row['username']."'");
    if($data_lock->num_rows == 1) $data_lock = $data_lock->fetch_assoc();
    $lock_status = is_array($data_lock) ? 'true' : 'false';
?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="data_token" name="data_token" value="<?= base64_encode($row['id']) ?>">
    <div class="card-body card-dashboard">
        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="profile-tab-fill" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="false">Detail</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="home-tab-fill" data-toggle="tab" href="#userPass" role="tab" aria-controls="userPass" aria-selected="false">Password</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="home-tab-fill" data-toggle="tab" href="#userLocks" role="tab" aria-controls="userLocks" aria-selected="false">Lock</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="home-tab-fill" data-toggle="tab" href="#minBalance" role="tab" aria-controls="minBalance" aria-selected="false">Balance</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane show active" id="detail">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" class="form-control" name="u_name" value="<?= $row['name'] ?>" required data-validation-required-message="This name field is required" minlength="5" maxlength="32">
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" class="form-control" name="u_mail" value="<?= $row['email'] ?>" required data-validation-required-message="This email field is required">
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" class="form-control" name="u_phone" value="<?= $row['phone'] ?>" onkeyup="this.value=this.value.replace(/[^\d]+/g,'')" required data-validation-required-message="This phone field is required" minlength="12" maxlength="14">
                    <small class="text-danger">*Only supports Indonesian numbers.</small>
                </div>
                <div class="form-group">
                    <label>Balance</label>
                    <input type="number" class="form-control" name="u_balance" value="<?= $row['balance'] ?>">
                </div>
                <div class="form-group">
                    <label>Level</label>
                    <select class="form-control" name="u_level" required data-validation-required-message="This level field is required">
                        <?= select_opt($row['level'], 'Basic', 'Basic') ?>
                        <?= select_opt($row['level'], 'Premium', 'Premium') ?>
                        <?= select_opt($row['level'], 'Admin', 'Admin') ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="u_status" required data-validation-required-message="This status field is required">
                        <?= select_opt($row['status'], 'suspend', 'Suspend') ?>
                        <?= select_opt($row['status'], 'active', 'Active') ?>
                    </select>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <button type="button" name="reset" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
                    </div>
                    <div class="form-group col-6">
                        <button type="submit" name="users_edit1" class="btn btn-primary btn-block"> CHANGE </button>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="userPass">
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" class="form-control" name="up_new">
                </div>
                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" class="form-control" name="up_confirm">
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <button type="button" name="reset" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
                    </div>
                    <div class="form-group col-6">
                        <button type="submit" name="users_edit2" class="btn btn-primary btn-block"> CHANGE </button>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="userLocks">
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="ul_status">
                        <?= select_opt($lock_status, 'false', 'False!') ?>
                        <?= select_opt($lock_status, 'true', 'True!') ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Reason</label>
                    <input type="text" class="form-control" name="ul_reason" value="<?= is_array($data_lock) ? $data_lock['reason'] : ''; ?>">
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <button type="button" name="reset" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
                    </div>
                    <div class="form-group col-6">
                        <button type="submit" name="users_edit3" class="btn btn-primary btn-block"> UPDATE </button>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="minBalance">
                <div class="form-group">
                    <label>Cut Balance</label>
                    <input type="number" class="form-control" name="ub_cut">
                </div>
                <div class="form-group">
                    <label>Reason</label>
                    <input type="text" class="form-control" name="ub_reason">
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <button type="button" name="reset" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
                    </div>
                    <div class="form-group col-6">
                        <button type="submit" name="users_edit4" class="btn btn-primary btn-block"> CUT </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php
} else {
    exit("No direct script access allowed!");
}
?>