<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    try {
        //code...
        require_once 'dbh.inc.php';
        require_once 'signup_model.inc.php';
        require_once 'signup_contr.inc.php';


        // Error handling
        $errors = [];

        if (emptyInputSignup($first_name, $last_name, $email, $pwd)) { 
            $errors["empty_input"] = "Please fill in all fields!";
            
        }

        if (invalidEmail($email)) {   
            $errors["invalid_email"] = "Invalid email used!";
        }

        if (emailExists($pdo, $email)) { 
            $errors["email_used"] = "Email is already registered!";
        }

        require_once "config_session.inc.php";

        if ($errors) {
            $_SESSION["errors_signup"] = $errors;
            $_SESSION["active_form"] = "signup"; // Set the active form to sign-up
            header("Location: ../account.php#sign-up-form");
            exit();
        }

        // Inserting user data to the users table when user registers
        create_user($pdo, $pwd, $first_name, $last_name, $email);

        header("Location: ../dashboard.php?signup=success"); 
        
        $pdo = null;
        $stmt = null;

        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../account.php#sign-up-btn");
    die();
}