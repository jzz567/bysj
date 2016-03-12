<section>
    <form id="presenting" method="post" action="<?php echo $reg_action; ?>">
        <h2>要创建一个账号?</h2>
        <p>请输入你的信息来注册</p>
        <label>你希望的用户名?
            <input type="text" name="username"/>
        </label>
        <label>你的邮箱是?
            <input type="text" name="email"/>
        </label>
        <label>你的密码是?
            <input type="password" name="password"/>
        </label>
        <label>确认密码
            <input type="password" name="session-name"/>
        </label>
        <input type="submit" value="创建账户!"/>
    </form>
</section>