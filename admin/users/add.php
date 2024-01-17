<?php
require '../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if($data_user['level'] !== 'Admin') exit("No direct script access allowed!");
?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <div class="form-group">
        <label>Full Name</label>
        <input type="text" class="form-control" name="u_name" required data-validation-required-message="This name field is required" minlength="5" maxlength="32">
    </div>
    <div class="form-group">
        <label>Email Address</label>
        <input type="email" class="form-control" name="u_mail" required data-validation-required-message="This email field is required">
    </div>
    <div class="form-group">
        <label>Phone Number</label>
        <input type="text" class="form-control" name="u_phone" onkeyup="this.value=this.value.replace(/[^\d]+/g,'')" required data-validation-required-message="This phone field is required" minlength="12" maxlength="14">
        <small class="text-danger">*Only supports Indonesian numbers.</small>
    </div>
    <div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control" name="u_user" required data-validation-required-message="This username field is required" minlength="4" maxlength="32">
    </div>
    <div class="form-group">
        <label>Level</label>
        <select class="form-control" name="u_level" required data-validation-required-message="This level field is required">
            <option value="Basic">Basic</option>
            <option value="Premium">Premium</option>
            <option value="Admin">Admin</option>
        </select>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-6">
            <button type="button" name="reset" class="btn btn-danger btn-block" data-dismiss="modal"> BACK </button>
        </div>
        <div class="form-group col-6">
            <button type="submit" name="users_add" class="btn btn-primary btn-block"> ADD </button>
        </div>
    </div>
</form>
<?php
} else {
    exit("No direct script access allowed!");
}
?>