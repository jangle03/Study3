<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ../");
    exit;
}

include '../config.php';
$query = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = $query->validate($_POST['first_name']);
    $last_name = $query->validate($_POST['last_name']);
    $email = $query->validate(strtolower($_POST['email']));
    $username = $query->validate(strtolower($_POST['username']));
    $password = $query->hashPassword($_POST['password']);

    $data = [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'username' => $username,
        'password' => $password
    ];

    $result = $query->insert('users', $data);

    if (!empty($result)) {
        $user_id = $query->select('users', 'id', 'WHERE username = ?', [$username], 's')[0]['id'];

        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user_id;

        setcookie('username', $username, time() + (86400 * 30), "/", "", true, true);
        setcookie('session_token', session_id(), time() + (86400 * 30), "/", "", true, true);
?>
        <script>
            window.onload = function() {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Registration successful',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = '../';
                });
            };
        </script>

<?php
    } else {
        echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Registration failed. Please try again later.',
                    });
                </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/login_signup.css">
    <link rel="stylesheet" href="../src/css/root.css">
</head>

<body>
    <div class="form-container">
        <h1>Sign Up</h1>
        <form id="signupForm" method="post" action="">
            <!-- First Name -->
            <div class="form-group">
                <div class="input-wrapper">
                    <span class="icon">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" id="first_name" name="first_name" required maxlength="30" placeholder="">
                    <label for="first_name">First Name</label>
                </div>
                <small id="username-error" style="color: red;"></small>
            </div>
            <!-- Last Name -->
            <div class="form-group">
                <div class="input-wrapper">
                    <span class="icon">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" id="last_name" name="last_name" required maxlength="30" placeholder="">
                    <label for="username">Last Name</label>
                </div>
                <small id="username-error" style="color: red;"></small>
            </div>
            <!-- Email -->

            <div class="form-group">
                <div class="input-wrapper">
                    <span class="icon">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email" id="email" name="email" required maxlength="30" placeholder="">
                    <label for="email">Email</label>
                </div>
                <small id="email-error" style="color: red;"></small>
            </div>
            <!-- Username -->
            <div class="form-group">
                <div class="input-wrapper">
                    <span class="icon">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" id="username" name="username" required maxlength="30" placeholder="">
                    <label for="username">Username</label>
                </div>
                <small id="username-error" style="color: red;"></small>
            </div>
            <!-- Password -->
            <div class="form-group">
                <div class="input-wrapper">
                    <span class="icon">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" id="password" name="password" required maxlength="255" placeholder="">
                    <label for="password">Password</label>
                    <button type="button" id="toggle-password" class="password-toggle">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <small id="password-error" style="color: red;"></small>
            </div>
            <!-- Button -->
            <div class="form-group">
                <button type="submit" id="submit">Sign Up</button>
            </div>

            <div class="text-center">
                <p>Already have an account? <a href="../login/">Login</a></p>
            </div>
        </form>

    </div>
    <script src="../src/js/sweetalert2.js"></script>
    <script src="../src/js/signup-index.js"></script>
</body>

</html>