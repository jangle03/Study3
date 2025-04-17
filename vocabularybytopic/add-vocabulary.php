<?php
session_start();

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
        echo "Error: User does not exist.";
        exit;
    }
} else {
    echo "Error: User is not logged in.";
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
        // $sql = "INSERT INTO topic_words (tu_vung_chu_de, nghia_tieng_viet, id_users, trang_thai, ngay_them, id_topic) 
        //         VALUES (?, ?, ?, 0, NOW(), ?)";
        // Nếu là admin, đặt trạng thái đã duyệt (1), ngược lại là chờ duyệt (0)
        $is_admin = ($username === 'admin') ? 1 : 0;

        $sql = "INSERT INTO topic_words (tu_vung_chu_de, nghia_tieng_viet, id_users, trang_thai, ngay_them, id_topic) 
        VALUES (?, ?, ?, ?, NOW(), ?)";


        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die('Error preparing statement: ' . $conn->error);
        }

        // Bind các tham số vào câu lệnh
        // $stmt->bind_param("ssis", $vocabulary, $meaning, $user_id, $topic_id);
        $stmt->bind_param("ssisi", $vocabulary, $meaning, $user_id, $is_admin, $topic_id);


        // Thực thi câu lệnh SQL
        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => 'Vocabulary added successfully!'];
        } else {
            $response = ['success' => false, 'message' => 'Error: ' . $stmt->error];
        }
    } else {
        $response = ['success' => false, 'message' => 'Please fill in all fields.'];
    }
} else {
    $response = ['success' => false, 'message' => ''];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add vocabulary</title>
    <link rel="icon" type="image/png" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
    <!-- <link rel="stylesheet" href="../src//css/add-sentences.css"> -->
    <link rel="stylesheet" href="../src/css/add.css">

</head>

<body>
    <?php include '../includes/header.php'; ?>
    <div class="container">
    

    <div class="content">
        <h1>Add Vocabulary</h1>
        <form class="blog-form" method="POST" action="">
            <div>
                <label for="topic_id">Topic <span style="color:red;">*</span></label>
                <select name="topic_id" id="topic_id" required>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['topic_name'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No topics yet.</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label for="vocabulary">Vocabulary <span style="color:red;">*</span></label>
                <input type="text" id="vocabulary" name="vocabulary" required>
            </div>

            <div>
                <label for="meaning">Meaning <span style="color:red;">*</span></label>
                <textarea id="meaning" name="meaning" required></textarea>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Add Vocabulary</button>
            </div>
        </form>
    </div>
</div>



    <script>
    <?php if ($response['message'] != ''): ?>
    // Hiển thị thông báo nếu có và chuyển hướng nếu thành công
    Swal.fire({
        icon: '<?php echo $response['success'] ? 'success' : 'error'; ?>',
        title: '<?php echo $response['success'] ? 'Success!' : 'An error occurred!'; ?>',
        text: '<?php echo $response['message']; ?>',
    }).then((result) => {
        if (result.isConfirmed && <?php echo $response['success'] ? 'true' : 'false'; ?>) {
            window.location.href = 'index.php';
        }
    });
    <?php endif; ?>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php include '../includes/footer.php'; ?>

</body>

</html>

<?php
// Đóng kết nối
$conn->close();
?>