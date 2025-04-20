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
    <link rel="stylesheet" href="../src/css/add-dictionary.css">
</head>

<body>

    <?php include '../includes/header.php'; ?>

    <div class="justify-center">
        <div class="add-container">

            <h1>Add New Text</h1>

            <form id="wordForm" method="post">
                <!-- Text title -->
                <div class="form-group">
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-pen-ruler"></i>
                        </span>
                        <input type="text" id="text_title" name="text_title" placeholder="Enter text title..." required maxlength="150">
                        <label for="text_title">Text Title<span>*</span></label>
                    </div>
                 </div>
                <!-- Text Content -->
                <div class="form-group">
                    <div class="input-wrapper">
                        <span class="icon">
                        <i class="fa-solid fa-circle-info"></i>
                        </span>
                        <input type="text_content" id="text_content" name="text_content" placeholder="Enter text content ..." required maxlength="150">
                        <label for="text_content">Text Content<span>*</span></label>
                    </div>
                 </div>
                <!-- Translation -->
                <div class="form-group">
                    <div class="input-wrapper">
                        <span class="icon">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </span>
                        <textarea id="translation" name="translation" placeholder="Enter translation..." required maxlength="150"></textarea>
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