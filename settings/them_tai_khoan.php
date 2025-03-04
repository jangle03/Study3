<?php
include '../check.php';
include '../last_page.php';

if ($_SESSION['username'] !== 'admin') {
    header("Location: ../");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $profile_picture = $_FILES['profile_picture']['name'];

    if ($profile_picture) {
        $target_dir = "../src/images/profile-image/";
        $target_file = $target_dir . basename($profile_picture);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file);
    } else {
        $profile_picture = 'default.png';
    }

    $hashed_password = $query->hashPassword($password);

    $query->insert('users', [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'username' => $username,
        'password' => $hashed_password,
        'profile_picture' => $profile_picture
    ]);

    header("Location: users.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
    <link rel="stylesheet" href="../src/css/add.css">
</head>
<body>

    <?php include '../includes/header.php'; ?>
    <div class="justify-center">
        <div class="add-container">
            <h1>Add new user</h1>
            <form id="wordForm" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-pen-ruler"></i>
                        </span>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                        <label for="first_name">First Name</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-pen-ruler"></i>
                        </span>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                        <label for="last_name">Last Name</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-pen-ruler"></i>
                        </span>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <label for="email">Email<span>*</span></label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-pen-ruler"></i>
                        </span>
                        <input type="text" class="form-control" id="username" name="username" required>
                        <label for="username"><span>*</span>Username</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-pen-ruler"></i>
                        </span>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <label for="password"><span>*</span>Password</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-pen-ruler"></i>
                        </span>
                        <input type="file" class="form-control-file" id="profile_picture" name="profile_picture">
                        <label for="profile_picture">Profile Picture</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit">Add user</button>
                </div>

            </form>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
