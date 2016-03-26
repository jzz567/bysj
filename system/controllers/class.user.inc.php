<?php

class User extends Controller {
    protected $view;

    public function __construct($options) {
        parent::__construct($options);
        $this->model = new User_Model;
        $this->actions = array(
            'login' => 'user_login',
            'weibo_login' => 'weibo_login',
            'regform' => 'user_regform',
            'reg' => 'user_reg',
            'logout' => 'user_logout',
            'update' => 'user_update',
            'auth' => 'user_auth',
        );
        if (strpos($options[0], "weibo_login") !== false) {
            $options[0] = "weibo_login";
        }
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
            $_SESSION["email"] = $login_info[2];
            header("Location:" . APP_URI . 'home/');
            exit;
        } else {
            $_SESSION["vaild_user"] = null;
            throw new Exception("用户名或密码错误");
        }
    }

    protected function weibo_login() {
        if (!empty($_GET['code']) && isset($_GET['code'])) {
            $code = $_GET['code'];
        } else {
            throw new Exception("你取消了微博登录!");
        }
        $data = $this->weibo("https://api.weibo.com/oauth2/access_token?client_id=1949395522&client_secret=461bd6312821defb5aa3393732c94940&grant_type=authorization_code&code=$code&redirect_uri=https://51php.org/bysj/weibo_login", 1);
        $access_token = json_decode($data, true)['access_token'];
        $data = $this->weibo("https://api.weibo.com/oauth2/get_token_info?access_token=$access_token", 1);
        $uid = json_decode($data, true)['uid'];
        $data = $this->weibo("https://api.weibo.com/2/users/show.json?access_token=$access_token&uid=$uid", 0);
        $data = json_decode($data, true);
        $_SESSION["vaild_user"] = true;
        $_SESSION["user_id"] = $uid;
        $_SESSION["user_name"] = "Weibo_" . $data['screen_name'];
        $_SESSION["email"] = "";
        header("Location:" . APP_URI . 'home/');
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
        $this->view = new View('update-form');
    }

    protected function user_auth() {
        $data = array();
        if (isset($_POST['username']) && !empty($_POST['username'])) {
            $data = array("name", $this->sanitize($_POST['username']));
        }
        if (isset($_POST['email']) && !empty($_POST['email'])) {
            $data = array("email", $this->sanitize($_POST['email']));
        }
        echo $this->model->user_auth($data);
    }

    protected function weibo($url, $is_post) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($is_post == 1) {
            curl_setopt($ch, CURLOPT_POST, 1);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
