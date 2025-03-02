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
    <style>
        .table {
            background-color: #fff;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background-color: #2f4f4f;
            color: white;
        }

        .table td {
            vertical-align: middle;
        }

        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid #2f4f4f;
        }

        .header-title {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .container {
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <?php include '../includes/header.php'; ?>

    <div class="container">
        <h2 class="header-title">User List</h2>
        <?php if ($_SESSION['username'] === 'admin'): ?>
            <a href="them_tai_khoan.php" class="btn btn-primary mb-3">Add User</a>
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
                                <img src="../src/images/profile-image/<?php echo htmlspecialchars($u['profile_picture']); ?>" alt="Profile Image" class="profile-img">
                            </td>
                            <td><?php echo htmlspecialchars($u['created_at']); ?></td>
                            <td>
                                <a href="sua_tai_khoan.php?id=<?= $u['id'] ?>" class="btn btn-success">Sửa</a>
                                <?php if ($u['username'] !== 'admin'): ?>
                                    <a href="xoa_tai_khoan.php?id=<?= $u['id'] ?>" class="btn btn-danger">Xóa</a>
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