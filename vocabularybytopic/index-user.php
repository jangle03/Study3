<?php
// Bắt đầu phiên làm việc
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập hoặc không phải admin, chuyển hướng về trang login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "aerinidv_english");
$conn->set_charset("utf8");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Truy vấn lấy thông tin các chủ đề
$sql = "SELECT id, topic_name, vocabulary_picture FROM topic";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Vocabulary by Topic</title>
    <link rel="icon" type="image/png" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
    <link rel="stylesheet" href="../src/css/vocabularybytopic-index.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <!-- <div class="header">
        <h1>Vocabulary by Topic</h1>
        <div class="start-tag">
            <button onclick="window.location.href='add-vocabulary.php'" class="add-topic-button">THÊM TỪ VỰNG</button>
            <button id="addVocabularyButton" class="add-topic-button">THÊM TỪ VỰNG</button>
        </div>
    </div> -->

    <div class="header">
        <h1>Vocabulary by Topic</h1>
        <div class="start-tag">
            <button onclick="window.location.href='add-vocabulary.php'" class="add-topic-button">THÊM TỪ VỰNG</button>
        </div>
    </div>


    <div class="card-list">
        <?php
        // Kiểm tra nếu có dữ liệu trả về từ truy vấn
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) :
        ?>
        <a href="vocabulary_list.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="card-link">
            <!-- Sửa đây -->
            <div class="card">
                <img src="../src/images/<?php echo htmlspecialchars($row['vocabulary_picture']); ?>"
                    alt="<?php echo htmlspecialchars($row['topic_name']); ?>">
                <div class="card-content">
                    <h2><?php echo htmlspecialchars($row['topic_name']); ?></h2>
                </div>
            </div>
        </a>
        <?php
            endwhile;
        } else {
            echo "<p>No topics found.</p>";
        }
        ?>
    </div>


    <?php include '../includes/footer.php'; ?>
    <!-- <script>
    document.getElementById("addVocabularyButton").addEventListener("click", function() {
        window.location.href = 'add-vocabulary.php';
    });
    </script> -->

</body>

</html>

<?php
// Đóng kết nối
$conn->close();
?>