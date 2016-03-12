<?php
//------------------
//初始化环境
//------------------
define('APP_PATH', dirname(__FILE__));
define('APP_FOLDER', dirname($_SERVER['SCRIPT_NAME']));
define('APP_URI', remove_unwanted_slashes('http://' . $_SERVER['SERVER_NAME'] . APP_FOLDER) . '/');
define('SYS_PATH', APP_PATH . '/system');
//-----------------------------------------------------------------
//初始化应用程序的环境
//-----------------------------------------------------------------
if (!isset($_SESSION)) {
    session_start();
}
//载入配置文件
require_once(SYS_PATH . '/config/config.inc.php');
//载入Pusher库
require_once(SYS_PATH . '/lib/Pusher.php');
/*
 * 检测是否是DEBUG模式
 * */
if (DEBUG === true) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL ^ E_STRICT);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}
/*
 * 设置默认时区
 * */
date_default_timezone_set(APP_TIMEZONE);
/*
 * 把class_autoloader注册为自动载入函数
 * */
spl_autoload_register('class_autoloader');

//-----------------------------------------------------------------
//载入控制器
//-----------------------------------------------------------------
$uri_array = parse_uri();
$class_name = get_controller_classname($uri_array);
$option = $uri_array;
if (empty($class_name)) {
    $class_name = 'Index';
}
try {
    $controller = new $class_name($option);
} catch (Exception $e) {
    $option[1] = $e->getMessage();
    $controller = new Error($option);
}
//-----------------------------------------------------------------
//l拦截非法请求
//-----------------------------------------------------------------
//过滤控制器请求
if (!isset($_SESSION['vaild_user']) && empty($_SESSION['vaild_user']) && $class_name != 'Index' && $class_name != 'User') {
    $option[1] = "请登录";
    $controller = new Error($option);
}
//过滤action
if (isset($option[0]) && !empty($option[0]) && $option[0] == 'update') {
    $option[1] = "请登录";
    $controller = new Error($option);
}
//-----------------------------------------------------------------
//输出视图
//-----------------------------------------------------------------
//载入title,css_path
$title = $controller->get_title();
$dirty_path = APP_URI . '/assets/styles/main.css';
$css_path = remove_unwanted_slashes($dirty_path);
require_once SYS_PATH . '/inc/header.inc.php';
$channel = !empty($uri_array[0]) ? 'room_' . $uri_array[0] : "default";
$controller->output_view();
require_once SYS_PATH . '/inc/footer.inc.php';
require_once SYS_PATH . '/inc/footer.inc.php';

//-----------------------------------------------------------------
//方法定义
//-----------------------------------------------------------------
/*
 * 把请求的URI划分成多个部分
 * */
function parse_uri() {
    $real_uri = preg_replace('~^' . APP_FOLDER . '~', '', $_SERVER['REQUEST_URI'], 1);
    $uri_array = explode('/', $real_uri);
    if (empty($uri_array[0])) {
        array_shift($uri_array);
    }
    if (empty($uri_array[count($uri_array) - 1])) {
        array_pop($uri_array);
    }
    return $uri_array;
}

/*
 * 获得控制器名称
 * */
function get_controller_classname(&$uri_array) {
    $controller = array_shift($uri_array);
    $controller = explode('.', $controller)[0];
    return ucfirst($controller);
}

/*
 * 移除URI中可能的多余斜线/,如http://localhost//index.php
 * */
function remove_unwanted_slashes($dirty_path) {
    return preg_replace('~(?<!:)//~', '/', $dirty_path);
}

/*
 * 自动在可能的目录搜索类名并载入
 * */
function class_autoloader($class_name) {
    $fname = strtolower($class_name);
    $possible_locations = array(
        SYS_PATH . "/models/class.$fname.inc.php",
        SYS_PATH . "/controllers/class.$fname.inc.php",
        SYS_PATH . "/core/class.$fname.inc.php",
    );
    foreach ($possible_locations as $loc) {
        if (file_exists($loc)) {
            require_once($loc);
            return true;
        }
    }
    throw new Exception("找不到类:$class_name");
}