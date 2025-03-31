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
    <!-- <link rel="stylesheet" href="../src/css/blog-index.css"> -->
    <link rel="stylesheet" href="../src/css/header.css">

</head>
<body>
<header>
    <a href="../">
        <img src="../src/images/logo.png" alt="logo" class="header-logo">
    </a>
    <a href="/login/" class="login-button">Login</a>
</header>


<div class="container">
    <div class="content">
        <!-- <h2>Newsletter</h2> -->
        <?php
            require_once '../config.php';
            $db = new Database();
            $posts = $db->select('blog', '*', 'WHERE status = 1');

            if (!$posts) {
                echo "<p>Không có bài đăng nào.</p>";
            }

            foreach ($posts as $post): 
                $author = $db->find('users', $post['id_users'])[0];
                $avatar = !empty($author['profile_picture']) ? $author['profile_picture'] : 'default.png';

            ?>
        <div class="post">
    <div class="post-header">
        <img src="../src/images/profile-image/<?php echo htmlspecialchars($avatar); ?>" 
            alt="Profile Image" class="post-avatar">
        <div style="margin-top: -13px;">
            <span class="post-author" ><?php echo strtoupper(htmlspecialchars($author['username'])); ?></span>
            
        </div>
    </div>
    <p class="post-meta" style="font-size: 12px; color: #666; margin-top: -16px; margin-left: 65px;">
   <?php echo htmlspecialchars($post['created_at']); ?>
</p>


    <h3><?php echo htmlspecialchars($post['title']); ?></h3>
    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
    
    <?php if ($post['image']): ?>
        <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image" class="post-image">
    <?php endif; ?>
</div>

    <?php endforeach; ?>

    </div>
</div>

<?php include '../includes/footer.php' ?>
</body>
</html>
