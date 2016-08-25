<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
$dzurl = "http://addon.discuz.com/?@51983.developer";
header("Location: $dzurl");
exit(0);
