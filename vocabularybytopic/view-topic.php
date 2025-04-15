<?php
$conn = new mysqli("localhost", "root", "", "aerinidv_english");
$conn->set_charset("utf8");

$topic_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql_topic = "SELECT topic_name FROM topic WHERE id = $topic_id";
$topic_result = $conn->query($sql_topic);
$topic_name = $topic_result->num_rows > 0 ? $topic_result->fetch_assoc()['topic_name'] : 'Chủ đề không tồn tại';

$sql_words = "SELECT w.*, u.username 
              FROM topic_words w 
              JOIN users u ON w.id_users = u.id 
              WHERE w.id_topic = $topic_id";
$words_result = $conn->query($sql_words);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Vocabulary: <?php echo htmlspecialchars($topic_name); ?></title>
    <link rel="icon" type="image/png" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
    <link rel="stylesheet" href="../src/css/view-topic.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="header">
        <h1>Vocabulary of the topic: <?php echo htmlspecialchars($topic_name); ?></h1>
    </div>

    <div class="word-list">
        <?php if ($words_result->num_rows > 0): ?>
        <table class="word-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Vocabulary</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1;
                    while ($row = $words_result->fetch_assoc()):
                        // Xử lý trạng thái
                        if ($row['trang_thai'] == 1) $trangThaiText = 'Approved';
                        elseif ($row['trang_thai'] == -1) $trangThaiText = 'Not approved';
                        else $trangThaiText = 'Pending approval';
                    ?>
                <tr>
                    <td><?php echo $stt++; ?></td>
                    <td><?php echo htmlspecialchars($row['tu_vung_chu_de']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo $trangThaiText; ?></td>
                    <td>
                        <?php if ($row['trang_thai'] == 0): ?>
                        <button onclick="duyetTu(<?php echo $row['id']; ?>)">Approve</button>
                        <button onclick="khongDuyetTu(<?php echo $row['id']; ?>)">Not approved</button>
                        <?php endif; ?>
                        <button onclick="xemChiTiet(
                            '<?php echo addslashes($row['tu_vung_chu_de']); ?>',
                            '<?php echo addslashes($row['username']); ?>',
                            '<?php echo date('d/m/Y', strtotime($row['ngay_them'])); ?>',
                            '<?php echo addslashes($row['nghia_tieng_viet']); ?>'
                        )">View details</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>There are no words in this topic yet.</p>
        <?php endif; ?>
    </div>

    <!-- Modal -->
    <div id="modalChiTiet" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close" onclick="dongModal()">&times;</span>
            <h2>Vocabulary details</h2>
            <p><strong>Vocabulary:</strong> <span id="modalTuVung"></span></p>
            <p><strong>User:</strong> <span id="modalNguoiThem"></span></p>
            <p><strong>Date added:</strong> <span id="modalNgayThem"></span></p>
            <p><strong>Vietnamese meaning:</strong> <span id="modalNghia"></span></p>
        </div>
    </div>

    <script src="../src/js/view-topic.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <?php include '../includes/footer.php'; ?>
</body>

</html>