<?php
include '../check.php';
include '../last_page.php';

// PHÂN QUYỀN: Nếu không phải admin thì chuyển qua index-user.php
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: index-user.php");
    exit();
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

    <div class="header">
        <h1>Vocabulary by Topic</h1>
        <div class="start-tag">
            <button onclick="window.location.href='add-topic.php'" class="add-topic-button">THÊM CHỦ ĐỀ</button>
        </div>
    </div>


    <div class="card-list">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) :
        ?>
        <a href="view-topic.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="card-link">
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
</body>

</html>

<?php
$conn->close();
?>