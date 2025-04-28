<?php

declare(strict_types=1);

function emptyInputSignup(string $first_name, string $last_name, string $email, string $pwd)
{
    if (empty($first_name) || empty($last_name) || empty($email) || empty($pwd)) {
        return true;
    } else {
        return false;
    }
}

function invalidEmail(string $email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function emailExists(object $pdo, string $email)
{
    if (get_email($pdo, $email)) {
        return true;
    } else {
        return false;
    }
}

function create_user(object $pdo, string $pwd, string $first_name, string $last_name, string $email) 
{
    set_user($pdo, $pwd, $first_name, $last_name, $email);
}