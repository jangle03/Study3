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
    <title>Từ vựng: <?php echo htmlspecialchars($topic_name); ?></title>
    <link rel="stylesheet" href="../src/css/root.css">
    <link rel="stylesheet" href="../src/css/view-topic.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="header">
        <h1>Từ vựng thuộc chủ đề: <?php echo htmlspecialchars($topic_name); ?></h1>
    </div>

    <div class="word-list">
        <?php if ($words_result->num_rows > 0): ?>
        <table class="word-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Từ vựng</th>
                    <th>Người thêm</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1;
                    while ($row = $words_result->fetch_assoc()):
                        // Xử lý trạng thái
                        if ($row['trang_thai'] == 1) $trangThaiText = 'Đã duyệt';
                        elseif ($row['trang_thai'] == -1) $trangThaiText = 'Không duyệt';
                        else $trangThaiText = 'Chờ duyệt';
                    ?>
                <tr>
                    <td><?php echo $stt++; ?></td>
                    <td><?php echo htmlspecialchars($row['tu_vung_chu_de']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo $trangThaiText; ?></td>
                    <td>
                        <?php if ($row['trang_thai'] == 0): ?>
                        <button onclick="duyetTu(<?php echo $row['id']; ?>)">Duyệt</button>
                        <button onclick="khongDuyetTu(<?php echo $row['id']; ?>)">Không duyệt</button>
                        <?php endif; ?>
                        <button onclick="xemChiTiet(
                            '<?php echo addslashes($row['tu_vung_chu_de']); ?>',
                            '<?php echo addslashes($row['username']); ?>',
                            '<?php echo date('d/m/Y', strtotime($row['ngay_them'])); ?>',
                            '<?php echo addslashes($row['nghia_tieng_viet']); ?>'
                        )">Xem chi tiết</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>Chưa có từ vựng nào trong chủ đề này.</p>
        <?php endif; ?>
    </div>

    <!-- Modal -->
    <div id="modalChiTiet" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close" onclick="dongModal()">&times;</span>
            <h2>Chi tiết từ vựng</h2>
            <p><strong>Từ vựng:</strong> <span id="modalTuVung"></span></p>
            <p><strong>Người thêm:</strong> <span id="modalNguoiThem"></span></p>
            <p><strong>Ngày thêm:</strong> <span id="modalNgayThem"></span></p>
            <p><strong>Nghĩa tiếng Việt:</strong> <span id="modalNghia"></span></p>
        </div>
    </div>

    <script>
    function xemChiTiet(tuVung, nguoiThem, ngayThem, nghia) {
        document.getElementById('modalTuVung').innerText = tuVung;
        document.getElementById('modalNguoiThem').innerText = nguoiThem;
        document.getElementById('modalNgayThem').innerText = ngayThem;
        document.getElementById('modalNghia').innerText = nghia;
        document.getElementById('modalChiTiet').style.display = 'block';
    }

    function dongModal() {
        document.getElementById('modalChiTiet').style.display = 'none';
    }

    function duyetTu(id) {
        fetch(`approve-word.php?id=${id}&action=approve`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Cập nhật lại trạng thái sau khi duyệt
                    location.reload(); // Tải lại trang để cập nhật trạng thái
                } else {
                    alert("Có lỗi khi duyệt từ vựng.");
                }
            });
    }

    function khongDuyetTu(id) {
        fetch(`approve-word.php?id=${id}&action=reject`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Cập nhật lại trạng thái sau khi không duyệt
                    location.reload(); // Tải lại trang để cập nhật trạng thái
                } else {
                    alert("Có lỗi khi không duyệt từ vựng.");
                }
            });
    }
    </script>

    <?php include '../includes/footer.php'; ?>
</body>

</html>