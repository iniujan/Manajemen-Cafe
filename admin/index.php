<?php
session_start();

// Periksa apakah pengguna sudah login dan apakah perannya adalah admin
if (!isset($_SESSION['log']) || $_SESSION['role'] != 'admin') {
    header('location:login.php');
    exit();
}
?>

<?php require_once "header.php" ?>
<!-- Content -->
 <div class="content">
        <h1>Welcome to Admin Dashboard</h1>
        <p>This is the main content area.</p>
        <!-- Additional content can go here -->
</div>
<?php require_once "footer.php" ?>
