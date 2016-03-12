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
    </form>
</section>