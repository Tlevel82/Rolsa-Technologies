<?php
session_start();
require_once "dbh.inc.php"; // Include database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in.");
}

$user_id = $_SESSION['user_id'];

// Retrieve form data
$appliance = $_POST['appliance'];
$power_consumption = $_POST['power_consumption']; // in watts
$hours_per_day = $_POST['hours_per_day'];

// Calculate energy consumption in kWh
$energy_consumption = ($power_consumption * $hours_per_day) / 1000; // Convert watts to kWh

// Insert data into the database
$sql = "INSERT INTO energy_consumption (user_id, appliance, power_consumption, hours_per_day, energy_consumption)
        VALUES (:user_id, :appliance, :power_consumption, :hours_per_day, :energy_consumption)";
$stmt = $pdo->prepare($sql);
if (!$stmt) {
    die("Error: " . $pdo->errorInfo()[2]);
}

// Bind parameters using PDO syntax
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':appliance', $appliance, PDO::PARAM_STR);
$stmt->bindValue(':power_consumption', $power_consumption, PDO::PARAM_INT);
$stmt->bindValue(':hours_per_day', $hours_per_day, PDO::PARAM_INT);
$stmt->bindValue(':energy_consumption', $energy_consumption, PDO::PARAM_STR);

if ($stmt->execute()) {
    // Store results in session for display
    $_SESSION['energy_results'] = [
        'appliance' => $appliance,
        'power_consumption' => $power_consumption,
        'hours_per_day' => $hours_per_day,
        'energy_consumption' => $energy_consumption,
    ];

    // Redirect back to the calculator page
    header("Location: ../calculate.php");
    exit();
} else {
    echo "Error: " . $stmt->errorInfo()[2];
}
?>