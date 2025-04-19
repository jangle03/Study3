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
        $imageName = "default.jpg"; // mặc định

        // Nếu có ảnh được tải lên
        if (isset($_FILES["vocabulary_picture"]) && $_FILES["vocabulary_picture"]["error"] == UPLOAD_ERR_OK) {
            $target_dir = "../src/images/";
            $target_file = $target_dir . basename($_FILES["vocabulary_picture"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowed_types = array("jpg", "jpeg", "png", "gif");

            if (in_array($imageFileType, $allowed_types)) {
                if (move_uploaded_file($_FILES["vocabulary_picture"]["tmp_name"], $target_file)) {
                    $imageName = basename($_FILES["vocabulary_picture"]["name"]);
                } else {
                    $response['message'] = 'There was an error uploading the image.';
                    echo json_encode($response);
                    exit;
                }
            } else {
                $response['message'] = 'Only JPG, JPEG, PNG and GIF image files are accepted.';
                echo json_encode($response);
                exit;
            }
        }

        // Chèn dữ liệu vào cơ sở dữ liệu
        $stmt = $conn->prepare("INSERT INTO topic (topic_name, vocabulary_picture) VALUES (?, ?)");
        $stmt->bind_param("ss", $topic_name, $imageName);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Topic added successfully!';
        } else {
            $response['message'] = 'Unable to add topic to database.';
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
    <!-- <link rel="stylesheet" href="../src/css/blog-add.css"> -->

</head>

<body>
    <?php include '../includes/header.php'; ?>

    <!-- <div class="header">
        <h1>Add new topic</h1>
    </div>

    <div class="form-container">
        <form id="addTopicForm" action="add-topic.php" method="post" enctype="multipart/form-data">
            <label for="topic_name">Topic name:</label>
            <input type="text" id="topic_name" name="topic_name" required>

            <label for="vocabulary_picture">Upload file:</label>
            <input type="file" id="vocabulary_picture" name="vocabulary_picture" accept="image/*">

            <button type="submit" class="add-topic-button">ADD TOPIC</button>
        </form>
    </div> -->
    <div class="justify-center">
        <!-- <div class="add-container">
            <h1>Add New Topic</h1>

            <form id="addTopicForm" action="add-topic.php" method="post" enctype="multipart/form-data">
               
                <div class="form-group">
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-tag"></i>
                        </span>
                        <input type="text" id="topic_name" name="topic_name" required maxlength="150">
                        <label for="topic_name">Topic Name<span>*</span></label>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-image"></i>
                        </span>
                        <input type="file" id="vocabulary_picture" name="vocabulary_picture" accept="image/*">
                        <label for="vocabulary_picture">Upload Image</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <button type="submit">Add Topic</button>
                </div>
            </form>
        </div> -->

        <div class="container">
            <div class="content">
                <h1>Add New Topic</h1>
                <form class="blog-form" action="add-topic.php" method="post" enctype="multipart/form-data">
                
                    <div>
                        <label for="topic_name">Topic Name <span style="color:red;">*</span></label>
                        <input type="text" id="topic_name" name="topic_name" required>
                    </div>

            
                    <div>
                        <label for="vocabulary_picture">Upload Image</label>
                        <label class="custom-file-upload">
                            <input type="file" id="vocabulary_picture" name="vocabulary_picture" accept="image/*">
                            <span class="upload-btn">Choose File</span>
                        </label>
                        <div class="image-preview" id="preview-container"></div>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">Add Topic</button>
                    </div>
                </form>
            </div>
        </div>

    </div>


    <?php include '../includes/footer.php'; ?>
    <script src="../src/js/add-topic.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.getElementById("vocabulary_picture").addEventListener("change", function (event) {
            const previewContainer = document.getElementById("preview-container");
            previewContainer.innerHTML = "";
            const file = event.target.files[0];

            if (file) {
                const img = document.createElement("img");
                img.src = URL.createObjectURL(file);
                img.onload = () => URL.revokeObjectURL(img.src);
                previewContainer.appendChild(img);
            }
        });
</script>

</body>

</html>