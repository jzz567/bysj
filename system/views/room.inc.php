<section>
    <header>
        <h2><?php echo $room_name; ?></h2>
        <p>
            房主是:<?php echo $presenter; ?>
            (<a href="mailto:<?php echo $email; ?>">email</a>)
        </p>
        <?php echo $controls; ?>
    </header>
    <br/>
    </ul><!--/#questions-->
    <ul id="online">在线人数:<img style="width: 15px" src="http://jzz15.oss-cn-shenzhen.aliyuncs.com/images%2Floading.gif"/>
    </ul>

    <div style="width: 900px;text-align: center">
        <select id="online_list"
                disabled="disabled" style="background-color: white;margin-left: 10px;width: 80px;height:303px;display: inline;float: left;text-align: center;list-style: none;border-top-left-radius:6px;border-bottom-left-radius:6px;box-shadow: 0 0 10px rgba(31, 27, 12, .3);text-shadow: 0 0 10px rgba(31, 27, 12, .3);border:none;"
                multiple="multiple">
        </select>
        <textarea id="show_msg"
                  style="float: left;resize: none;background-color:white;border-top-right-radius:6px;border-bottom-right-radius:6px;box-shadow: 0 0 10px rgba(31, 27, 12, .3);text-shadow: 0 0 10px rgba(31, 27, 12, .3);border:none;width: 500px;height: 300px"
                  disabled="disabled"></textarea>

    </div>
    <form id="msg_form" method="post" action="" style="width: 600px;margin-left: 30px">
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
