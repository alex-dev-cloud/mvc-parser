$('button[name="submit"]').click(function (e) {
    e.preventDefault();
    let login = $('#login-input').val();
    let email = $('#email-input').val();
    let password = $('#password-input').val();
    let passwordRepeat = $('#password-repeat-input').val();

    $(".form-control").removeClass("error").addClass("success");;
    $(".error-box").text('').removeClass("error");

    $.ajax({

        url: '/user/registration',
        type: 'POST',
        dataType: 'json',

        data: {
            login: login,
            email: email,
            password: password,
            passwordRepeat: passwordRepeat,
        },
        success: function (data) {
            console.log(data)
            if (data.success) document.location.href = '/user/login';

            else {
                if (data.loginError) {
                    $('#login-error').text(data.loginError).addClass("error");
                    $('#login-input').addClass('error').removeClass("success");
                }
                if (data.emailError) {
                    $('#email-error').text(data.emailError).addClass("error");
                    $('#email-input').addClass('error').removeClass("success");
                }
                if (data.passwordError) {
                    $('#password-error').text(data.passwordError).addClass("error");
                    $('#password-input').addClass('error').removeClass("success");
                }
                if (data.passwordRepeatError) {
                    $('#passwordRepeat-error').text(data.passwordRepeatError).addClass("error");
                    $('#password-repeat-input').addClass('error').removeClass("success");
                }
            }
        }
    });

});