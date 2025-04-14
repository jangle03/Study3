<?php
session_start();
$conn = new mysqli("localhost", "root", "", "aerinidv_english");
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra đăng nhập
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    echo "Lỗi: Người dùng chưa đăng nhập.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Lấy id_topic từ URL (nếu có)
$topic_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Nếu không có id_topic hoặc id_topic không hợp lệ, dừng lại
if ($topic_id == 0) {
    echo "Lỗi: Không xác định id_topic.";
    exit;
}

// Truy vấn chủ đề theo id_topic
$sql_topic = "SELECT topic_name FROM topic WHERE id = ?";
$stmt_topic = $conn->prepare($sql_topic);
$stmt_topic->bind_param("i", $topic_id);
$stmt_topic->execute();
$topic_result = $stmt_topic->get_result();
$topic_name = $topic_result->num_rows > 0 ? $topic_result->fetch_assoc()['topic_name'] : 'Chủ đề không tồn tại';

// Truy vấn tất cả các từ vựng mà user hiện tại đã thêm cho id_topic cụ thể
$sql_user_words = "SELECT tw.tu_vung_chu_de, tw.nghia_tieng_viet, t.topic_name, tw.trang_thai
                   FROM topic_words tw
                   JOIN topic t ON tw.id_topic = t.id
                   WHERE tw.id_users = ? AND tw.id_topic = ?";
$stmt_user_words = $conn->prepare($sql_user_words);
$stmt_user_words->bind_param("ii", $user_id, $topic_id);
$stmt_user_words->execute();
$result_user_words = $stmt_user_words->get_result();

// Truy vấn tất cả các từ vựng đã được duyệt từ các user khác cho id_topic cụ thể
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
    <title>Từ vựng theo chủ đề: <?= htmlspecialchars($topic_name) ?></title>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #aaa;
        text-align: left;
    }

    .pending {
        color: orange;
    }

    .approved {
        color: green;
    }

    .other-approved {
        color: blue;
    }
    </style>
</head>

<body>
    <h2>Tất cả từ vựng của chủ đề: <?= htmlspecialchars($topic_name) ?></h2>

    <?php if ($result_user_words->num_rows > 0): ?>
    <h3>Từ vựng của bạn</h3>
    <table>
        <tr>
            <th>STT</th>
            <th>Từ vựng</th>
            <th>Nghĩa</th>
            <th>Trạng thái</th>
        </tr>
        <?php
            $stt = 1;
            while ($row = $result_user_words->fetch_assoc()):
                $status = $row['trang_thai'] == 1 ? "Đã duyệt" : ($row['trang_thai'] == -1 ? "Không được duyệt" : "Chờ duyệt");
                $class = $row['trang_thai'] == 1 ? "approved" : ($row['trang_thai'] == -1 ? "pending" : "pending");
            ?>
        <tr>
            <td><?= $stt++ ?></td>
            <td><?= htmlspecialchars($row['tu_vung_chu_de']) ?></td>
            <td><?= htmlspecialchars($row['nghia_tieng_viet']) ?></td>
            <td class="<?= $class ?>"><?= $status ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
    <p>Bạn chưa thêm từ vựng nào cho chủ đề này.</p>
    <?php endif; ?>

    <h3>Từ vựng đã duyệt từ các người dùng khác</h3>
    <?php if ($result_approved_words->num_rows > 0): ?>
    <table>
        <tr>
            <th>STT</th>
            <th>Từ vựng</th>
            <th>Người thêm</th>
            <th>Nghĩa</th>
        </tr>
        <?php
            $stt = 1;
            while ($row = $result_approved_words->fetch_assoc()):
            ?>
        <tr>
            <td><?= $stt++ ?></td>
            <td><?= htmlspecialchars($row['tu_vung_chu_de']) ?></td>
            <td class="other-approved"><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['nghia_tieng_viet']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
    <p>Chưa có từ vựng nào được duyệt từ các người dùng khác cho chủ đề này.</p>
    <?php endif; ?>

    <br><a href="index.php">← Trở về</a>
</body>

</html>

<?php $conn->close(); ?>