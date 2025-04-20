<?php
session_start();
$conn = new mysqli("localhost", "root", "", "aerinidv_english");
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    echo "Error: User is not logged in.";
    exit;
}

$user_id = $_SESSION['user_id'];
$topic_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($topic_id == 0) {
    echo "Error: Undefined id_topic.";
    exit;
}

$sql_topic = "SELECT topic_name FROM topic WHERE id = ?";
$stmt_topic = $conn->prepare($sql_topic);
$stmt_topic->bind_param("i", $topic_id);
$stmt_topic->execute();
$topic_result = $stmt_topic->get_result();
$topic_name = $topic_result->num_rows > 0 ? $topic_result->fetch_assoc()['topic_name'] : 'Chủ đề không tồn tại';

$sql_user_words = "SELECT tw.tu_vung_chu_de, tw.nghia_tieng_viet, t.topic_name, tw.trang_thai
                   FROM topic_words tw
                   JOIN topic t ON tw.id_topic = t.id
                   WHERE tw.id_users = ? AND tw.id_topic = ?";
$stmt_user_words = $conn->prepare($sql_user_words);
$stmt_user_words->bind_param("ii", $user_id, $topic_id);
$stmt_user_words->execute();
$result_user_words = $stmt_user_words->get_result();

$sql_approved_words = "SELECT tw.tu_vung_chu_de, tw.nghia_tieng_viet, t.topic_name, tw.trang_thai, u.username
                       FROM topic_words tw
                       JOIN topic t ON tw.id_topic = t.id
                       JOIN users u ON tw.id_users = u.id
                       WHERE tw.trang_thai = 1 AND tw.id_users != ? AND tw.id_topic = ?";
$stmt_approved_words = $conn->prepare($sql_approved_words);
$stmt_approved_words->bind_param("ii", $user_id, $topic_id);
$stmt_approved_words->execute();
$result_approved_words = $stmt_approved_words->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chủ đề: <?= htmlspecialchars($topic_name) ?></title>
    <link rel="icon" type="image/png" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
    <link rel="stylesheet" href="../src/css/vocabulary_list.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container">
        <div class="topic-card">
            <h2 class="center-title">All vocabulary of the topic: <span class="highlight"><?= htmlspecialchars($topic_name) ?></span></h2>
            
            <div class="table-row">
                <!-- Bảng của bạn -->
                <div class="table-section">
                    <h3 class="card-title">Your vocabulary</h3>
                    <div class="table-wrapper">
                        <table class="table styled-table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Vocabulary</th>
                                    <th>Meaning</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result_user_words->num_rows > 0): ?>
                                    <?php $stt = 1; while ($row = $result_user_words->fetch_assoc()): ?>
                                        <?php
                                        $status = $row['trang_thai'] == 1 ? "Approved" : ($row['trang_thai'] == -1 ? "Not approved" : "Pending");
                                        $class = $row['trang_thai'] == 1 ? "approved" : ($row['trang_thai'] == -1 ? "rejected" : "pending");
                                        ?>
                                        <tr>
                                            <td><?= $stt++ ?></td>
                                            <td><?= htmlspecialchars($row['tu_vung_chu_de']) ?></td>
                                            <td><?= htmlspecialchars($row['nghia_tieng_viet']) ?></td>
                                            <td><span class="status-tag <?= $class ?>"><?= $status ?></span></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" style="text-align:center; color: red;">You haven't added any vocabulary yet.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Bảng từ được duyệt -->
                <div class="table-section">
                    <h3 class="card-title">Vocabulary approved by other users</h3>
                    <div class="table-wrapper">
                        <table class="table styled-table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Vocabulary</th>
                                    <th>User</th>
                                    <th>Meaning</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result_approved_words->num_rows > 0): ?>
                                    <?php $stt = 1; while ($row = $result_approved_words->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $stt++ ?></td>
                                            <td><?= htmlspecialchars($row['tu_vung_chu_de']) ?></td>
                                            <td><?= htmlspecialchars($row['username']) ?></td>
                                            <td><?= htmlspecialchars($row['nghia_tieng_viet']) ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" style="text-align:center; color: red;">No approved vocabulary from others yet.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>

<?php $conn->close(); ?>
