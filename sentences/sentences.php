<?php include '../check.php'; ?>
<?php include '../last_page.php';

$wordId = intval($_GET['word_id']);

$word_name = $query->select(
    'words',
    'word',
    'WHERE id = ?',
    [$wordId],
    'i'
)[0]['word'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sentences</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
    <link rel="stylesheet" href="../src/css/dictionary-sentences.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">

        <form id="searchForm" onsubmit="return false;">
            <label for="word" style="display: none;">Search Word:</label>
            <input type="text" id="word" name="word" placeholder="Type a word..." required>
            <button type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <div class="container-wrapper">
            <div class="display-flex">
                <select id="languageSelect">
                    <option value="eng">English</option>
                    <option value="uz">Uzbek</option>
                </select>
                <div id="liked-btn-1" class="heart-box">
                    <i class='fas fa-heart' id="liked1"></i>
                </div>
            </div>

            <div class="display-flex">
                <button onclick="window.location.href='./add.php?word_id=<?= $wordId ?>'">
                    Add a sentences
                </button>
                <div id="liked-btn-2" class="heart-box">
                    <i class='fas fa-heart' id="liked2"></i>
                </div>
            </div>

        </div>

        <div class="word-container">
            <p class="title"><?= $word_name ?></p>
        </div>

        <input type="hidden" id="wordId" value="<?php echo htmlspecialchars($wordId); ?>">

        <div id="suggestions"></div>
        <div id="result"></div>

    </div>

    <?php include '../includes/footer.php'; ?>

    <script src="../src/js/sentences.js"></script>

</body>

</html>