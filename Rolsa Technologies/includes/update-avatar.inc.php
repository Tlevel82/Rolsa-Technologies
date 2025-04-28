<?php
session_start();
require_once "dbh.inc.php";

if (isset($_FILES['avatar']) && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $avatar = $_FILES['avatar'];
    $uploadDir = 'uploads/avatars/';
    $uploadFile = $uploadDir . basename($avatar['name']);

    // Move the uploaded file to the server
    if (move_uploaded_file($avatar['tmp_name'], $uploadFile)) {
        // Update the avatar path in the database
        $sql = "UPDATE users SET avatar = :avatar WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':avatar', $uploadFile, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        // Update the session variable
        $_SESSION['user_avatar'] = $uploadFile;

        header("Location: ../dash-setting-access.php?upload=success");
        exit();
    } else {
        header("Location: ../dash-setting-access.php?upload=error");
        exit();
    }
}