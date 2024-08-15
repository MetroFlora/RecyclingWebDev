<?php
require_once 'dbcon.php';
require_once 'config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and trim form inputs
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $pwd = trim($_POST['pwd']);
    $roles = trim($_POST['roles']);

    // Check for empty fields
    if (empty($username) || empty($email) || empty($pwd) || empty($roles)) {
        $_SESSION['error'] = 'All fields are required!';
        header('Location: ../html/register.html');
        exit();
    }

    

    try {
        // Prepare SQL based on role
        if ($roles === 'admins') {
            $stmt = $pdo->prepare("INSERT INTO admins (username, email, pwd) VALUES (?, ?, ?)");
        } else {
            $stmt = $pdo->prepare("INSERT INTO recyclers (username, email, pwd) VALUES (?, ?, ?)");
        }

        // Execute statement
        $stmt->execute([$username, $email, $pwd]);

        // Success message and redirection
        $_SESSION['success'] = 'Registration successful!';
        header('Location: ../html/login.html');
        exit();

    } catch (PDOException $e) {
        $_SESSION['error'] = 'Database error: ' . $e->getMessage();
        header('Location: ../html/register.html');
        exit();
    }
} else {
    header('Location: ../html/register.html');
    exit();
}
?>
