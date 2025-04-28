<?php
session_start();
require_once "dbh.inc.php"; // Include database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in.");
}

$user_id = $_SESSION['user_id'];

// Retrieve form data
$electricity = $_POST['electricity'];
$gas = $_POST['gas'];
$oil = $_POST['oil'];
$vehicle_miles = $_POST['vehicle_miles'];
$short_rail = $_POST['short_rail'];
$long_rail = $_POST['long_rail'];
$short_flights = $_POST['short_flights'];
$long_flights = $_POST['long_flights'];

// Perform calculations
$power_heating_lighting = $electricity * 0.233 + $gas * 0.184 + $oil * 2.52;
$transport = $vehicle_miles * 0.271 + $short_rail * 0.041 + $long_rail * 0.029 + $short_flights * 0.15 + $long_flights * 0.25;
$total_carbon_footprint = $power_heating_lighting + $transport;

// Insert data into the database
$sql = "INSERT INTO carbon_footprint (user_id, electricity, gas, oil, vehicle_miles, short_rail, long_rail, short_flights, long_flights, power_heating_lighting, transport, total_carbon_footprint)
        VALUES (:user_id, :electricity, :gas, :oil, :vehicle_miles, :short_rail, :long_rail, :short_flights, :long_flights, :power_heating_lighting, :transport, :total_carbon_footprint)";
$stmt = $pdo->prepare($sql);
if (!$stmt) {
    die("Error: " . $pdo->errorInfo()[2]);
}

// Bind parameters using PDO syntax
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':electricity', $electricity, PDO::PARAM_STR);
$stmt->bindValue(':gas', $gas, PDO::PARAM_STR);
$stmt->bindValue(':oil', $oil, PDO::PARAM_STR);
$stmt->bindValue(':vehicle_miles', $vehicle_miles, PDO::PARAM_STR);
$stmt->bindValue(':short_rail', $short_rail, PDO::PARAM_STR);
$stmt->bindValue(':long_rail', $long_rail, PDO::PARAM_STR);
$stmt->bindValue(':short_flights', $short_flights, PDO::PARAM_STR);
$stmt->bindValue(':long_flights', $long_flights, PDO::PARAM_STR);
$stmt->bindValue(':power_heating_lighting', $power_heating_lighting, PDO::PARAM_STR);
$stmt->bindValue(':transport', $transport, PDO::PARAM_STR);
$stmt->bindValue(':total_carbon_footprint', $total_carbon_footprint, PDO::PARAM_STR);

if ($stmt->execute()) {
    // Store results in session for display
    $_SESSION['carbon_results'] = [
        'power_heating_lighting' => $power_heating_lighting,
        'transport' => $transport,
        'total_carbon_footprint' => $total_carbon_footprint,
    ];

    // Redirect back to the calculator page
    header("Location: ../calculate.php");
    exit();
} else {
    echo "Error: " . $stmt->errorInfo()[2];
}
