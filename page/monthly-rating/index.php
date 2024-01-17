<?php
require '../../connect.php';
require _DIR_('library/session/user');
if(conf('xtra-fitur',4) <> 'true') exit(redirect(0,base_url()));
exit(redirect(0,base_url('page/monthly-rating/pulsa-ppob')));