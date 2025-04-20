<?php

include '../check.php';
include '../last_page.php';
// include '../config.php';


if (!isset($_SESSION['username'])) {
    header('Location: ../introduce/');
    exit;
}
$conn = new mysqli("160-191-244-99.cprapid.com", "aerinidv_khanhhuyen", "khanhhuyen2412", "aerinidv_english");
// $conn = new mysqli("localhost", "root", "", "aerinidv_english");
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra quyền
$isAdmin = isset($_SESSION['username']) && $_SESSION['username'] === 'admin';

// Xử lý xoá chủ đề bằng Ajax
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_topic_id']) && $isAdmin) {
    $id = intval($_POST['delete_topic_id']);
    $stmt = $conn->prepare("DELETE FROM topic WHERE id = ?");
    $stmt->bind_param("i", $id);
    $success = $stmt->execute();
    echo json_encode(['success' => $success]);
    exit;
}

$sql = "SELECT id, topic_name, vocabulary_picture FROM topic";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Vocabulary by topic</title>
    <link rel="icon" type="image/png" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
    <link rel="stylesheet" href="../src/css/vocabularybytopic-index.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>


    <!-- <h1>Vocabulary by Topic</h1> -->
    <!-- <div class="start-tag">
        <?php if ($isAdmin): ?>
        <button onclick="window.location.href='add-topic.php'" class="add-topic-button">ADD TOPIC</button>
        <?php endif; ?>
        <button onclick="window.location.href='add-vocabulary.php'" class="add-topic-button">ADD VOCABULARY</button>
    </div> -->
    <div class="start-tag">
        <?php if ($isAdmin): ?>
        <button onclick="window.location.href='add-topic.php'" class="add-topic-button">
            <i class="fas fa-plus-circle"></i> ADD TOPIC
        </button>
        <?php endif; ?>
        <button onclick="window.location.href='add-vocabulary.php'" class="add-topic-button">
            <i class="fas fa-book"></i> ADD VOCABULARY
        </button>
    </div>


    <div class="card-list">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card" id="topic-<?php echo $row['id']; ?>"
                 onclick="handleCardClick(event, '<?php echo $isAdmin ? 'view-topic.php' : 'vocabulary_list.php'; ?>?id=<?php echo $row['id']; ?>')">
                <img src="../src/images/<?php echo htmlspecialchars($row['vocabulary_picture']); ?>"
                    alt="<?php echo htmlspecialchars($row['topic_name']); ?>">
                <div class="card-content">
                    <h2><?php echo htmlspecialchars($row['topic_name']); ?></h2>

                    <div class="icon-actions">
                        <button title="View details"
                            onclick="window.location.href='<?php echo $isAdmin ? 'view-topic.php' : 'vocabulary_list.php'; ?>?id=<?php echo $row['id']; ?>'">
                            <i class="fas fa-eye"></i>
                        </button>

                        <?php if ($isAdmin): ?>
                        <button title="Delete topic" onclick="deleteTopic(<?php echo $row['id']; ?>)">
                            <i class="fas fa-trash-alt" style="color: red;"></i>
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No topics found.</p>
    <?php endif; ?>
</div>


    <?php include '../includes/footer.php'; ?>

    <script src="../src/js/delete-topic.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
function handleCardClick(event, url) {
    // Nếu phần được bấm là nút xóa hoặc bên trong nó, thì không làm gì cả
    if (event.target.closest('button') && event.target.closest('button').title === "Delete topic") {
        return;
    }

    // Chuyển hướng nếu không phải nút xóa
    window.location.href = url;
}
</script>

</body>

</html>

<?php
$conn->close();
?>