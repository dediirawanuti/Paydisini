<?php 
if(isset($_SESSION['result'])) { 
    $type = strtolower($_SESSION['result']['type']);
    if($type == true) {
        $session_alert = 'success';
        $session_status = 'Success!';
    } else {
        $session_alert = 'danger';
        $session_status = 'Failed!';
    }
?>
<div class="row">
    <div class="col-12">
        <div class="alert bg-<?= $session_alert ?> text-white border-0" role="alert">
            <font style="font-size: 0.9rem;"><strong>Response:</strong> <?= $session_status ?></font><br>
            <font style="font-size: 0.9rem;"><strong>Message:</strong> <?= $_SESSION['result']['message'] ?></font>
        </div>
    </div>
</div>
<?php unset($_SESSION['result']); } ?>