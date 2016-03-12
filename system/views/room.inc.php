<section>
    <header>
        <h2><?php echo $room_name; ?></h2>
        <p>
            Presented by <?php echo $presenter; ?>
            (<a href="mailto:<?php echo $email; ?>">email</a>)
        </p>
        <?php echo $controls; ?>
    </header>
    <br/>
    </ul><!--/#questions-->
    <ul>动态消息</ul>
    <div style="width: 600px;text-align: center">
    <textarea id="show_msg"
              style="resize: none;background-color:white;border-radius:6px;box-shadow: 0 0 10px rgba(31, 27, 12, .3);text-shadow: 0 0 10px rgba(31, 27, 12, .3);border:none;width: 550px;height: 300px"
              disabled="disabled"></textarea>
    </div>
    <form id="msg_form" method="post" action="" style="width: 600px">
        <input type="text" placeholder="在这里输入你要说的话"
               style="width:400px;background-color: white;color: black;font-size: 1em"
               id="msg" name="message"/>
        <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
        <input type="submit" style="font-size: 1.1em" id="send_msg" value="发送"/>
        <input type="hidden" name="nonce" value=>
    </form>
    <br/>
    <?php echo $ask_form; ?>
    <ul id="questions" class="<?php echo $questions_class; ?>">
        <?php echo $questions; ?>
</section>
