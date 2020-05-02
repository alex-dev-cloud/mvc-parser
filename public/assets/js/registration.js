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
            if  (data.success && !data.errors.length) {
                document.location.href = '/user/login';
            } else {
                if (data.errors.loginError) {
                    $('#login-error').text(data.errors.loginError).addClass("error");
                    $('#login-input').addClass('error').removeClass("success");
                }
                if (data.errors.emailError) {
                    $('#email-error').text(data.errors.emailError).addClass("error");
                    $('#email-input').addClass('error').removeClass("success");
                }
                if (data.errors.passwordError) {
                    $('#password-error').text(data.errors.passwordError).addClass("error");
                    $('#password-input').addClass('error').removeClass("success");
                }
                if (data.errors.passwordRepeatError) {
                    $('#passwordRepeat-error').text(data.errors.passwordRepeatError).addClass("error");
                    $('#password-repeat-input').addClass('error').removeClass("success");
                }
            }
        }
    });

});