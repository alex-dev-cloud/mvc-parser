$('button[type="submit"]').click(function (e) {
    e.preventDefault();
    let title = $('#postTitle').val();
    let content = $('#postContent').val();

    $(".form-control").removeClass("error").addClass("success");
    $(".error-box").text('').removeClass("error");

    $.ajax({
        url: 'post/save',
        type: 'POST',
        dataType: 'json',

        data: {
            title: title,
            content: content,
        },
        success: function (data) {
            console.log(data)
            if (data.success) document.location.href = '/post';

            else {
                if (data.titleError) {
                    $('#title-error').text(data.titleError).addClass("error");
                    $('#postTitle').addClass('error').removeClass("success");
                }
                if (data.contentError) {
                    $('#content-error').text(data.contentError).addClass("error");
                    $('#postContent').addClass('error').removeClass("success");
                }
            }
        }
    });

});