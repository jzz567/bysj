<form id="close-this-room" method="post"
      action="<?php echo $form_action; ?>">
    <label>
        这是你房间的链接,可以分享给你的好友哦!
        <input type="text" name="room-uri"
               value="<?php echo $room_uri; ?>"
               disabled/>
    </label>
    <input type="submit" value="关闭房间"/>
    <input type="hidden" name="room_id"
           value="<?php echo $room_id; ?>"/>
    <input type="hidden" name="nonce"
           value="<?php echo $nonce; ?>"/>
</form><!--/#close-this-room-->
