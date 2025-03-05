<?php include '../check.php'; ?>
<?php include '../last_page.php'; ?>
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
    <link rel="stylesheet" href="../src/css/blog-index.css">
    
</head>

<body>
<?php include '../includes/header.php'; ?>
<div class="container">
    <div class="sidebar">
        <h2>Menu</h2>
        <ul>
                <li><a href="index.php">Home</a></li>
                <?php if ($_SESSION['username'] === 'admin'): ?>
                    <li><a href="post_management.php">Post Management</a></li>
                <?php endif; ?>
                <li><a href="add.php">Add Blog</a></li>
                <li><a href="list.php">List my Blog</a></li>
                
            </ul>
    </div>
    <div class="content">
        <h2>Bản tin</h2>
        
        <?php
        require_once '../config.php';
        $db = new Database();
        $posts = $db->select('blog', '*', 'WHERE status = 1');
        if (!$posts) {
            echo "<p>Không có bài đăng nào.</p>";
        }
        $userProfiles = [];
        $users = $db->select('users', 'id, username, profile_picture');
        foreach ($users as $user) {
        $userProfiles[$user['id']] = [
        'username' => $user['username'],
        'profile_picture' => !empty($user['profile_picture']) ? $user['profile_picture'] : 'default.png'
    ];
}

        ?>
        <?php foreach ($posts as $post): ?>
    <div class="post">
        <div class="post-header">
        <img src="../src/images/profile-image/<?php echo htmlspecialchars($userProfiles[$post['id_users']]['profile_picture']); ?>" 
     alt="Profile Image" class="post-avatar"
     onerror="this.onerror=null;this.src='../src/images/profile-image/default.png';">

            <span class="post-author"><?php echo htmlspecialchars($userProfiles[$post['id_users']]['username']); ?></span>
        </div>
        
        <p class="post-meta"style="font-size: 12px; color: #666; margin-top: -11px; margin-left: 61px;"><?php echo htmlspecialchars($post['created_at']); ?></p>
        <h3><?php echo htmlspecialchars($post['title']); ?></h3>
        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
        <?php if ($post['image']): ?>
            <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image" class="post-image">
        <?php endif; ?>
    </div>
<?php endforeach; ?>



        
    </div>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>