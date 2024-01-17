<?php 
require '../connect.php';
require _DIR_('library/session/session');
require _DIR_('library/layout/header.user');
?>
<section id="faq-search">
    <div class="row">
        <div class="col-12">
            <div class="card faq-bg white">
                <div class="card-content">
                    <div class="card-body p-sm-4 p-2">
                        <h1 class="white">Have Any Questions?</h1>
                        <p class="card-text mb-2">If you have trouble finding it, please do a search below</p>
                        <form method="POST">
                            <fieldset class="form-group position-relative has-icon-left mb-0">
                                <input type="text" class="form-control form-control-lg" id="searchbar" placeholder="Search">
                                <div class="form-control-position">
                                    <i class="feather icon-search px-1"></i>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="faq">
    <div class="row">
        <div class="col-xl-12 col-md-12 col-12">
            <div class="card bg-transparent border-0 shadow-none collapse-icon accordion-icon-rotate">
                <div class="card-body p-0">
                    <div class="accordion search-content-info" id="accordionExample">
<?php
$search = $call->query("SELECT * FROM general_quest ORDER BY quest ASC");
while($row = $search->fetch_assoc()) {
?>
                        <div class="collapse-margin search-content">
                            <div class="card-header" id="heading<?= $row['id'] ?>" role="button" data-toggle="collapse" data-target="#collapse<?= $row['id'] ?>" aria-expanded="false" aria-controls="collapse<?= $row['id'] ?>">
                                <span class="lead collapse-title"><?= $row['quest'] ?></span>
                            </div>
                            <div id="collapse<?= $row['id'] ?>" class="collapse" aria-labelledby="heading<?= $row['id'] ?>" data-parent="#accordionExample">
                                <div class="card-body"><?= base64_decode($row['answer']) ?></div>
                            </div>
                        </div>
<? } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<? require _DIR_('library/layout/footer.user'); ?>