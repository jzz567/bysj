<?php

class Room extends Controller {
    public $room_id,
        $is_presenter,
        $is_active;

    public function __construct($options) {
        parent::__construct($options);

        $this->model = new Room_Model;

        $this->actions = array(
            'join' => 'join_room',
            'create' => 'create_room',
            'open' => 'open_room',
            'close' => 'close_room',
            'msg' => 'send_msg',
            'no-room' => 'no-room',
        );
        if ($options[0] === 'msg') {
            $this->send_msg();
            exit;
        }
        if (array_key_exists($options[0], $this->actions)) {
            $this->handle_form_submission($options[0]);
            exit;
        } else {
            $this->room_id = isset($options[0]) ? (int)$options[0] : 0;
            if ($this->room_id === 0) {
                throw new Exception("无效的房间ID");
            }
        }

        $this->room = $this->model->get_room_data($this->room_id);
        $this->is_presenter = $this->is_presenter();
        $this->is_active = (boolean)$this->room->is_active;
    }

    public function get_title() {
        return $this->room->room_name . ' by ' . $this->room->presenter_name;
    }

    public function output_view() {
        $view = new View('room');
        $view->room_id = $this->room->room_id;
        $view->room_name = $this->room->room_name;
        $view->presenter = $this->room->presenter_name;
        $view->email = $this->room->email;

        if (!$this->is_presenter) {
            $view->ask_form = $this->output_ask_form();
            $view->questions_class = NULL;
        } else {
            $view->ask_form = NULL;
            $view->questions_class = 'presenter';
        }

        if (!$this->is_active) {
            $view->questions_class = 'closed';
        }

        $view->controls = $this->output_presenter_controls();
        $view->questions = $this->output_questions();

        $view->render();
    }

    protected function output_ask_form() {
        $controller = new Question(array($this->room_id));
        return $controller->output_ask_form(
            $this->is_active,
            $this->room->email
        );
    }

    protected function output_presenter_controls() {
        if ($this->is_presenter) {
            if (!$this->is_active) {
                $view_class = 'presenter-reopen';
                $form_action = APP_URI . 'room/open';
            } else {
                $view_class = 'presenter-controls';
                $form_action = APP_URI . 'room/close';
            }

            $view = new View($view_class);
            $view->room_id = $this->room->room_id;
            $view->room_uri = APP_URI . 'room/' . $this->room_id;
            $view->form_action = $form_action;
            $view->nonce = $this->generate_nonce();

            return $view->render(FALSE);
        }

        return NULL;
    }

    protected function output_questions() {
        $controller = new Question(array($this->room_id));
        $controller->is_presenter = $this->is_presenter;
        return $controller->output_view();
    }

    protected function join_room() {
        $room_id = $this->sanitize($_POST['room_id']);
        if ($this->model->room_exists($room_id)) {
            $header = APP_URI . 'room/' . $room_id;
        } else {
            throw new Exception("房间不存在");
        }
        header("Location: " . $header);
        exit;
    }

    protected function create_room() {
        $name = $this->sanitize($_POST['session-name']);
        $output = $this->model->create_room($name);

        if (is_array($output) && isset($output['room_id'])) {
            $room_id = $output['room_id'];
        } else {
            throw new Exception('房间创建错误');
        }
        setcookie('presenter_room_' . $room_id, 1, time() + 2592000, '/');

        return $output;
    }

    protected function open_room() {
        $room_id = $this->sanitize($_POST['room_id']);
        return $this->model->open_room($room_id);
    }

    protected function close_room() {
        $room_id = $this->sanitize($_POST['room_id']);
        return $this->model->close_room($room_id);
    }

    protected function send_msg() {
        $pusher = new Pusher(PUSHER_KEY, PUSHER_SECRET, PUSHER_APPID);
        $data = array(
            'name' => $_SESSION['user_name'],
            'msg' => htmlentities(strip_tags($_POST['message']))
        );
        $pusher->trigger('presence-room_' . $_POST['room_id'], 'send-message', $data);
    }

    protected function user_disconnected() {
        $pusher = new Pusher(PUSHER_KEY, PUSHER_SECRET, PUSHER_APPID);
        $data = array(
            'name' => $_SESSION['user_name'],
            'msg' => htmlentities(strip_tags($_POST['message']))
        );
        $pusher->trigger('room_' . $_POST['room_id'], 'send-message', $data);
    }

    protected function is_presenter() {
        $cookie = 'presenter_room_' . $this->room->room_id;
        return (isset($_COOKIE[$cookie]) && $_COOKIE[$cookie] == 1);
    }
}