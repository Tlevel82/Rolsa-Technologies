<?php

declare(strict_types=1);

function check_login_errors() {
    if (isset($_SESSION['login_errors'])) {
        foreach ($_SESSION['login_errors'] as $error) {
            echo '<div class="error-message">' . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '</div>';
        }
        unset($_SESSION['login_errors']); // Clear errors after displaying
    }
}