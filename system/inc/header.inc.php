<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    <!--实时对话-->
    <link rel="stylesheet" href="https://jzz15.oss-cn-shenzhen.aliyuncs.com/bysj/assets/styles/main.css"/>
</head>

<body>
<div style="background:#1f1b0c;font-size: small;text-align: right;">
    <?php
    if (!empty($_SESSION['user_id']) && isset($_SESSION['user_id'])) {
        $home = APP_URI . 'home';
        $logout = APP_URI . 'user/logout';
        $username = $_SESSION['user_name'];
        echo '<a style="text-decoration: none" href="#">欢迎您,' . $username . ' </a>';
        echo '<a style="text-decoration: none" href="' . $home . '">返回主页  </a>';
        echo '<a style="text-decoration: none" href="' . $logout . '">注销</a>';
    }
    ?>
</div>
<header>
    <p>
    <h1>实时对话</h1>
    <p class="tagline">一个基于HTML5、WebSocket、jQuery、PHP的实时系统</p>
</header>