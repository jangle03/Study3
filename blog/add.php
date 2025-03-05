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
        header("Location: index.php");
        exit();
    } elseif (isset($_POST['update'])) {
        $db->updateBlogPost($_POST['id'], $_POST['title'], $_POST['content'], $imagePath);
    } elseif (isset($_POST['delete'])) {
        $db->deleteBlogPost($_POST['id']);
    } elseif (isset($_POST['approve'])) {
        $db->approveBlogPost($_POST['id']);
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
    <p><a href="javascript:history.back()" class="btn btn-primary">Quay trở về</a></p>
        <h1>Blog</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="">
            <input type="text" name="title" placeholder="Title" required>
            <textarea name="content" placeholder="Content" required></textarea>
            <input type="file" name="image" placeholder="Upload Image">
            <button type="submit" name="add">Add Post</button>
        </form>
        
    </div>

    <?php include '../includes/footer.php' ?>

</body>

</html>