<?php
session_start();
require_once "dbh.inc.php";

header('Content-Type: application/json');

try {
    $user_id = $_SESSION['user_id'];

    // Fetch calculation summary
    $calculationQuery = "SELECT total_carbon_footprint, created_at FROM carbon_footprint WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
    $calculationStmt = $pdo->prepare($calculationQuery);
    $calculationStmt->execute([$user_id]);
    $calculation = $calculationStmt->fetch(PDO::FETCH_ASSOC);

    // Fetch latest booking
    $bookingQuery = "SELECT service_name, booking_date FROM bookings WHERE user_id = ? ORDER BY booking_date DESC LIMIT 1";
    $bookingStmt = $pdo->prepare($bookingQuery);
    $bookingStmt->execute([$user_id]);
    $booking = $bookingStmt->fetch(PDO::FETCH_ASSOC);

    // Fetch latest installation
    $installationQuery = "SELECT preferred_date, preferred_time FROM installations WHERE user_id = ? ORDER BY preferred_date DESC LIMIT 1";
    $installationStmt = $pdo->prepare($installationQuery);
    $installationStmt->execute([$user_id]);
    $installation = $installationStmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'calculation' => $calculation,
        'booking' => $booking,
        'installation' => $installation,
    ]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Failed to fetch overview data.']);
}
?>