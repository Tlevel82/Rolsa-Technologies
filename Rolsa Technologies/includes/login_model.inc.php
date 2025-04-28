<?php

declare(strict_types=1);

function get_user($pdo, $email) {
    $sql = "SELECT id, email, pwd, avatar FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}