
<form method="post" class="vote"
      action="<?php echo $form_action; ?>">
    <input value="I also have this question."
           type="submit" <?php echo $disabled; ?> />
    <input type="hidden" name="question_id"
           value="<?php echo $question_id; ?>" />
    <input type="hidden" name="room_id"
           value="<?php echo $room_id; ?>" />
    <input type="hidden" name="nonce"
           value="<?php echo $nonce; ?>" />
</form>
