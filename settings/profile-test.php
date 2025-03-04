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
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon.ico">
    <link rel="stylesheet" href="../src/css/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
</head>

<body>

    <?php include '../includes/header.php'; ?>

    <div class="profile-container">
        <div class="profile-form-container">
            <div class="profile-header">
                <!-- <img class="profile-image"
                    src="../src/images/profile-image/<?php echo $user['profile_picture'] ? $user['profile_picture'] : 'default.png'; ?>"
                    alt="Profile Image"> -->
                    <img class="profile-image"
                    src="../src/images/profile-image/<?php echo $user['profile_picture'] ? $user['profile_picture'] : 'default.png'; ?>?t=<?php echo time(); ?>"
                    alt="Profile Image">

                <h2 class="profile-name"><?php echo htmlspecialchars($user['username']); ?></h2>
            </div>
            <form id="profile-form" action="profile.php" method="POST" enctype="multipart/form-data"
                class="profile-form">
                <label for="first_name" class="form-label">First Name:</label>
                <input type="text" id="first_name" name="first_name" class="form-input"
                    value="<?php echo htmlspecialchars($user['first_name']); ?>" required maxlength="30">

                <label for="last_name" class="form-label">Last Name:</label>
                <input type="text" id="last_name" name="last_name" class="form-input"
                    value="<?php echo htmlspecialchars($user['last_name']); ?>" required maxlength="30">

                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-input" value="<?php echo $username; ?>"
                    readonly maxlength="30">

                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-input"
                    value="<?php echo htmlspecialchars($user['email']); ?>" required readonly maxlength="100">

                <label for="profile_picture" class="form-label">Profile Picture:</label>
                <div class="custom-file-input">
                    <input type="file" id="profile_picture" name="profile_picture" class="form-input" accept="image/*">
                    <div class="file-input-content">
                        <span class="file-label">Choose File</span>
                        <i class="fa-solid fa-image"></i>
                    </div>
                </div>

                <label for="password" class="form-label">New Password:</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" class="password-input"
                        placeholder="No change? Leave blank." maxlength="255">
                    <a type="button" id="toggle-password" class="password-toggle"><i class="fas fa-eye"></i></a>
                </div>

                <button type="submit" class="submit-button">Save Changes</button>
            </form>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <!-- <script>
        document.getElementById('toggle-password').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const toggleIcon = this.querySelector('i');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });
    </script> -->
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

</body>

</html>



@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap');

*{
    font-family: 'Montserrat', sans-serif;
}

.profile-container {
    display: flex;
    justify-content: center;
    align-items: center;
    box-sizing: border-box;
    margin: 20px 0px;
}

footer {
    position: relative !important;
    display: block;
}

.profile-form-container {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 30px;
    width: calc(100% - 40px);
    max-width: 450px;
    box-sizing: border-box;
}

.profile-header {
    display: flex;
    align-items: center;
    border-bottom: 2px solid #ddd;
    padding-bottom: 20px;
    margin-bottom: 20px;
    z-index: 1;
}

.profile-header .profile-image {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ddd;
}

.profile-header .profile-name {
    margin-left: 20px;
    font-size: 24px;
    color: #333;
}

.profile-form {
    display: flex;
    flex-direction: column;
}

.profile-form .form-label {
    font-size: 16px;
    margin-bottom: 5px;
    color: #333;
}

.profile-form .form-input {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
}

.profile-form .form-input[readonly] {
    background-color: #f9f9f9;
    cursor: not-allowed;
}

.profile-form .submit-button {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 12px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.profile-form .submit-button:hover {
    background-color: #0056b3;
}

.password-container {
    position: relative;
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.password-input {
    width: 100%;
    flex: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
    color: #333;
    background-color: #fff;
    transition: border-color 0.3s ease;
    box-sizing: border-box;
}

.password-input:focus {
    border-color: #007bff;
    outline: none;
}

.password-toggle {
    position: absolute;
    right: 10px;
    font-size: 18px;
    cursor: pointer;
    border: none;
    background: transparent;
    color: #333;
}

.password-toggle:hover {
    color: #007bff;
}

.profile-header {
    display: flex;
    align-items: center;
    border-bottom: 2px solid #ddd;
    padding-bottom: 20px;
    margin-bottom: 20px;
}

.profile-name {
    margin-left: 20px;
    font-size: 28px;
    color: #333;
}

@media (max-width: 350px) {
    .profile-header .profile-image {
        width: 90px;
        height: 90px;
    }

    .profile-header .profile-name {
        font-size: 22px;
    }
}

.custom-file-input {
    margin-bottom: 20px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.custom-file-input input[type="file"] {
    width: 100%;
    height: 100%;
    padding: 0;
    margin: 0;
    opacity: 0;
    position: absolute;
    z-index: 2;
}

.file-input-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 7px 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #fff;
    color: #333;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%;
}

.file-input-content i {
    font-size: 18px;
    color: #333;
}

.custom-file-input:hover .file-input-content {
    background-color: #f1f1f1;
}

.custom-file-input input[type="file"]:focus+.file-input-content {
    border-color: #007bff;
}