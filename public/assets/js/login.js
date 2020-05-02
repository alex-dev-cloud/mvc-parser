$('button[name="submit"]').click(function (e) {
    e.preventDefault();
    let login = $('#login-input').val();
    let password = $('#password-input').val();

    $(".form-control").removeClass("error").addClass("success");
    $(".error-box").text('').removeClass("error");

    $.ajax({
        url: 'login',
        type: 'POST',
        dataType: 'json',

        data: {
            login: login,
            password: password,
        },

        success: function (data) {
            console.log(data)
            if (data.success && !data.errors.length) {
                document.location.href = '/';
            } else {
                if (data.errors.loginError) {
                    $('#login-error').text(data.errors.loginError).addClass("error");
                    $('#login-input').addClass('error').removeClass("success");
                }
                if (data.errors.passwordError) {
                    $('#password-error').text(data.errors.passwordError).addClass("error");
                    $('#password-input').addClass('error').removeClass("success");
                }
            }
        }
    });

});