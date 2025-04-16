$(document).ready(function () {
    $('#addTopicForm').on('submit', function (e) {
        e.preventDefault();

        const submitBtn = $('button[type="submit"]');
        submitBtn.prop('disabled', true);

        const formData = new FormData(this);

        $.ajax({
            url: 'add-topic.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                let res;
                try {
                    res = JSON.parse(response);
                } catch (e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Response parsing error.',
                        text: 'Invalid server response.',
                    });
                    submitBtn.prop('disabled', false);
                    return;
                }

                if (res.success) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 1800
                    }).then(() => {
                        $('#addTopicForm')[0].reset();
                        window.location.href = 'index.php';
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Notification.',
                        text: res.message
                    }).then(() => {
                        $('#addTopicForm')[0].reset(); 
                        submitBtn.prop('disabled', false);
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error.',
                    text: 'Form could not be submitted. Please try again.'
                });
                submitBtn.prop('disabled', false);
            }
        });
    });
});
