<?php
require_once "dbh.inc.php";

header('Content-Type: application/json');

try {
    // Fetch all booked installation slots
    $sql = "SELECT preferred_date, preferred_time FROM installations WHERE status = 'booked'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $bookedSlots = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($bookedSlots);
} catch (Exception $e) {
    echo json_encode(['error' => 'Failed to fetch unavailable slots.']);
}
?>