<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../src/css/root.css">
<link rel="stylesheet" href="../src/css/footer.css">
<footer>
    <div class="footer">
        <p>&copy; 2024 Dictionary Portal. All Rights Reserved.</p>
        <p>Follow us on
            <a href="https://iqbolshoh.uz" target="_blank" class="social-icon"><i class="fas fa-globe"></i></a>
            <a href="https://t.me/iqbolshoh_777" target="_blank" class="social-icon"><i class="fab fa-telegram"></i></a>
            <a href="https://www.instagram.com/iqbolshoh_777" target="_blank" class="social-icon"><i
                    class="fab fa-instagram"></i></a>
        </p>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.querySelector('.header-menu-toggle');
        const links = document.querySelector('.header-links');
        const icon = menuToggle.querySelector('i');

        menuToggle.addEventListener('click', function() {
            if (links.classList.contains('active')) {
                links.classList.remove('active');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            } else {
                links.classList.add('active');
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            }
        });

        document.addEventListener('click', function(event) {
            const isClickInsideMenu = links.contains(event.target);
            const isClickInsideToggle = menuToggle.contains(event.target);

            if (!isClickInsideMenu && !isClickInsideToggle && links.classList.contains('active')) {
                links.classList.remove('active');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    });
</script>