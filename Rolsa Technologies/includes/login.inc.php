<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    try {
        require_once 'dbh.inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';

        // Error handling
        $errors = [];

        if (emptyInputLoginin($email, $pwd)) { 
            $errors["empty_input"] = "Please fill in all fields!";   
        }

        $result = get_user($pdo ,$email);

        if (wrong_email($result)) { 
            $errors["login_incorrect"] = "Incorrect login info!";   
        }

        if (!wrong_email($result) && wrong_password($pwd, $result["pwd"])) { 
            $errors["login_incorrect"] = "Incorrect login info!";   
        }

        

        require_once "config_session.inc.php";

        if ($errors) {
            $_SESSION["errors_login"] = $errors;
            $_SESSION["active_form"] = "login"; // Set the active form to login


            header("Location: ../account.php");
            exit();
        }

        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result["id"]; 
        session_id($sessionId);

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_email"] = htmlspecialchars($result["email"]);
        $_SESSION["user_avatar"] = htmlspecialchars($result["avatar"]); // Store avatar path in session

        $_SESSION['last_regeneration'] = time();

        header("Location: ../dashboard.php?login=success");
        $pdo = null;
        $stmt = null;

        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

} else {
    header("location: ../account.php");
    die();
}