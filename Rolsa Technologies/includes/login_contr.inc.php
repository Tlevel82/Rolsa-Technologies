<?php

declare(strict_types=1);

function emptyInputLoginin(string $email, string $pwd)
{
    if (empty($email) || empty($pwd)) {
        return true;
    } else {
        return false;
    }
}

function wrong_email(bool|array $result) {
    if (!$result) {
        return true;
    } else {
        return false;
    }
}

function wrong_password(string $pwd, string $hashedPwd) {
    if (!password_verify($pwd, $hashedPwd)) {
        return true;
    } else {
        return false;
    }
}