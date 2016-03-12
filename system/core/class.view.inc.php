<?php

class View {
    protected $view, $vars = array();

    public function __construct($view = null) {
        if (!$view) {
            throw new Exception("没有提供View");
        }
        $this->view = $view;
    }

    public function __set($key, $var) {
        $this->vars[$key] = $var;
    }

    public function render($print = true) {
        extract($this->vars);
        $view_filepath = SYS_PATH . '/views/' . $this->view . '.inc.php';
        if (!file_exists($view_filepath)) {
            throw new Exception("视图文件不存在");
        }
        if (!$print) {
            ob_start();
        }
        require $view_filepath;
        if (!$print) {
            return ob_get_clean();
        }
    }
}