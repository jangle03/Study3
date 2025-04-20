<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ../");
    exit;
}

include '../config.php';
$query = new Database();

if (isset($_COOKIE['username']) && isset($_COOKIE['session_token'])) {

    if (session_id() !== $_COOKIE['session_token']) {
        session_write_close();
        session_id($_COOKIE['session_token']);
        session_start();
    }

    $result = $query->select('users', 'id', "WHERE username = ?", [$_COOKIE['username']], 's');

    if (!empty($result)) {
        $user = $result[0];

        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['user_id'] = $user['id'];

        header("Location: ../");
        exit;
    }
}

if (isset($_POST['submit'])) {
    $username = strtolower($_POST['username']);
    $password = $query->hashPassword($_POST['password']);
    $result = $query->select('users', '*', "WHERE username = ? AND password = ?", [$username, $password], 'ss');

    if (!empty($result)) {
        $user = $result[0];

        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        setcookie('username', $username, time() + (86400 * 30), "/", "", true, true);
        setcookie('session_token', session_id(), time() + (86400 * 30), "/", "", true, true);

?>
        <script>
            window.onload = function() {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Login successful',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = '../';
                });
            };
        </script>
    <?php
    } else {
    ?>
        <script>
            window.onload = function() {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Incorrect information',
                    text: 'Login or password is incorrect',
                    showConfirmButton: true
                });
            };
        </script>
<?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../src/css/login_signup.css">
    <link rel="stylesheet" href="../src/css/root.css">
</head>

<div class="form-container">

    <h1>Login</h1>

    <form method="post" action="">
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

     
        <div class="form-group">
            <button type="submit" name="submit" id="submit" disabled>Login</button>
        </div>

        <div class="text-center">
            <p>Don't have an account? <a href="../signup/">Sign Up</a></p>
        </div>
    </form>
</div>
<script src="../src/js/sweetalert2.js"></script>
<script src="../src/js/login-index.js"></script>
</html>