<?php
include '../check.php';
include '../last_page.php';

if ($_SESSION['username'] !== 'admin') {
    header("Location: ../");
    exit;
}

$id = $_GET['id'];
$user = $query->find('users', $id);

if ($user) {
    $user = $user[0];
} else {
    header("Location: users.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    if (!empty($_POST['password'])) {
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    } else {
        $hashed_password = $user['password'];
    }
    
    $profile_picture = $_FILES['profile_picture']['name'];

    if ($profile_picture) {
        $target_dir = "../src/images/profile-image/";
        $target_file = $target_dir . basename($profile_picture);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file);
    } else {
        $profile_picture = $user['profile_picture'];
    }

    $query->update('users', [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'username' => $username,
        'password' => $hashed_password,
        'profile_picture' => $profile_picture
    ], 'id = ?', [$id], 'i');
    

    header("Location: users.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/edit-account.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
    <div class="container">
        
        <div class="text-center mb-3">
        <img class="profile-image"
            src="../src/images/profile-image/<?php echo !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'default.png'; ?>?t=<?php echo time(); ?>"
            onerror="this.onerror=null;this.src='../src/images/profile-image/default.png';"
            alt="Profile Image">

            <h2 class="profile-name"><?php echo htmlspecialchars($user['username'] ?? ''); ?></h2>

            </div>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" required>

            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>First Name:</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>" required>

                </div>
                <div class="form-group col-md-6">
                    <label>Last Name:</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>" required>

                </div>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>

            </div>
            <div class="form-group">
                <label for="profile_picture">Profile Picture</label>
                <div class="custom-file">
                    <input type="file" id="profile_picture" name="profile_picture" class="custom-file-input" hidden>
                    <label for="profile_picture" class="custom-file-label">Picture</label>
                </div>

            </div>
            <div class="form-group">
                <label>New Password:</label>
                <input type="password" class="form-control" id="password" name="password">

            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
    <script>
        document.getElementById('profile_picture').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.profile-image').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>