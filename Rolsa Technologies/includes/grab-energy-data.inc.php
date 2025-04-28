<?php
session_start();
require_once "dbh.inc.php";

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    try {
        $sql = "SELECT appliance, SUM(energy_consumption) AS total_energy 
                FROM energy_consumption 
                WHERE user_id = :user_id 
                GROUP BY appliance";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($data)) {
            echo json_encode([]); // Return an empty array if no data is found
        } else {
            echo json_encode($data);
        }
        exit();
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
        exit();
    }
} else {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}