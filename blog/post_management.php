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
    } elseif (isset($_POST['update'])) {
        $db->updateBlogPost($_POST['id'], $_POST['title'], $_POST['content'], $imagePath);
    } elseif (isset($_POST['delete'])) {
        $db->deleteBlogPost($_POST['id']);
    } elseif (isset($_POST['approve'])) {
        $db->approveBlogPost($_POST['id']);
    } elseif (isset($_POST['unapprove'])) {
        $db->unapproveBlogPost($_POST['id']);
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
    <!-- <link rel="stylesheet" href="../src/css/link-menu.css"> -->
    <link rel="stylesheet" href="../src/css/post_management.css">
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
            <h1>Post Management</h1>
            <table border="1px">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>User name</th>
                        <th>Status</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $index => $post):
                        $author = $db->find('users', $post['id_users'])[0];
                    ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo ($post['title']); ?></td>
                        <td><?php echo ($post['created_at']); ?></td>
                        <td><?php echo ($author['username']); ?></td>
                        <td>
                            <?php if ($post['status'] == 1): ?>
                            <span>Approved</span>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                            </form>
                            <?php elseif ($post['status'] == -1): ?>
                            <span>Not approved</span>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                            </form>
                            <?php else: ?>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                                <button type="submit" name="approve" class="btn btn-success">Approved</button>
                            </form>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                                <button type="submit" name="unapprove" class="btn btn-warning">Not approved</button>
                            </form>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                            </form>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="view_post.php?id=<?php echo $post['id']; ?>" class="btn btn-info">View details</a>
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