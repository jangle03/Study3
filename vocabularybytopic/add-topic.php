<?php
$conn = new mysqli("localhost", "root", "", "aerinidv_english");
$conn->set_charset("utf8");

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $topic_name = trim($_POST['topic_name']);

    // Kiểm tra xem chủ đề đã tồn tại chưa
    $check_stmt = $conn->prepare("SELECT id FROM topic WHERE topic_name = ?");
    $check_stmt->bind_param("s", $topic_name);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $response['message'] = 'Chủ đề này đã tồn tại!';
    } else {
        $imageName = "default.jpg"; // Mặc định

        // Nếu có ảnh được tải lên
        if (isset($_FILES["vocabulary_picture"]) && $_FILES["vocabulary_picture"]["error"] == UPLOAD_ERR_OK) {
            $target_dir = "../src/images/";
            $imageInfo = pathinfo($_FILES["vocabulary_picture"]["name"]);
            $imageFileType = strtolower($imageInfo['extension']);
            $allowed_types = array("jpg", "jpeg", "png", "gif");

            if (in_array($imageFileType, $allowed_types)) {
                // Đổi tên file để tránh trùng
                $newFileName = uniqid('topic_', true) . '.' . $imageFileType;
                $target_file = $target_dir . $newFileName;

                if (move_uploaded_file($_FILES["vocabulary_picture"]["tmp_name"], $target_file)) {
                    $imageName = $newFileName;
                } else {
                    $response['message'] = 'Có lỗi xảy ra khi tải ảnh lên.';
                    echo json_encode($response);
                    exit;
                }
            } else {
                $response['message'] = 'Chỉ chấp nhận các định dạng ảnh JPG, JPEG, PNG và GIF.';
                echo json_encode($response);
                exit;
            }
        }

        // Chèn vào database
        $stmt = $conn->prepare("INSERT INTO topic (topic_name, vocabulary_picture) VALUES (?, ?)");
        $stmt->bind_param("ss", $topic_name, $imageName);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Thêm chủ đề thành công!';
        } else {
            $response['message'] = 'Không thể thêm chủ đề vào cơ sở dữ liệu.';
        }
    }

    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add new topic</title>
    <link rel="icon" type="image/png" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
    <link rel="stylesheet" href="../src/css/add.css">
    <link rel="stylesheet" href="../src/css/add-topic.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <div class="content">
            <div class="form-header">
                <h1>Add New Topic</h1>
            </div>
            <form id="addTopicForm" class="blog-form" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="topic_name">Topic Name <span class="required">*</span></label>
                    <input type="text" id="topic_name" name="topic_name" placeholder="Enter topic name" required>
                </div>

                <div class="form-group">
                    <label for="vocabulary_picture">Topic Image</label>
                    <div class="file-upload-container">
                        <label class="custom-file-upload">
                            <input type="file" id="vocabulary_picture" name="vocabulary_picture" accept="image/*">
                            <span class="upload-btn"><i class="fas fa-cloud-upload-alt"></i> Choose Image</span>
                        </label>
                    </div>
                    <div class="image-preview" id="preview-container">
                        <div class="no-image">
                            <i class="fas fa-image"></i>
                            <p>Image preview will appear here</p>
                        </div>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Topic
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        // Preview ảnh
        document.getElementById("vocabulary_picture").addEventListener("change", function (event) {
            const previewContainer = document.getElementById("preview-container");
            const file = event.target.files[0];
            previewContainer.innerHTML = "";

            if (file) {
                const img = document.createElement("img");
                img.src = URL.createObjectURL(file);
                img.onload = () => URL.revokeObjectURL(img.src);
                previewContainer.appendChild(img);

                const removeBtn = document.createElement("button");
                removeBtn.className = "remove-image";
                removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                removeBtn.onclick = function (e) {
                    e.preventDefault();
                    previewContainer.innerHTML = `
                        <div class="no-image">
                            <i class="fas fa-image"></i>
                            <p>Image preview will appear here</p>
                        </div>
                    `;
                    document.getElementById("vocabulary_picture").value = "";
                };
                previewContainer.appendChild(removeBtn);
            }
        });

        // Xử lý submit bằng JS + fetch
        document.getElementById("addTopicForm").addEventListener("submit", function (e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            fetch("add-topic.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                Swal.fire({
                    icon: data.success ? 'success' : 'error',
                    title: data.success ? 'Success!' : 'Oops...',
                    text: data.message
                }).then((result) => {
                    if (data.success && result.isConfirmed) {
                        window.location.href = 'index.php';
                    }
                });
            })
            .catch(error => {
                console.error("Error:", error);
                Swal.fire("Error!", "Something went wrong!", "error");
            });
        });
    </script>
</body>
</html>
