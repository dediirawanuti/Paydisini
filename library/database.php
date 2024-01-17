<?php
/* Auto Lock Minimum Balance */
$search_the_minimum_balance = $call->query("SELECT username FROM users WHERE balance < 0");
while($r = $search_the_minimum_balance->fetch_assoc()) if($call->query("SELECT * FROM users_lock WHERE user = '".$r['username']."'")->num_rows == 0) $call->query("INSERT INTO users_lock VALUES ('".$r['username']."','Your account is locked for violating the minimum balance.','$date $time')");

/* Auto Delete Cookies */
$call->query("DELETE FROM users_cookie WHERE TIMESTAMPDIFF(SECOND, '$date $time', expired) < 0");/* End Delete Cookies */