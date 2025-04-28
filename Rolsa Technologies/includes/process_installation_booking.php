<?php
session_start();
require_once "dbh.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    $encryption_key = 'your_secret_key';
    $encrypted_card_number = openssl_encrypt($card_number, 'AES-128-CTR', $encryption_key, 0, '1234567891011121');
    $encrypted_expiry_date = openssl_encrypt($expiry_date, 'AES-128-CTR', $encryption_key, 0, '1234567891011121');
    $encrypted_cvv = openssl_encrypt($cvv, 'AES-128-CTR', $encryption_key, 0, '1234567891011121');

    // Insert booking into the database
    $sql = "INSERT INTO installations (user_id, name, email, phone, preferred_date, preferred_time, card_number, expiry_date, cvv)
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

    $_SESSION['message'] = "Installation booking successful!";
    header("Location: ../install-book.php");
    exit();
}
?>