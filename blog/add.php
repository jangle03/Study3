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
        // Kiểm tra nếu user là admin
        $status = ($_SESSION['username'] === 'admin') ? 1 : 0;
        $db->addBlogPost($_POST['title'], $_POST['content'], $_SESSION['user_id'], $imagePath, $status);
         header("Location: index.php");
        exit();
    }
     elseif (isset($_POST['update'])) {
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
    <!-- <link rel="stylesheet" href="../src/css/link-menu.css"> -->
    <link rel="stylesheet" href="../src/css/blog-add.css">

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
        <h1>New post</h1>
    <form method="post" enctype="multipart/form-data" class="blog-form">
        <input type="hidden" name="id" value="">

        <label for="title">Title</label>
        <input type="text" name="title" id="title" placeholder="Write a Title" required>

        <label for="content">Content</label>
        <textarea name="content" id="content" placeholder="Write a Content" required></textarea>

        <label for="image">Upload Image</label>
        <div class="custom-file-upload">
            <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)">
            <label for="image" class="upload-btn"><i class="fas fa-upload"></i> Choose Image</label>
        </div>

        <div class="image-preview">
            <img id="preview" src="#" alt="Image Preview" style="display: none;">
        </div>


        <div class="button-group">
            <button type="submit" name="add" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Add Post
            </button>
        </div>
    </form>


    </div>
        
    </div>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var preview = document.getElementById('preview');
                preview.src = reader.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

    <?php include '../includes/footer.php' ?>

</body>

</html>