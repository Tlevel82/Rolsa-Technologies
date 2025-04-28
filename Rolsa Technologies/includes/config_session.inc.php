<?php 

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 1800,
    'path' => '/',
    'domain' => 'localhost',
    'secure' => true,
    'httponly' => true,
]);

session_start();

if (isset($_SESSION["user_id"])) {
    // Regenerate session ID to prevent session fixation attacks
    if (!isset($_SESSION['last_regeneration'])) {
        regenerate_session_id_loggedin(); // deletes the old session
    } else {
        $interval = 60 * 30; // 30 minutes
        if (time() - $_SESSION['last_regeneration'] >= $interval) {
            regenerate_session_id_loggedin(); // deletes the old session
            $_SESSION['last_regeneration'] = time();
        }
    }
} else {
    // Regenerate session ID to prevent session fixation attacks
    if (!isset($_SESSION['last_regeneration'])) {
        session_regenerate_id(); // deletes the old session
    } else {
        $interval = 60 * 30; // 30 minutes
        if (time() - $_SESSION['last_regeneration'] >= $interval) {
            session_regenerate_id(); // deletes the old session
            $_SESSION['last_regeneration'] = time();
        }
    }
}


function regenerate_session_id() {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

function regenerate_session_id_loggedin() {
    session_regenerate_id(true);

    $userId = $_SESSION["user_id"];
    $newSessionId = session_create_id();
    $sessionId = $newSessionId . "_" . $userId; 
    session_id($sessionId);

    $_SESSION['last_regeneration'] = time();
}