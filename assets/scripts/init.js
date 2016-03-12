$(function () {
    channel.bind('close', function (data) {
        room.close();
    });
    channel.bind('open', function (data) {
        room.open();
    });
    channel.bind('ask', function (data) {
        question.ask(data);
    });
    channel.bind('vote', function (data) {
        question.vote(data);
    });
    channel.bind('answer', function (data) {
        question.answer(data);
    });
    channel.bind('send-message', function (data) {
        $show_msg = $("#show_msg");
        $show_msg.append(new Date().toLocaleTimeString() + '  ' + data.name + "说:" + "\r\n" + data.msg + '\r\n').scrollTop($show_msg[0].scrollHeight);
    });
    var room = {
        open: function (data) {
            location.reload();
        },
        close: function (data) {
            location.reload();
        }
    };
    var question = {
        ask: function (data) {
            $(data.markup).find('input[name=nonce]').val('nonce').end().hide().prependTo('#questions').slideDown('slow')
        },
        vote: function (data) {
            var question = $('#question-' + data.question_id);
            var cur_count = question.data('count');
            new_count = cur_count + 1;
            question.attr('data-count', new_count).data('count', new_count).addClass('new-vote');
            setTimeout(1000, function () {
                question.removeClass('new-vote');
            });
        },
        answer: function (data) {
            var question = $('#question-' + data.question_id);
            var detach_me = function () {
                question.detach().appendTo('#questions').slideDown(500);
            };
            question.addClass('answered').delay(1000).slideUp(500, detach_me);
        }
    }
    $('#msg_form').submit(function () {
        $.post('msg', $(this).serialize());
        $('#msg').val("");
        return false;
    });
});