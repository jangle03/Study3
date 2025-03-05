<div class="sidebar">
    <h2>Menu</h2>
    <ul>
        <?php if ($_SESSION['username'] === 'admin'): ?>
            <li><a href="post_management.php">Post Management</a></li>
        <?php endif; ?>
        <li><a href="add.php">Add Blog</a></li>
        <li><a href="list.php">List my Blog</a></li>
    </ul>
</div>
