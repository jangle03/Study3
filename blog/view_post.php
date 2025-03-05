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
$author = $db->find('users', $post['id_users'])[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View post</title>
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
        <h1><?php echo $post['title']; ?></h1>
        <p><strong>Ngày đăng:</strong> <?php echo $post['created_at']; ?></p>
        <p><strong>Người đăng:</strong> <?php echo $author['username']; ?></p>
        <p><strong>Nội dung:</strong></p>
        <p><?php echo $post['content']; ?></p>
        <?php if ($post['image']): ?>
            <p><strong>Hình ảnh:</strong></p>
            <img src="<?php echo $post['image']; ?>" alt="Post Image" style="max-width: 100%;">
        <?php endif; ?>
      
    </div>

    <?php include '../includes/footer.php'; ?>

</body>

</html>
