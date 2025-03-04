<!-- <?php 
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/Study3";
?> -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../src/css/root.css">
<link rel="stylesheet" href="../src/css/sweetalert2.css">
<link rel="stylesheet" href="../src/css/header.css">

<script src="../src/js/sweetalert2.js"></script>
<script src="../src/js/jquery.min.js"></script>

<header>

    <a href="../">
        <img src="../src/images/logo.png" alt="logo" class="header-logo">
    </a>

    <a class="header-menu-toggle" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
    </a>

    <div class="header-links">

        <a href="../" class="header-link">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>

        <a href="../dictionary/" class="header-link">
            <i class="fas fa-language"></i>
            <span>Dictionary</span>
        </a>

        <a href="../sentences/" class="header-link">
            <i class="fas s fa-comment-dots"></i>
            <span>Sentences</span>
        </a>

        <a href="../texts/" class="header-link">
            <i class="fas fa-book link-icon"></i>
            <span class="link-text">Texts</span>
        </a>

        <a href="../exercise/" class="header-link">
            <i class="fas fa-brain"></i>
            <span>Exercise</span>
        </a>
        <a href="../blog/" class="header-link">
            <i class="fas fa-brain"></i>
            <span>Post Blog</span>
        </a>
        <a href="../settings/" class="header-link">
            <i class="fa-solid fa-gear"></i>
            <span>Settings</span>
        </a>

    </div>

    <nav class="header-nav">
        <ul>
            <li><a href="../"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="../dictionary/"><i class="fas fa-language"></i> Dictionary</a></li>
            <li><a href="../sentences/"><i class="fas fa-comment-dots"></i> Sentences</a></li>
            <li><a href="../texts/"><i class="fas fa-book link-icon"></i>Texts</a></li>
            <li><a href="../exercise/"><i class="fas fa-brain"></i> Exercise</a></li>
            <li><a href="../blog/"><i class="fas fa-brain"></i> Blog</a></li>
            <li><a href="../settings/"><i class="fa-solid fa-gear"></i> Settings</a></li>
        </ul>
    </nav>

</header>
<!-- <header>
    <a href="<?= $base_url ?>/">
        <img src="<?= $base_url ?>/src/images/logo.png" alt="logo" class="header-logo">
    </a>

    <a class="header-menu-toggle" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
    </a>

    <div class="header-links">
        <a href="<?= $base_url ?>/" class="header-link">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>

        <a href="<?= $base_url ?>/dictionary/" class="header-link">
            <i class="fas fa-language"></i>
            <span>Dictionary</span>
        </a>

        <a href="<?= $base_url ?>/sentences/" class="header-link">
            <i class="fas fa-comment-dots"></i>
            <span>Sentences</span>
        </a>

        <a href="<?= $base_url ?>/texts/" class="header-link">
            <i class="fas fa-book link-icon"></i>
            <span class="link-text">Texts</span>
        </a>

        <a href="<?= $base_url ?>/exercise/" class="header-link">
            <i class="fas fa-brain"></i>
            <span>Exercise</span>
        </a>

        <a href="<?= $base_url ?>/blog/" class="header-link">
            <i class="fas fa-brain"></i>
            <span>Post Blog</span>
        </a>

        <a href="<?= $base_url ?>/settings/" class="header-link">
            <i class="fa-solid fa-gear"></i>
            <span>Settings</span>
        </a>
    </div>

    <nav class="header-nav">
        <ul>
            <li><a href="<?= $base_url ?>/"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="<?= $base_url ?>/dictionary/"><i class="fas fa-language"></i> Dictionary</a></li>
            <li><a href="<?= $base_url ?>/sentences/"><i class="fas fa-comment-dots"></i> Sentences</a></li>
            <li><a href="<?= $base_url ?>/texts/"><i class="fas fa-book link-icon"></i> Texts</a></li>
            <li><a href="<?= $base_url ?>/exercise/"><i class="fas fa-brain"></i> Exercise</a></li>
            <li><a href="<?= $base_url ?>/blog/"><i class="fas fa-brain"></i> Post Blog</a></li>
            <li><a href="<?= $base_url ?>/settings/"><i class="fa-solid fa-gear"></i> Settings</a></li>
        </ul>
    </nav>
</header> -->