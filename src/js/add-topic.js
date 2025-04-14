$(document).ready(function () {
    // Gán sự kiện khi form được gửi
    $('#addTopicForm').on('submit', function (e) {
        e.preventDefault();

        // Vô hiệu hóa nút submit để tránh gửi nhiều lần
        $('button[type="submit"]').prop('disabled', true);

        // Sử dụng FormData để gửi dữ liệu bao gồm cả file
        var formData = new FormData(this);

        // Thực hiện AJAX để gửi form
        $.ajax({
            url: 'add-topic.php',
            type: 'POST',
            data: formData,
            processData: false, // Không xử lý dữ liệu
            contentType: false, // Không thiết lập content-type
            success: function (response) {
                var res = JSON.parse(response); // Phân tích dữ liệu JSON

                if (res.success) {
                    // Hiển thị thông báo thành công
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Chuyển hướng về trang danh sách chủ đề
                        window.location.href = 'index.php';
                    });
                } else {
                    // Hiển thị thông báo lỗi
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: res.message,
                    }).then(() => {
                        // Bật lại nút submit
                        $('button[type="submit"]').prop('disabled', false);
                    });
                }
            },
            error: function () {
                // Hiển thị thông báo nếu có lỗi khi gửi form
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Có lỗi xảy ra khi gửi form.',
                }).then(() => {
                    $('button[type="submit"]').prop('disabled', false);
                });
            }
        });
    });
});
