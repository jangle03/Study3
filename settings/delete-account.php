<?php
include '../check.php';
include '../last_page.php';

if ($_SESSION['username'] !== 'admin') {
    header("Location: ../");
    exit;
}

$id = $_GET['id'];
$query->delete('users', 'id = ?', [$id], 'i');

header("Location: users.php");
exit;
?>