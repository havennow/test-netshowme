$(document).ready(function () {
    $('#sendFormEmail').on("submit", function (event) {
        console.log('alerta');
        let url = $(this).attr('action');

        let formData = new FormData();
        let files = $('#file_attach')[0].files;

        formData.append('file_attach',files[0]);
        formData.append('name',$('#name').val());
        formData.append('email',$('#email').val());
        formData.append('phone',$('#phone').val());
        formData.append('message',$('#message').val());

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (success) {
                alert('Enviado');
                return false;
            },
            error: function (error) {
                let message = JSON.parse(error.responseText);

                alert('Error '+ message.error);
                return false;
            },
        });
        return false;
    });
});