<?php
$_C = array();
$_C['APP_TIMEZONE'] = 'Asia/Shanghai';//设置时区,可配置项在http://php.net/manual/zh/timezones.php
$_C['DB_HOST'] = 'localhost';//数据库地址
$_C['DB_NAME'] = 'realtime';//数据库名称
$_C['DB_USER'] = 'root';//数据库用户名
$_C['DB_PASS'] = '';//数据库密码
$_C['DEBUG'] = true;//是否开启DEBUG模式
$_C['PUSHER_KEY'] = '';//PUSHER的KEY
$_C['PUSHER_SECRET'] = '';//PUSHER的SECRET
$_C['PUSHER_APPID'] = '';//PUSHER的APPID
foreach ($_C as $constant => $value) {
    define($constant, $value);
}