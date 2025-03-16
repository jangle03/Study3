<?php
include '../check.php';

$userId = $_SESSION['user_id'];
$word_id = $_GET['word_id'] ? (int) $_GET['word_id'] : 0;

$word = $query->select('words', '*', "WHERE user_id = ? AND id = ?", [$userId, $word_id], "ii")[0];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedWord = $_POST['word'];
    $updatedTranslation = $_POST['translation'];
    $updatedDefinition = $_POST['definition'];

    $sql = "UPDATE words SET word = ?, translation = ?, definition = ? WHERE user_id = ? AND id = ?";
    $params = [$updatedWord, $updatedTranslation, $updatedDefinition, $userId, $word_id];
    $types = "sssii";

    $query->executeQuery($sql, $params, $types);

    header("Location: edit.php");
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
    <link rel="stylesheet" href="../src/css/add.css">
    <title>Edit Word</title>
</head>

<body>

    <?php include '../includes/header.php'; ?>

    <div class="justify-center">
        <div class="add-container">
            <h1>Edit Word</h1>

            <form id="profile-form" method="POST">
                <!-- Word -->
                <div class="form-group">
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-pen-ruler"></i>
                        </span>
                        <input type="text" id="word" name="word" class="form-control"
                        value="<?php echo htmlspecialchars($word['word']); ?>" required maxlength="150">
                        <label for="word">Word<span>*</span></label>
                    </div>
                </div>
                <!-- Translation -->
                <div class="form-group">
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                        <input type="text" id="translation" name="translation" class="form-control"
                        value="<?php echo htmlspecialchars($word['translation']); ?>" required maxlength="150">
                        <label for="translation">Translation<span>*</span></label>
                    </div>
                </div>
                <!-- Definition -->
                <div class="form-group">
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </span>
                        <textarea id="definition" name="definition" class="form-control"
                        rows="3" maxlength="255"><?php echo htmlspecialchars($word['definition']); ?></textarea>
                        <label for="definition">Definition</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>

        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

</body>

</html>
<script>
    $(document).ready(function() {
        $("#profile-form").submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: '',
                type: 'POST',
                data: $(this).serialize(),
                success: function() {
                    Swal.fire('Success!', 'Changes saved successfully.', 'success');
                },
                error: function() {
                    Swal.fire('Error!', 'There was an error saving your changes.', 'error');
                }
            });
        });
    });
</script>