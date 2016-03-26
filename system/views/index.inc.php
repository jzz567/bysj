<section>
    <form id="login" method="post" action="<?php echo $login_action; ?>">
        <label>用户名
            <input type="text" name="username"/>
        </label>
        <label>密码
            <input type="password" name="password"/>
        </label>
        <input type="submit" value="登录!"/>
        <a href="<?php echo $reg_action ?>"><input type="button" value="注册!"/></a>
        <div>
            <input style="background-image: url('https://jzz15.oss-cn-shenzhen.aliyuncs.com/bysj%2Fassets%2Fimages%2Fweibo.png');background-position:3px;background-repeat: no-repeat;padding-left: 45px;" type="button" value="使用新浪微博登录" onclick="window.location.href='https://api.weibo.com/oauth2/authorize?client_id=1949395522&scope=email&redirect_uri=https://51php.org/bysj/user/weibo_login&response_type=code'"/>

        </div>
    </form>
</section>