
    const usernameField = document.getElementById('username');
    const usernameError = document.getElementById('username-error');
    const submitButton = document.getElementById('submit');

    function validateForm() {
        const username = usernameField.value;
        const usernamePattern = /^[a-zA-Z0-9_]+$/;
        if (!usernamePattern.test(username)) {
            usernameError.textContent = "Username can only contain letters, numbers, and underscores!";
            submitButton.disabled = true;
        } else {
            usernameError.textContent = "";
            submitButton.disabled = false;
        }
    }

    usernameField.addEventListener('input', validateForm);

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
