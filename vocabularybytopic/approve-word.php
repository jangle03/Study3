<?php
session_start();
$conn = new mysqli("160-191-244-99.cprapid.com", "aerinidv_khanhhuyen", "khanhhuyen2412", "aerinidv_english");
// $conn = new mysqli("localhost", "root", "", "aerinidv_english");
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($id > 0 && in_array($action, ['approve', 'reject'])) {
    $new_status = $action === 'approve' ? 1 : -1;

    // Cập nhật trạng thái từ vựng trong cơ sở dữ liệu
    $sql = "UPDATE topic_words SET trang_thai = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $new_status, $id);

    if ($stmt->execute()) {
        // Nếu trạng thái được cập nhật thành công
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'invalid']);
}

$conn->close();