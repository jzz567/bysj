<section>
    <form id="attending" method="post" action="<?php echo $join_action; ?>">
        <h2>要加入一个讨论?</h2>
        <p>使用房间ID来加入一个讨论</p>
        <label>房间ID是?
            <input type="text" name="room_id"/>
        </label>
        <input type="submit" value="加入这个房间!"/>
        <input type="hidden" name="nonce" value="<?php echo $nonce; ?>"/>
    </form>
    <form id="presenting" method="post" action="<?php echo $create_action; ?>">
        <h2>要创建一个对话?</h2>
        <p>创建一个房间来开始你的对话</p>
        <label>你希望的名字是?
            <input type="text" name="presenter-name"/>
        </label>
        <label>你的房间名叫?
            <input type="text" name="session-name"/>
        </label>
        <input type="submit" value="创建房间!"/>
        <input type="hidden" name="nonce" value="<?php echo $nonce; ?>"/>
    </form>
</section>