<section>
    <form id="reg_form" method="post" action="<?php echo $reg_action; ?>">
        <h2>要创建一个账号?</h2>
        <p>请输入你的信息来注册</p>
        <label>
            <span style="display: block">你希望的用户名?</span>
            <input style="width: 250px;display: inline" type="text" id="reg_username" name="username"/><span
                id="tips_username" class="tips error">请输入用户名</span>
        </label>
        <label>
            <span style="display: block">你的邮箱是?</span>
            <input style="width: 250px;display: inline" type="text" id="reg_email" name="email"/><span id="tips_email"
                                                                                                       class="tips error">请输入邮箱</span>
        </label>
        <label>
            <span style="display: block">你的密码是?</span>
            <input style="width: 250px;display: inline" type="password" id="reg_password1" name="password"/><span
                id="tips_password1" class="tips error">请输入密码</span>
        </label>
        <label>
            <span style="display: block">确认密码</span>
            <input style="width: 250px;display: inline" type="password" id="reg_password2" name="session-name"/><span
                id="tips_password2" class="tips error">请输入密码</span>
        </label>
        <input id="reg_submit" type="submit" value="创建账户!"/>
    </form>
</section>