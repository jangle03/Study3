<?php require_once '../check.php' ?>
<?php require_once '../last_page.php' ?>
<?php require_once '../config.php'; ?>

<?php


$db = new Database();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../blog/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $imagePath = $uploadDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    if (isset($_POST['add'])) {
        $db->addBlogPost($_POST['title'], $_POST['content'], $_SESSION['user_id'], $imagePath);
    } elseif (isset($_POST['update'])) {
        $db->updateBlogPost($_POST['id'], $_POST['title'], $_POST['content'], $imagePath);
    } elseif (isset($_POST['delete'])) {
        $db->deleteBlogPost($_POST['id']);
    } elseif (isset($_POST['approve'])) {
        $db->approveBlogPost($_POST['id']);
    } elseif (isset($_POST['unapprove'])) {
        $db->update('blog', ['status' => -1], ['id' => $_POST['id']]);
    }
}
$posts = $db->select('blog');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
    <link rel="stylesheet" href="../src/css/link-menu.css">
</head>

<body>

    <?php include '../includes/header.php' ?>

    <div class="container">
        <h1>Post Management</h1>
        <table border="1px">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tiêu đề</th>
                    <th>Ngày đăng</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $index => $post): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($post['title']); ?></td>
                        <td><?php echo htmlspecialchars($post['created_at']); ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                                <button type="submit" name="approve" class="btn btn-success">Duyệt</button>
                            </form>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                                <button type="submit" name="unapprove" class="btn btn-warning">Không duyệt</button>
                            </form>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                                <button type="submit" name="delete" class="btn btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php include '../includes/footer.php' ?>

    <script>
        function Logout() {
            const menuToggle = document.querySelector('.header-menu-toggle');
            const links = document.querySelector('.header-links');
            const icon = menuToggle.querySelector('i');
            links.classList.remove('active');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this action!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, log out!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {

                    window.location.href = '../logout/';
                }
            });
        }
    </script>
</body>

</html>