<?php

class User extends Controller {
    protected $view;

    public function __construct($options) {
        parent::__construct($options);
        $this->model = new User_Model;
        $this->actions = array(
            'login' => 'user_login',
            'regform' => 'user_regform',
            'reg' => 'user_reg',
            'logout' => 'user_logout',
            'update' => 'user_update',
        );
        $this->action = $this->actions[$options[0]];
        $output = $this->{$this->action}();
    }

    public function get_title() {

    }

    public function output_view() {
        $this->view->render();
    }

    protected function user_login() {
        $username = $this->sanitize($_POST['username']);
        $password = $this->sanitize($_POST['password']);
        $login_info = $this->model->check_login($username, $password);
        if (isset($login_info) && !empty($login_info)) {
            $_SESSION["vaild_user"] = true;
            $_SESSION["user_id"] = $login_info[0];
            $_SESSION["user_name"] = $login_info[1];
            header("Location:" . APP_URI . 'home/');
            exit;
        } else {
            $_SESSION["vaild_user"] = null;
            throw new Exception("用户名或密码错误");
        }
    }

    protected function user_regform() {
        $this->view = new View('reg-form');
        $this->view->reg_action = APP_URI . 'user/reg';
    }

    protected function user_reg() {
        $username = $this->sanitize($_POST['username']);
        $email = $this->sanitize($_POST['email']);
        $password = $this->sanitize($_POST['password']);
        $reg_status = $this->model->reg($username, $email, $password);
        if ($reg_status == true) {
            $this->view = new View("reg-success");
        } else {
            throw new Exception("注册失败,可能用户名重名");
        }
    }

    protected function user_logout() {
        $_SESSION['vaild_user'] = null;
        session_destroy();
        $this->view = new View('logout');
    }

    protected function user_update() {
        $this->view = new View('udate-form');
    }
}
