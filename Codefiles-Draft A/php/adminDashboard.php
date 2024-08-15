<?php
session_start();
require_once 'dbcon.php';
require_once 'config.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'admins') {
    header('Location: ../html/login.html');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - WasteWise</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header class="bg-dark text-white p-3 mb-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">WasteWise</div>
                <nav>
                    <ul class="nav">
                        <li class="nav-item"><a class="nav-link text-white" href="adminDashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="../html/services.html">Services</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="../html/logout.php">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <section class="container">
        <div class="row">
            <div class="col-12">
                <h1>Welcome to the Admin Dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
                <p>Here you can manage the system.</p>
                <!-- Add your admin dashboard content here -->
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
