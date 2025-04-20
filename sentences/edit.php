<?php
include '../check.php';

$userId = $_SESSION['user_id'];
$sentence_id = isset($_GET['sentence_id']) ? (int)$_GET['sentence_id'] : 0;

$sentence = $query->select('sentences', '*', "WHERE user_id = ? AND id = ?", [$userId, $sentence_id], "ii")[0];

$results = $query->select('words', '*', "WHERE user_id = ?", [$userId], "i");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $updatedSentence = $_POST['sentence'];
    $updatedTranslation = $_POST['translation'];
    $updatedWordId = $_POST['word_id'];

    $sql = "UPDATE sentences SET sentence = ?, translation = ?, word_id = ? WHERE user_id = ? AND id = ?";
    $params = [$updatedSentence, $updatedTranslation, $updatedWordId, $userId, $sentence_id];
    $types = "sssii";

    if ($query->executeQuery($sql, $params, $types)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Update failed']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
    <link rel="stylesheet" href="../src/css/add-sentences.css">
    <title>Edit Sentence</title>
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="justify-center">
        <div class="add-container">

            <h1>Edit Sentence</h1>

            <form id="sentenceForm" method="POST">

                <!-- <div class="form-group">
                    <label for="word">Select Word<span>*</span></label>
                    <select id="word" name="word_id" required>
                        <option value="">Select a Word</option>
                        <?php foreach ($results as $row): ?>
                            <option value="<?php echo htmlspecialchars($row['id']); ?>"
                                <?php echo $row['id'] == $sentence['word_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($row['word']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div> -->
                <!-- Select word -->
                <div class="form-group">
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-pen-ruler"></i>
                        </span>
                        <div class="custom-select-wrapper">
                            <select id="word" name="word_id" required>
                                <option value="">Select a Word</option>
                                <?php foreach ($results as $row): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>"
                                    <?php echo $row['id'] == $sentence['word_id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($row['word']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="custom-select-icon">
                                <i class="fa-solid fa-chevron-down"></i> <!-- Thêm icon cho select -->
                            </span>
                        </div>
                        <label for="word">Select Word<span>*</span></label>
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label for="sentence">Sentence<span>*</span></label>
                    <textarea id="sentence" name="sentence" class="form-control" required maxlength="200"><?php echo htmlspecialchars($sentence['sentence']); ?></textarea>
                </div> -->
                <!-- Sentence -->
                <div class="form-group">
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                        <textarea id="sentence" name="sentence" class="form-control" required
                            maxlength="200"><?php echo htmlspecialchars($sentence['sentence']); ?></textarea>
                        <label for="sentence">Sentence<span>*</span></label>
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label for="translation">Translation<span>*</span></label>
                    <textarea id="translation" name="translation" class="form-control" required maxlength="255"><?php echo htmlspecialchars($sentence['translation']); ?></textarea>
                </div> -->
                <!-- Translation -->
                <div class="form-group">
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </span>
                        <textarea id="translation" name="translation" class="form-control" required
                            maxlength="255"><?php echo htmlspecialchars($sentence['translation']); ?></textarea>
                        <label for="translation">Translation<span>*</span></label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script>
    $(document).ready(function() {
        $("#sentenceForm").submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: '',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    const res = JSON.parse(response);

                    if (res.status === 'success') {
                        Swal.fire('Success!', 'Changes saved successfully.', 'success');
                    } else {
                        Swal.fire('Error!', res.message ||
                            'There was an error saving your changes.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error!', 'There was an error saving your changes.', 'error');
                }
            });
        });
    });
    </script>
</body>

</html>