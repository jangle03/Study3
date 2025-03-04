<?php include '../check.php' ?>
<?php include '../last_page.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Text</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
    <link rel="stylesheet" href="../src/css/add.css">
</head>

<body>

    <?php include '../includes/header.php'; ?>

    <div class="justify-center">
        <div class="add-container">

            <h1>Add New Text</h1>

            <form id="textForm" method="post">
                <!-- <div class="form-group">
                    <label for="text_title">Text Title<span>*</span></label>
                    <input type="text" id="text_title" name="text_title" required maxlength="150">
                </div> -->
                <!-- Text title -->
                <div class="form-group">
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-pen-ruler"></i>
                        </span>
                        <input type="text" id="text_title" name="text_title" required maxlength="150">
                        <label for="text_title">Text Title<span>*</span></label>
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label for="text_content">Text Content<span>*</span></label>
                    <textarea id="text_content" name="text_content" required maxlength="2000"></textarea>
                </div> -->
                <!-- Text Content -->
                <div class="form-group">
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                        <textarea id="text_content" name="text_content" required maxlength="2000"></textarea>
                        <label for="text_content">Text Content<span>*</span></label>
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label for="translation">Translation<span>*</span></label>
                    <textarea id="translation" name="translation" required maxlength="2000"></textarea>
                </div> -->
                <!-- Translation -->
                <div class="form-group">
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </span>
                        <textarea id="translation" name="translation" required maxlength="2000"></textarea>
                        <label for="translation">Translation<span>*</span></label>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit">Add Text</button>
                </div>
            </form>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script src="../src/js/texts-add.js"></script>

</body>

</html>