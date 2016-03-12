<?php

class Question extends Controller {

    public $room_id,
        $is_presenter = FALSE;

    public function __construct($options) {
        parent::__construct($options);

        $this->model = new Question_Model;
        $this->actions = array(
            'ask' => 'create_question',
            'vote' => 'vote_question',
            'answer' => 'answer_question',
        );

        if (array_key_exists($options[0], $this->actions)) {
            $this->handle_form_submission($options[0]);
            exit;
        } else {
            $this->room_id = isset($options[0]) ? (int)$options[0] : 0;
            if ($this->room_id === 0) {
                throw new Exception("Invalid room ID supplied");
            }
        }
    }

    public function get_title() {
        return NULL;
    }

    public function output_view() {
        $questions = $this->get_questions();

        $output = NULL;
        foreach ($questions as $question) {
            $view = new View('question');
            $view->question = $question->question;
            $view->room_id = $this->room_id;
            $view->question_id = $question->question_id;
            $view->vote_count = $question->vote_count;

            if ($question->is_answered == 1) {
                $view->answered_class = 'answered';
            } else {
                $view->answered_class = NULL;
            }

            $cookie = 'voted_for_' . $question->question_id;
            if (isset($_COOKIE[$cookie]) && $_COOKIE[$cookie] == 1) {
                $view->voted_class = 'voted';
            } else {
                $view->voted_class = NULL;
            }

            $view->vote_link = $this->output_vote_form(
                $this->room_id,
                $question->question_id,
                $question->is_answered
            );

            $view->answer_link = $this->output_answer_form(
                $this->room_id,
                $question->question_id
            );

            $output .= $view->render(FALSE);
        }

        return $output;
    }

    protected function output_vote_form($room_id, $question_id, $answered) {
        $view = new View('question-vote');
        $view->room_id = $room_id;
        $view->question_id = $question_id;
        $view->form_action = APP_URI . 'question/vote';
        $view->nonce = $this->generate_nonce();
        $view->disabled = $answered == 1 ? 'disabled' : NULL;

        return $view->render(FALSE);
    }

    protected function output_answer_form($room_id, $question_id) {
        $view = new View('question-answer');
        $view->room_id = $room_id;
        $view->question_id = $question_id;
        $view->form_action = APP_URI . 'question/answer';
        $view->nonce = $this->generate_nonce();

        return $view->render(FALSE);
    }

    public function output_ask_form($is_active, $email) {
        if ($is_active) {
            $view = new View('ask-form');
            $view->room_id = $this->room_id;
            $view->form_action = APP_URI . 'question/ask';
            $view->nonce = $this->generate_nonce();

            return $view->render(FALSE);
        } else {
            $view = new View('room-closed');
            $view->email = $email;

            return $view->render(FALSE);
        }
    }

    protected function get_questions() {
        return $this->model->get_room_questions($this->room_id);
    }

    protected function create_question() {
        $room_id = $this->sanitize($_POST['room_id']);
        $question = $this->sanitize($_POST['new-question']);

        $output = $this->model->create_question($room_id, $question);
        if (is_array($output) && isset($output['question_id'])) {
            $room_id = $output['room_id'];
            $question_id = $output['question_id'];
            $view = new View('question');
            $view->question = $question;
            $view->room_id = $room_id;
            $view->question_id = $question_id;
            $view->vote_count = 1;
            $view->answered_class = NULL;
            $view->voted_class = NULL;

            $view->vote_link = $this->output_vote_form(
                $room_id,
                $question_id,
                FALSE
            );

            $view->answer_link = $this->output_answer_form(
                $room_id,
                $question_id
            );

            $output['markup'] = $view->render(FALSE);
        } else {
            throw new Exception('Error creating the room.');
        }
        setcookie('voted_for_' . $question_id, 1, time() + 2592000, '/');

        return $output;
    }

    protected function vote_question() {
        $room_id = $this->sanitize($_POST['room_id']);
        $question_id = $this->sanitize($_POST['question_id']);
        $cookie_id = 'voted_for_' . $question_id;
        if (!isset($_COOKIE[$cookie_id]) || $_COOKIE[$cookie_id] != 1) {
            $output = $this->model->vote_question($room_id, $question_id);
            setcookie($cookie_id, 1, time() + 2592000, '/');
        } else {
            $output = array('room_id' => $room_id);
        }
        return $output;
    }

    protected function answer_question() {
        $room_id = $this->sanitize($_POST['room_id']);
        $cookie_id = 'presenter_room_' . $room_id;
        if (isset($_COOKIE[$cookie_id]) && $_COOKIE[$cookie_id] == 1) {
            return $this->model->answer_question($room_id, $question_id);
        }

        return array('room_id' => $room_id);
    }

}
