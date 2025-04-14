<?php
session_start(); // Đảm bảo session đã được bắt đầu

// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "aerinidv_english");
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username']; // Lấy username từ session

    // Kiểm tra sự tồn tại của username trong bảng users và lấy id của người dùng
    $check_user_sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($check_user_sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Lấy user_id
        $stmt->bind_result($user_id);
        $stmt->fetch();
    } else {
        echo "Lỗi: Người dùng không tồn tại.";
        exit;
    }
} else {
    echo "Lỗi: Người dùng chưa đăng nhập.";
    exit;
}

// Lấy danh sách chủ đề để điền vào dropdown list
$sql = "SELECT id, topic_name FROM topic";
$result = $conn->query($sql);

// Kiểm tra nếu form đã được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy các dữ liệu từ form
    $topic_id = $_POST['topic_id'];
    $vocabulary = $_POST['vocabulary'];
    $meaning = $_POST['meaning'];

    // Kiểm tra nếu chủ đề và từ vựng không rỗng
    if (!empty($topic_id) && !empty($vocabulary) && !empty($meaning)) {
        // Chèn từ vựng vào cơ sở dữ liệu
        $sql = "INSERT INTO topic_words (tu_vung_chu_de, nghia_tieng_viet, id_users, trang_thai, ngay_them, id_topic) 
                VALUES (?, ?, ?, 0, NOW(), ?)";

        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die('Error preparing statement: ' . $conn->error);
        }

        // Bind các tham số vào câu lệnh
        $stmt->bind_param("ssis", $vocabulary, $meaning, $user_id, $topic_id);

        // Thực thi câu lệnh SQL
        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => 'Từ vựng đã được thêm thành công!'];
        } else {
            $response = ['success' => false, 'message' => 'Lỗi: ' . $stmt->error];
        }
    } else {
        $response = ['success' => false, 'message' => 'Vui lòng nhập đầy đủ các trường.'];
    }
} else {
    $response = ['success' => false, 'message' => ''];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Thêm Từ Vựng</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> <!-- SweetAlert2 -->
</head>

<body>
    <h1>Thêm Từ Vựng</h1>
    <form method="POST" action="">
        <label for="topic_id">Chủ Đề:</label>
        <select name="topic_id" id="topic_id" required>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['topic_name'] . "</option>";
                }
            } else {
                echo "<option value=''>Không có chủ đề nào</option>";
            }
            ?>
        </select>
        <br><br>

        <label for="vocabulary">Từ Vựng:</label>
        <input type="text" id="vocabulary" name="vocabulary" required>
        <br><br>

        <label for="meaning">Nghĩa:</label>
        <textarea id="meaning" name="meaning" required></textarea>
        <br><br>

        <button type="submit">Thêm</button>
    </form>

    <script>
    <?php if ($response['message'] != ''): ?>
    // Hiển thị thông báo nếu có và chuyển hướng nếu thành công
    Swal.fire({
        icon: '<?php echo $response['success'] ? 'success' : 'error'; ?>',
        title: '<?php echo $response['success'] ? 'Thành công!' : 'Có lỗi xảy ra!'; ?>',
        text: '<?php echo $response['message']; ?>',
    }).then((result) => {
        if (result.isConfirmed && <?php echo $response['success'] ? 'true' : 'false'; ?>) {
            window.location.href = 'index-user.php';
        }
    });
    <?php endif; ?>
    </script>


</body>

</html>

<?php
// Đóng kết nối
$conn->close();
?>