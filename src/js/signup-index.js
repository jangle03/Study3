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
