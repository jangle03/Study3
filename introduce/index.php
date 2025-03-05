<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study3 - Trang chủ</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
    <link rel="stylesheet" href="../src/css/index_intro.css">
</head>
<body>
<?php include '../includes/header.php' ?>
<div class="bar">
    <a href="/login/" class="login-button">Login</a>
</div>

<div class="container">
    <div class="content">
        <h2>Bản tin</h2>
<?php
        require_once '../config.php';
        $db = new Database();
        $posts = $db->select('blog', '*', 'WHERE status = 1');
if (!$posts) {
            echo "<p>Không có bài đăng nào.</p>";
        }
        ?>
        <?php foreach ($posts as $post): 
            $author = $db->find('users', $post['id_users'])[0];
        ?>
        <div class="post">
            <h3><?php echo $post['title']; ?></h3>
                <p><?php echo ($post['content']); ?></p>
        <?php if ($post['image']): ?>
                    <img src="<?php echo $post['image']; ?>" alt="Post Image" style="max-width: 100%;">
                <?php endif; ?>
                <p><em>Đăng bởi: <?php echo $author['username']; ?> vào <?php echo $post['created_at']; ?></em></p>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include '../includes/footer.php' ?>
</body>
</html>
