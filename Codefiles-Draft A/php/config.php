<?php
// Configuration for session management
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

// Setting session cookie parameters
session_set_cookie_params(1800, '/', 'localhost', true, true);

// Starting the session
session_start();

// Including the database connection file
require_once 'dbcon.php';

// Function to regenerate session ID for logged-in users with their user ID
function regenerate_session_id_loggedIn($userId) {
    session_regenerate_id(true);
    $newSessionId = session_create_id();
    $sessionId = $newSessionId . "_" . $userId;
    session_id($sessionId);
    $_SESSION["last_regeneration"] = time();
}

// Function to regenerate session ID for non-logged-in users
function regenerate_session_id() {
    session_regenerate_id(true);
    $_SESSION["last_regeneration"] = time();
}

// Check if a user is logged in and handle session regeneration
if (isset($_SESSION['userID'])) {
    $userId = $_SESSION['userID'];
    $stmt = $pdo->prepare("SELECT userID, username, email, roles FROM users WHERE userID = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_data'] = $user;
    } else {
        echo "User not found!";
        exit;
    }

    if (!isset($_SESSION["last_regeneration"])) {
        regenerate_session_id_loggedIn($_SESSION['userID']);
    } else {
        $interval = 60 * 30; // 30 minutes
        if (time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_session_id_loggedIn($_SESSION['userID']);
        }
    }
} else {
    if (!isset($_SESSION["last_regeneration"])) {
        regenerate_session_id();
    } else {
        $interval = 60 * 30; // 30 minutes
        if (time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_session_id();
        }
    }
}
?>
