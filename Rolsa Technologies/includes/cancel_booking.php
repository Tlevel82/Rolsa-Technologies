<?php
session_start();
require_once "includes/dbh.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $booking_id = intval($_POST['booking_id']);
    $user_id = $_SESSION['user_id']; // Ensure the user is logged in

    // Delete the booking
    $sql = "DELETE FROM bookings WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $booking_id, $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Booking canceled successfully.";
    } else {
        $_SESSION['error'] = "Failed to cancel booking.";
    }

    header("Location: book.php");
    exit();
}
?>