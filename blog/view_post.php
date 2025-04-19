<?php include '../check.php'; ?>
<?php include '../last_page.php'; ?>
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
$avatar = !empty($author['profile_picture']) ? $author['profile_picture'] : 'default.png';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
    <link rel="stylesheet" href="../src/css/blog-index.css">
    <link rel="stylesheet" href="../src/css/view_post.css">

</head>

<body>
    <?php include '../includes/header.php'; ?>
    <div class="container">
        <div class="sidebar">
            <h2>Menu</h2>
            <ul>
                <li><a href="index.php">Home Blog</a></li>
                <?php if ($_SESSION['username'] === 'admin'): ?>
                <li><a href="post_management.php">Post Management</a></li>
                <?php endif; ?>
                <li><a href="add.php">Add Blog</a></li>
                <li><a href="list.php">List my Blog</a></li>

            </ul>
        </div>
        <div class="content">
            <!-- <p><a href="javascript:history.back()" class="btn btn-primary">Back</a></p> -->
            <div class="post">
                <div class="post-header">
                    <img src="../src/images/profile-image/<?php echo htmlspecialchars($userProfiles[$post['id_users']]['profile_picture']); ?>"
                        alt="Profile Image" class="post-avatar"
                        onerror="this.onerror=null;this.src='../src/images/profile-image/default.png';">


                    <div>
                        <span class="post-author"><?php echo htmlspecialchars($author['username']); ?></span>
                        <p class="post-meta" style="font-size: 12px; color: #666; margin-top: 0px; margin-left: 00px;">
                            <?php echo htmlspecialchars($post['created_at']); ?>
                        </p>
                    </div>
                </div>
                <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                <?php if ($post['image']): ?>
                <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image" class="post-image"
                    onerror="this.onerror=null;this.src='../src/images/blog/default-post.png';">
                <?php endif; ?>

            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>

</html>