$('button[name="submit"]').click(function (e) {
    e.preventDefault();

    let inputs = {};

    inputs.login = document.querySelector('#login-input');
    inputs.email = document.querySelector('#email-input');
    inputs.password = document.querySelector('#password-input');
    inputs.passwordRepeat = document.querySelector('#password-repeat-input');

    let values = {}

    for (let input in inputs) {
        inputs[input].classList.remove('error');
        inputs[input].classList.add('success');
        values[input] = inputs[input].value;
    }

    let errorBoxes = document.querySelectorAll('.error-box');

    for (let box of errorBoxes) {
        box.classList.remove('error');
        box.innerText = '';
    }

    $.ajax({

        url: '/user/registration',
        type: 'POST',
        dataType: 'json',

        data: {
            login: values.login,
            email: values.email,
            password: values.password,
            passwordRepeat: values.passwordRepeat,
        },

        success: function (data) {
            console.log(data)
            if  (data.success && !data.errors.length) {
                document.location.href = '/user/login';
            } else {

                for (let input in inputs) {
                    for (let error in data.errors) {
                        if (error && error === input + 'Error') {
                            inputs[input].classList.add('error');
                            inputs[input].classList.remove('success');
                            let errorBox = document.querySelector(`#${input}-error`);
                            errorBox.classList.add('error');
                            errorBox.innerHTML = data.errors[error];
                        }
                    }
                }
            }
        }
    });

});