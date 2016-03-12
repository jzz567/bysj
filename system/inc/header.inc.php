<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    <!--实时对话-->
    <link rel="stylesheet" href="<?php echo $css_path ?>"/>
</head>

<body>
<div style="background:#1f1b0c;font-size: small;text-align: right;">
    <a style="text-decoration: none" href="<?php echo APP_URI . 'home' ?>">返回主页</a>
    <a style="text-decoration: none" href="<?php echo APP_URI . 'user/logout' ?>">注销</a>
</div>
<header>
    <p>
    <h1>实时对话</h1>
    <p class="tagline">一个基于HTML5、WebSocket、jQuery、PHP的实时系统</p>
</header>