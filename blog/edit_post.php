<?php require_once '../check.php'; ?>
<?php require_once '../config.php'; ?>

<?php
if (!isset($_GET['id'])) {
    die("Post ID is required.");
}

$db = new Database();
$post = $db->find('blog', $_GET['id']);

if (!$post) {
    die("Post not found.");
}

$post = $post[0];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $imagePath = $post['image'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../blog/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $imagePath = $uploadDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    $db->updateBlogPost($post['id'], $title, $content, $imagePath);
    header("Location: list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit post</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
    <link rel="stylesheet" href="../src/css/link-menu.css">
</head>

<body>

    <?php include '../includes/header.php'; ?>

    <div class="container">
        <p><a href="javascript:history.back()" class="btn btn-primary">Quay trở về</a></p>
        <h1>Edit post</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Tiêu đề:</label>
                <input type="text" id="title" name="title" value="<?php echo $post['title']; ?>" required>
            </div>
            <div class="form-group">
                <label for="content">Nội dung:</label>
                <textarea id="content" name="content" required><?php echo $post['content']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">Hình ảnh:</label>
                <input type="file" id="image" name="image">
                <?php if ($post['image']): ?>
                    <img src="<?php echo $post['image']; ?>" alt="Post Image" style="max-width: 100%;">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-success">Cập nhật</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>

</body>

</html>
