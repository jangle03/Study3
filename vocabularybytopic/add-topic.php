<?php
$conn = new mysqli("localhost", "root", "", "aerinidv_english");
$conn->set_charset("utf8");

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $topic_name = $_POST['topic_name'];

    // Kiểm tra và xử lý ảnh upload
    $target_dir = "../src/images/";
    $target_file = $target_dir . basename($_FILES["vocabulary_picture"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra loại tệp
    $allowed_types = array("jpg", "jpeg", "png", "gif");
    if (in_array($imageFileType, $allowed_types)) {
        if (move_uploaded_file($_FILES["vocabulary_picture"]["tmp_name"], $target_file)) {
            // Chèn dữ liệu vào cơ sở dữ liệu
            $sql = "INSERT INTO topic (topic_name, vocabulary_picture) VALUES ('$topic_name', '" . basename($_FILES["vocabulary_picture"]["name"]) . "')";
            if ($conn->query($sql) === TRUE) {
                $response['success'] = true;
                $response['message'] = 'Chủ đề đã được thêm thành công!';
            } else {
                $response['message'] = 'Không thể thêm chủ đề vào cơ sở dữ liệu.';
            }
        } else {
            $response['message'] = 'Có lỗi khi tải ảnh lên.';
        }
    } else {
        $response['message'] = 'Chỉ chấp nhận tệp ảnh JPG, JPEG, PNG và GIF.';
    }

    // Trả về kết quả dưới dạng JSON cho AJAX
    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Thêm chủ đề mới</title>
    <link rel="icon" type="image/png" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
    <link rel="stylesheet" href="../src/css/vocabularybytopic-index.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> <!-- Ensure SweetAlert2 is included -->
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="header">
        <h1>Thêm chủ đề mới</h1>
    </div>

    <div class="form-container">
        <form id="addTopicForm" action="add-topic.php" method="post" enctype="multipart/form-data">
            <label for="topic_name">Tên chủ đề:</label>
            <input type="text" id="topic_name" name="topic_name" required>

            <label for="vocabulary_picture">Tải lên ảnh:</label>
            <input type="file" id="vocabulary_picture" name="vocabulary_picture" accept="image/*" required>

            <button type="submit" class="add-topic-button">THÊM CHỦ ĐỀ</button>
        </form>
    </div>

    <script src="../src/js/add-topic.js"></script> <!-- Include custom JS -->
</body>

</html>