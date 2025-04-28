<?php
session_start();
require_once "dbh.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate user input
    $errors = [];

    if (empty($_POST['name'])) {
        $errors[] = "Name is required.";
    }
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    }
    if (empty($_POST['phone']) || !preg_match('/^\d{10,15}$/', $_POST['phone'])) {
        $errors[] = "A valid phone number is required.";
    }
    if (empty($_POST['date'])) {
        $errors[] = "Preferred date is required.";
    }
    if (empty($_POST['time'])) {
        $errors[] = "Preferred time is required.";
    }
    if (empty($_POST['card_number']) || !preg_match('/^\d{16}$/', $_POST['card_number'])) {
        $errors[] = "A valid 16-digit card number is required.";
    }
    if (empty($_POST['expiry_date']) || !preg_match('/^\d{2}\/\d{2}$/', $_POST['expiry_date'])) {
        $errors[] = "A valid expiry date (MM/YY) is required.";
    }
    if (empty($_POST['cvv']) || !preg_match('/^\d{3}$/', $_POST['cvv'])) {
        $errors[] = "A valid 3-digit CVV is required.";
    }

    // If there are errors, redirect back with error messages
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../book.php");
        exit();
    }

    // Sanitize user input
    $user_id = $_SESSION['user_id'];
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $phone = htmlspecialchars($_POST['phone'], ENT_QUOTES, 'UTF-8');
    $preferred_date = $_POST['date'];
    $preferred_time = $_POST['time'];
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];

    // Encrypt sensitive data
    $encryption_key = 'your_secret_key'; // Replace with a secure key
    $encrypted_card_number = openssl_encrypt($card_number, 'AES-128-CTR', $encryption_key, 0, '1234567891011121');
    $encrypted_expiry_date = openssl_encrypt($expiry_date, 'AES-128-CTR', $encryption_key, 0, '1234567891011121');
    $encrypted_cvv = openssl_encrypt($cvv, 'AES-128-CTR', $encryption_key, 0, '1234567891011121');

    // Insert booking into the database
    $sql = "INSERT INTO consultations (user_id, name, email, phone, preferred_date, preferred_time, card_number, expiry_date, cvv)
            VALUES (:user_id, :name, :email, :phone, :preferred_date, :preferred_time, :card_number, :expiry_date, :cvv)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':user_id' => $user_id,
        ':name' => $name,
        ':email' => $email,
        ':phone' => $phone,
        ':preferred_date' => $preferred_date,
        ':preferred_time' => $preferred_time,
        ':card_number' => $encrypted_card_number,
        ':expiry_date' => $encrypted_expiry_date,
        ':cvv' => $encrypted_cvv,
    ]);

    $_SESSION['message'] = "Booking successful!";
    header("Location: ../book.php");
    exit();
}
?>