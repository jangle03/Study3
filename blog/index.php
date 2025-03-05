<?php include '../check.php' ?>
<?php include '../last_page.php' ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
    <link rel="stylesheet" href="../src/css/link-menu.css">
</head>

<body>
<?php include '../includes/header.php' ?>
<div class="container">

    <div class="content">
 
        <h2>Bản tin</h2>
        <?php if ($_SESSION['username'] === 'admin'): ?>
            <a href="post_management.php" class="btn btn-primary mb-3">Post Management.</a>
        <?php endif; ?>
        <a href="add.php" class="btn btn-primary mb-3">Add Blog</a>
        <a href="list.php" class="btn btn-primary mb-3">List my Blog</a>
        <?php
        require_once '../config.php';
        $db = new Database();
        $posts = $db->select('blog', '*', 'WHERE status = 1');
        if (!$posts) {
            echo "<p>Không có bài đăng nào.</p>";
        }
        $usernames = [];
        $users = $db->select('users', 'id, username');
        foreach ($users as $user) {
            $usernames[$user['id']] = $user['username'];
        }
        ?>
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <h3><?php echo ($post['title']); ?></h3>
                <p><?php echo ($post['content']); ?></p>
                <?php if ($post['image']): ?>
                    <img src="<?php echo ($post['image']); ?>" alt="Post Image" style="max-width: 100%;">
                <?php endif; ?>
                <p><em>Đăng bởi: <?php echo ($usernames[$post['id_users']]); ?> vào <?php echo ($post['created_at']); ?></em></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>


</body>
</html>
