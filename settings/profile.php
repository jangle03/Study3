<?php include '../check.php'; ?>
<?php include '../last_page.php';

$user_id = $_SESSION['user_id'];
$user = $query->find('users', $user_id)[0];

$username = htmlspecialchars($user['username']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $profile_picture = $user['profile_picture'];
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = $_FILES['profile_picture']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = '../src/images/profile-image/';
        $dest_path = $uploadFileDir . $newFileName;

        if ($profile_picture && $profile_picture !== 'default.png') {
            $oldFilePath = $uploadFileDir . $profile_picture;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $profile_picture = $newFileName;
        }
    }

    $updateData = [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'profile_picture' => $profile_picture
    ];

    if (!empty($password)) {
        $updateData['password'] = $query->hashPassword($password);
    }

    $query->update('users', $updateData, 'id = ?', [$user_id], 'i');

    header("Location: profile.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../src/css/profile.css">
</head>

<body>

    <?php include '../includes/header.php'; ?>

    <div class="profile-container">
        <div class="profile-content">
            <div class="profile-left">
                <img class="profile-image"
                    src="../src/images/profile-image/<?php echo $user['profile_picture'] ? $user['profile_picture'] : 'default.png'; ?>?t=<?php echo time(); ?>"
                    alt="Profile Image">
                <h2 class="profile-name"><?php echo $username; ?></h2>
            </div>

            <div class="profile-right">
                <form id="profile-form" action="profile.php" method="POST" enctype="multipart/form-data">

                    <label for="first_name" class="form-label">First Name:</label>
                    <input type="text" id="first_name" name="first_name" class="form-input"
                        value="<?php echo htmlspecialchars($user['first_name']); ?>" required maxlength="30">

                    <label for="last_name" class="form-label">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" class="form-input"
                        value="<?php echo htmlspecialchars($user['last_name']); ?>" required maxlength="30">

                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-input"
                        value="<?php echo htmlspecialchars($user['email']); ?>" required readonly maxlength="100">

                    <label for="profile_picture" class="form-label">Profile Picture:</label>
                    <!-- <input type="file" id="profile_picture" name="profile_picture" class="form-input" accept="image/*"> -->
                    <div class="custom-file-input">
                        <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                        <div class="file-input-content" onclick="document.getElementById('profile_picture').click();">
                            <span id="file-label">Choose File</span>
                            <i class="fa-solid fa-image"></i>
                        </div>
                    </div>

                    <label for="password" class="form-label">New Password:</label>
                    <input type="password" id="password" name="password" class="form-input"
                        placeholder="No change? Leave blank." maxlength="255">

                    <button type="submit" class="submit-button">Save Changes</button>
                </form>
            </div>
        </div>
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
    <!-- <script>
        document.getElementById('profile_picture').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                document.getElementById('file-label').textContent = file.name;
            }
        });
    </script> -->


</body>

</html>
