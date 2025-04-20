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
                    <input type="text" id="first_name" name="first_name" required maxlength="30">
                    <label for="first_name">First Name</label>
                </div>
            </div>
            <!-- Last Name -->
            <div class="form-group">
                <div class="input-wrapper">
                    <span class="icon">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" id="last_name" name="last_name" required maxlength="30">
                    <label for="last_name">Last Name</label>
                </div>
            </div>
            <!-- Email -->
            <div class="form-group">
                <div class="input-wrapper">
                    <span class="icon">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email" id="email" name="email" required maxlength="100">
                    <label for="email">Email</label>
                    <p id="email-message"></p>
                </div>
            </div>
            <!-- Username -->
            <div class="form-group">
                <div class="input-wrapper">
                    <span class="icon">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" id="username" name="username" required maxlength="30">
                    <label for="username">Username</label>
                    <p id="username-message"></p>
                </div>
            </div>
            <!-- Password -->
            <div class="form-group">
                <div class="input-wrapper">
                    <div class="password-container">
                        <span class="icon">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" id="password" name="password" required maxlength="255">
                        <label for="password">Password</label>
                        <button type="button" id="toggle-password" class="password-toggle">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Button -->
            <div class="form-group">
                <button type="submit" id="submit">Sign Up</button>
            </div>

            <div class="text-center">
                <p>Already have an account? <a href="../login/">Login</a></p>
            </div>
        </form>
        <!-- <div class="text-center">
            <p>Already have an account? <a href="../login/">Login</a></p>
        </div> -->
    </div>

    <script src="../src/js/sweetalert2.js"></script>

    <script>
        let isEmailAvailable = false;
        let isUsernameAvailable = false;
// testtest
        function validateUsernameFormat(username) {
            const usernamePattern = /^[a-zA-Z0-9_]+$/;
            return usernamePattern.test(username);
        }

        document.getElementById('email').addEventListener('input', function() {
            let email = this.value;
            if (email.length > 0) {
                fetch('check_availability.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `email=${encodeURIComponent(email)}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        const messageElement = document.getElementById('email-message');
                        if (data.exists) {
                            messageElement.textContent = 'This email exists!';
                            isEmailAvailable = false;
                        } else {
                            messageElement.textContent = '';
                            isEmailAvailable = true;
                        }
                    });
            }
        });

        document.getElementById('username').addEventListener('input', function() {
            let username = this.value;
            const messageElement = document.getElementById('username-message');

            if (!validateUsernameFormat(username)) {
                messageElement.textContent = 'Username can only contain letters, numbers, and underscores!';
                isUsernameAvailable = false;
                return;
            }

            if (username.length > 0) {
                fetch('check_availability.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `username=${encodeURIComponent(username)}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            messageElement.textContent = 'This username exists!';
                            isUsernameAvailable = false;
                        } else {
                            messageElement.textContent = '';
                            isUsernameAvailable = true;
                        }
                    });
            } else {
                messageElement.textContent = '';
            }
        });

        function validateEmailFormat(email) {
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            return emailPattern.test(email);
        }

        document.getElementById('signupForm').addEventListener('submit', function(event) {
            let email = document.getElementById('email').value;
            const emailMessageElement = document.getElementById('email-message');
            let username = document.getElementById('username').value;
            const usernameMessageElement = document.getElementById('username-message');

            if (!validateEmailFormat(email)) {
                emailMessageElement.textContent = 'Email format is incorrect!';
                event.preventDefault();
                return;
            }

            if (!validateUsernameFormat(username)) {
                usernameMessageElement.textContent = 'Username can only contain letters, numbers, and underscores!';
                event.preventDefault();
                return;
            }

            if (isEmailAvailable === false) {
                emailMessageElement.textContent = 'This email exists!';
                event.preventDefault();
            }

            if (isUsernameAvailable === false) {
                usernameMessageElement.textContent = 'This username exists!';
                event.preventDefault();
            }
        });

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
    </script>

</body>

</html>