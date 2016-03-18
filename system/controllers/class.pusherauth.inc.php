<?php

class PusherAuth extends Controller {
    public function __construct($options) {
        parent::__construct($options);
        $this->model = new User_Model;
        $this->actions = array(
            'auth' => 'pusher_auth',
        );
        $this->action = $this->actions[$options[0]];
        $output = $this->{$this->action}();
    }

    protected function pusher_auth() {
        header('Content-Type: application/json');
        $pusher = new Pusher(PUSHER_KEY, PUSHER_SECRET, PUSHER_APPID);
        $presence_data = array('name' => $_SESSION['user_name']);
        $a = $pusher->presence_auth($_POST['channel_name'], $_POST['socket_id'], $_SESSION['user_id'], $presence_data);
        echo $a;
    }

    public function get_title() {
        // TODO: Implement get_title() method.
    }

    public function output_view() {
        // TODO: Implement output_view() method.
    }
}