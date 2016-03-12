<br/>
<br/>
<br/>
<form id="ask-a-question" method="post"
      action="<?php echo $form_action; ?>">
    <label>
        你可以在这里输入问题与大家一起讨论
        <input type="text" name="new-question" tabindex="1"/>
    </label>
    <input type="submit" value="提问" tabindex="2"/>
    <input type="hidden" name="room_id"
           value="<?php echo $room_id; ?>"/>
    <input type="hidden" name="nonce"
           value="<?php echo $nonce; ?>"/>
</form><!--/#ask-a-question-->
