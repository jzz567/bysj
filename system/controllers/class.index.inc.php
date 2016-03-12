<?php

class Index extends Controller {
    function __construct($options) {
        return true;
    }

    public function get_title() {
        // TODO: Implement get_title() method.
        return '实时对话';
    }

    public function output_view() {
        // TODO: Implement output_view() method.
        $view = new View('index');
        $view->login_action = APP_URI . 'user/login';
        $view->reg_action = APP_URI . 'user/regform';
        $view->render();
    }
}