<?php
require_once 'config.php';
require_once 'dbcon.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = trim($_POST['username']);
    $password = trim($_POST['pwd']);
    $role = trim($_POST['roles']); // 'admins' or 'recycler'

    // Sanitize input to prevent SQL Injection
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    // SQL query variables
    $sql = '';
    $stmt = '';

    switch ($role) {
        case 'admins':
            $sql = "SELECT adminID, username, pwd FROM admins WHERE username = ?";
            break;

        case 'recycler':
            $sql = "SELECT recyclerID, username, pwd FROM recyclers WHERE username = ?";
            break;

        default:
            echo "Invalid role selected.";
            exit();
    }

    if ($sql) {
        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Execute the statement
        $stmt->execute([$username]);

        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify user credentials
        if ($user && password_verify($password, $user['pwd'])) {
            // Start a session and set session variables
            session_start();
            $_SESSION['userID'] = $user['adminID'] ?? $user['recyclerID'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $role;

            // Redirect based on the role
            if ($role === 'admins') {
                header('Location: adminDashboard.php');
            } else if ($role === 'recycler') {
                header('Location: recyclerDashboard.php'); // You'll need to create this page
            }
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Error preparing SQL statement.";
    }
} else {
    echo "Invalid request method.";
}
?>
