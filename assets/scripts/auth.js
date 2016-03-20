$(function () {
    $("#reg_username").keyup(function () {
        if ($(this).val().trim().length < 6) {
            $("#tips_username").text("用户名至少6个字符").addClass('error');
        } else {
            if ($(this).val().trim() != "") {
                $.post("auth", $(this).serialize(), function (data) {
                    if (data == "true") {
                        $("#tips_username").text("恭喜您!用户名可用").removeClass('error ok').addClass('ok');
                    } else {
                        $("#tips_username").text("用户名已被占用").addClass('error');
                    }
                });
            } else {
                $(this).next().text("用户名不能为空").addClass('error');
            }
        }
    });
    $("#reg_email").keyup(function () {
        if ($(this).val().trim() != "") {
            var exp = /[\w!#$%&'*+/=?^_`{|}~-]+(?:\.[\w!#$%&'*+/=?^_`{|}~-]+)*@(?:[\w](?:[\w-]*[\w])?\.)+[\w](?:[\w-]*[\w])?/;
            var patt = new RegExp(exp);
            var result = patt.test($(this).val());
            if ((result) == true) {
                $.post("auth", $(this).serialize(), function (data) {
                    if (data == "true") {
                        $("#tips_email").text("恭喜您!邮箱可用").removeClass('error ok').addClass('ok');
                        ;
                    } else {
                        $("#tips_email").text("邮箱已被占用").addClass('error');
                    }
                });
            } else {
                $("#tips_email").text("邮箱格式错误").addClass('error');
            }
        } else {
            $(this).next().text("邮箱不能为空").addClass('error');
        }
    });
    $("#reg_password1").keyup(function () {
        if ($(this).val().trim().length < 6) {
            $(this).next().text("密码长度要大于6").addClass('error');
        } else {
            $(this).next().text("密码格式正确").removeClass('error ok').addClass('ok');
        }
    });
    $("#reg_password2").keyup(function () {
        if ($(this).val().trim().length < 6) {
            $(this).next().text("密码长度要大于6").addClass('error');
        } else {
            if ($("#reg_password1").val() !== $(this).val()) {
                $(this).next().text("输入的密码不一致").addClass('error');
            } else {
                $(this).next().text("密码格式正确").removeClass('error ok').addClass('ok');
            }
        }
    });
    $('#reg_submit').click(function () {
        var $error = $("#reg_form").find('.error')
        if ($error.length != 0) {
            alert("你填写的资料有误,请重新填写!");
            return false;
        }
    });
});