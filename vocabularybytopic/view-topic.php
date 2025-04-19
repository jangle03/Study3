<?php
$conn = new mysqli("localhost", "root", "", "aerinidv_english");
$conn->set_charset("utf8");

// Handle delete request
if (isset($_POST['delete_vocab_id'])) {
    $id = intval($_POST['delete_vocab_id']);
    $delete_sql = "DELETE FROM topic_words WHERE id = $id";
    $res = $conn->query($delete_sql);
    echo json_encode(['success' => $res ? true : false]);
    exit;
}

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

    <!-- <div class="header">
        <h1>Vocabulary of the topic: <?php echo htmlspecialchars($topic_name); ?></h1>
    </div> -->


    <div class="word-section"> <!-- THÊM div này để gom chung -->
    <h1 class="section-title">Vocabulary of the topic: <?php echo htmlspecialchars($topic_name); ?></h1>

    <div class="word-list">
    <table class="styled-table">
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
            <?php if ($words_result->num_rows > 0): ?>
                <?php $stt = 1; ?>
                <?php while ($row = $words_result->fetch_assoc()): ?>
                    <?php
                    if ($row['trang_thai'] == 1) {
                        $trangThaiText = '<span class="status-approved">Approved</span>';
                    } elseif ($row['trang_thai'] == -1) {
                        $trangThaiText = '<span class="status-rejected">Not approved</span>';
                    } else {
                        $trangThaiText = '<span class="status-pending">Pending</span>';
                    }
                    ?>
                    <tr>
                        <td><?php echo $stt++; ?></td>
                        <td><?php echo htmlspecialchars($row['tu_vung_chu_de']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td>
                            <?php echo $trangThaiText; ?>
                            <?php if ($row['trang_thai'] == 0): ?>
                                <button class="btn btn-approve" onclick="duyetTu(<?php echo $row['id']; ?>)">Approve</button>
                                <button class="btn btn-reject" onclick="khongDuyetTu(<?php echo $row['id']; ?>)">Not approved</button>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button class="btn btn-detail" onclick="xemChiTiet(
                                '<?php echo addslashes($row['tu_vung_chu_de']); ?>',
                                '<?php echo addslashes($row['username']); ?>',
                                '<?php echo date('d/m/Y', strtotime($row['ngay_them'])); ?>',
                                '<?php echo addslashes($row['nghia_tieng_viet']); ?>',
                                <?php echo $row['id']; ?>
                            )">View details</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <!-- Dòng thông báo khi không có dữ liệu -->
                <tr>
                    <td colspan="5" style="text-align:center; color: red;">There are no words in this topic yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</div>

    


    <!-- Modal -->
    <div id="modalChiTiet" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close" onclick="dongModal()">&times;</span>
            <h2 class="vocabulary-details">Vocabulary details</h2>
            <p><strong>Vocabulary:</strong> <span id="modalTuVung"></span></p>
            <p><strong>User:</strong> <span id="modalNguoiThem"></span></p>
            <p><strong>Date added:</strong> <span id="modalNgayThem"></span></p>
            <p><strong>Vietnamese meaning:</strong> <span id="modalNghia"></span></p>

            <div class="icon-actions">
                <button title="Delete vocabulary" onclick="xoaTuVung()" class="btn btn-danger">
                    <i class="fas fa-trash-alt" style="color: red;"></i> Delete
                </button>
            </div>
        </div>
    </div>

    <script src="../src/js/view-topic.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../src/js/delete-vocabulary.js"></script>


    <?php include '../includes/footer.php'; ?>
</body>

</html>
