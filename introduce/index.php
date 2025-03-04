<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study3 - Trang chủ</title>
</head>
<body>

<div class="bar">
    <p class="site-name">Study3</p>
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
        <?php foreach ($posts as $post): ?>
        <div class="post">
            <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
<?php if ($post['image']): ?>
                    <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image" style="max-width: 100%;">
                <?php endif; ?>
                <p><em>Đăng bởi: <?php echo htmlspecialchars($post['id_users']); ?> vào <?php echo htmlspecialchars($post['created_at']); ?></em></p>
        </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
