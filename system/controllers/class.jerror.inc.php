<?php
class JError extends Controller {
    public function __construct($options) {
        if (isset($options[1])) {
            $this->_message = $options[1];
        }
    }

    public function get_title() {
        // TODO: Implement get_title() method.
        return '发生了错误!';
    }

    public function output_view() {
        // TODO: Implement output_view() method.
        $view = new View('error');
        $view->message = $this->_message;
        if (!isset($_SESSION['vaild_user']) && empty($_SESSION['vaild_user'])) {
            $view->back_link = APP_URI;
            $view->link_text = "返回登录";
        } else {
            $view->back_link = APP_URI . 'home';
            $view->link_text = "返回主页";
        }
        $view->render();
    }

}