<?php require_once '../check.php' ?>
<?php require_once '../last_page.php' ?>
<?php require_once '../config.php'; ?>

<?php

$db = new Database();
$user_id = $_SESSION['user_id'];
$posts = $db->select('blog', '*', 'WHERE id_users = ' . $user_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List my Blog</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
    <!-- <link rel="stylesheet" href="../src/css/link-menu.css"> -->
    <link rel="stylesheet" href="../src/css/blog-list.css">
    <!-- <link rel="stylesheet" href="../src/css/blog-index.css"> -->

</head>

<body>

    <?php include '../includes/header.php' ?>

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
            <!-- <p><a href="javascript:history.back()" class="btn btn-primary">Quay trở về</a></p> -->
            <h1>List my blog</h1>
            <table border="1px">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>TitleTitle</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $index => $post): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo ($post['title']); ?></td>
                            <td><?php echo ($post['created_at']); ?></td>
                            <td>
                                <?php if ($post['status'] == 1): ?>
                                    <span>Approved</span>
                                <?php elseif ($post['status'] == -1): ?>
                                    <span>Disapprove</span>
                                <?php else: ?>
                                    <span>Waiting</span>
                                    <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-warning">Edit</a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="view_post.php?id=<?php echo $post['id']; ?>" class="btn btn-info">Details</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include '../includes/footer.php' ?>
</body>

</html>
