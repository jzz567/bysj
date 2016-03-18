<?php

abstract class controller {
    public $actions = array(), $model;
    protected static $nonce = null;

    public function __construct($options) {
        if (!is_array($options)) {
            throw new Exception("选项错误");
        }
    }

    protected function generate_nonce() {
        if (empty(self::$nonce)) {
            self::$nonce = base64_encode(uniqid(null, true));
            $_SESSION['nonce'] = self::$nonce;
        }
        return self::$nonce;
    }

    public function check_nonce() {
        if (isset($_SESSION['nonce']) && !empty($_SESSION['nonce']) && isset($_POST['nonce']) && !empty($_POST['nonce']) && $_SESSION['nonce'] === $_POST['nonce']) {
            $_SESSION['nonce'] = null;
            return true;
        } else {
            return false;
        }
    }

    protected function sanitize($dirty) {
        return htmlentities(strip_tags($dirty), ENT_QUOTES);
    }

    public function handle_form_submission($action) {
        if ($this->check_nonce()) {
            $output = $this->{$this->actions[$action]}();
            if (is_array($output) && isset($output['room_id'])) {
                $room_id = $output['room_id'];
            } else {
                throw new Exception('表单提交失败');
            }
            $pusher = new Pusher(PUSHER_KEY, PUSHER_SECRET, PUSHER_APPID);
            $channel = 'presence-room_' . $room_id;
            $pusher->trigger($channel, $action, $output);
            header('Location:' . APP_URI . 'room/' . $room_id);
            exit;
        } else {
            throw new Exception('无效的临时code');
        }
    }

    abstract public function get_title();

    abstract public function output_view();
}