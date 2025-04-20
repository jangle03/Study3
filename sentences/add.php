<?php include '../check.php'; ?>
<?php include '../last_page.php';


$wordId = isset($_GET['word_id']) ? intval($_GET['word_id']) : 0;
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$results = [];
$word_name = "";

if ($wordId) {
    $word_name = $query->select(
        'words',
        'word',
        'WHERE id = ? AND user_id = ?',
        [$wordId, $userId],
        'ii'
    )[0]['word'];
} else {
    $results = $query->select(
        'words',
        '*',
        'WHERE user_id = ? ORDER BY word ASC',
        [$userId],
        'i'
    );
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Sentence</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
    <link rel="stylesheet" href="../src/css/add-sentences.css">
    <link rel="stylesheet" href="../src/css/add-dictionary.css">

</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="justify-center">
        <div class="add-container">
            <h1>Add New Sentence</h1>

            <form id="sentenceForm" method="post">
                <?php if ($wordId): ?>
                    <div class="form-group">
                        <label for="word">Selected Word</label>
                        <div class="input-wrapper">
                            <span class="icon">
                                <i class="fa-solid fa-pen-ruler"></i>
                            </span>
                            <select disabled>
                                <option><?php echo htmlspecialchars($word_name); ?></option>
                            </select>
                            <input type="hidden" id="word" name="word_id" value="<?php echo htmlspecialchars($wordId); ?>">
                        </div>
                    </div>
                <?php else: ?>
                    <div class="form-group">
                        <label for="word">Select Word <span>*</span></label>
                        <div class="input-wrapper">
                            <span class="icon">
                                <i class="fa-solid fa-pen-ruler"></i>
                            </span>
                            <select id="word" name="word_id" required>
                                <option value="">Select a Word</option>
                                <?php foreach ($results as $row): ?>
                                    <option value="<?php echo htmlspecialchars($row['id']); ?>">
                                        <?php echo htmlspecialchars($row['word']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="sentence">Sentence <span>*</span></label>
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                        <!-- <textarea id="sentence" name="sentence" required maxlength="200"></textarea> -->
                        <input type="text" id="sentence" name="sentence" placeholder="Enter sentence..." required maxlength="150">

                    </div>
                </div>

                <div class="form-group">
                    <label for="translation">Translation <span>*</span></label>
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </span>
                        <!-- <textarea id="translation" name="translation" required maxlength="255"></textarea> -->
                        <input type="text" id="translation" name="translation" placeholder="Enter translation..." required maxlength="150">

                    </div>
                </div>
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Vocabulary
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
    <script src="../src/js/sentences-add.js"></script>
</body>


</html>