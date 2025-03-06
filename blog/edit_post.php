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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $imagePath = $post['image'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../blog/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
    
        // Xóa ảnh cũ nếu có
        if (!empty($post['image']) && file_exists($post['image'])) {
            unlink($post['image']); // Xóa ảnh cũ
        }
    
        // Lưu ảnh mới
        $imagePath = $uploadDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }
    

    $db->updateBlogPost($post['id'], $title, $content, $imagePath);
    header("Location: list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit post</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
    <link rel="stylesheet" href="../src/css/link-menu.css">
    <link rel="stylesheet" href="../src/css/view_post.css">
    <link rel="stylesheet" href="../src/css/blog-add.css">
    <link rel="stylesheet" href="../src/css/view_post.css">



</head>

<body>

    <?php include '../includes/header.php'; ?>

    <div class="container" style = "max-width: none";>
        <div class="sidebar" style = "width: 15%";>
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
        <h1>Edit post</h1>
        <form method="post" enctype="multipart/form-data" class="blog-form">
        <input type="hidden" name="id" value="">

        <label for="title">Title</label>
        <input type="text" id="title" name="title" value="<?php echo $post['title']; ?>" required>

        <label for="content">Content</label>
        <textarea id="content" name="content" required><?php echo $post['content']; ?></textarea>


        <label for="image">Upload Image</label>
        <div class="custom-file-upload">
            <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)">
            <label for="image" class="upload-btn"><i class="fas fa-upload"></i> Choose Image</label>
        </div>

        <div class="image-preview">
            <img id="preview" src="<?php echo !empty($post['image']) ? $post['image'] : '#'; ?>" 
                alt="Image Preview" 
                style="display: <?php echo !empty($post['image']) ? 'block' : 'none'; ?>; max-width: 100%;">
        </div>



        <div class="button-group">
            <button type="submit" name="add" class="btn btn-primary">
            <i class="fas fa-paper-plane"></i> Update
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

    <?php include '../includes/footer.php'; ?>

</body>

</html>
