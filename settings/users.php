
<?php include '../check.php'; ?>
<?php include '../last_page.php';

if ($_SESSION['username'] !== 'admin') {
    header("Location: ../");
    exit;
}

$user = $query->select('users');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/setting-users.css">

    
</head>

<body>

    <?php include '../includes/header.php'; ?>

    <div class="container2">
        <h2 class="header-title">User List</h2>
        <?php if ($_SESSION['username'] === 'admin'): ?>
            <a href="create-account.php" class="btn btn-primary mb-3">Add User</a>
        <?php endif; ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Profile Image</th>
                        <th>Created At</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $stt = 1; ?>
                    <?php foreach ($user as $u): ?>
                        <tr>
                            <td><?php echo $stt++; ?></td>
                            <td><?php echo htmlspecialchars($u['last_name'] . " " . $u['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($u['email']); ?></td>
                            <td><?php echo htmlspecialchars($u['username']); ?></td>
                            <td class="text-center">
                            <img src="../src/images/profile-image/<?php echo htmlspecialchars($u['profile_picture']); ?>" 
                                alt="Profile Image" class="profile-img"
                                onerror="this.onerror=null;this.src='../src/images/profile-image/default.png';">
                            </td>

                            <td><?php echo htmlspecialchars($u['created_at']); ?></td>
                            <td>
                                <a href="edit-account.php?id=<?= $u['id'] ?>" class="btn btn-success">Sửa</a>
                                <?php if ($u['username'] !== 'admin'): ?>
                                    <a href="delete-account.php?id=<?= $u['id'] ?>" class="btn btn-danger">Xóa</a>
                                <?php endif; ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>



