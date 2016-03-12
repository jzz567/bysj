<?php

class Home extends Controller {
    function __construct() {
        return true;
    }

    public function get_title() {
        // TODO: Implement get_title() method.
        return '实时对话';
    }

    public function output_view() {
        // TODO: Implement output_view() method.
        $view = new View('home');
        $view->nonce = $this->generate_nonce();
        $view->join_action = APP_URI . 'room/join';
        $view->create_action = APP_URI . 'room/create';
        $view->render();
    }
}