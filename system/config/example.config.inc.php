<?php
$_C = array();
$_C['APP_TIMEZONE'] = 'Asia/Shanghai';
$_C['DB_HOST'] = 'localhost';
$_C['DB_NAME'] = 'realtime';
$_C['DB_USER'] = 'root';
$_C['DB_PASS'] = '';
$_C['DEBUG'] = true;
$_C['PUSHER_KEY'] = '';
$_C['PUSHER_SECRET'] = '';
$_C['PUSHER_APPID'] = '';
foreach ($_C as $constant => $value) {
    define($constant, $value);
}