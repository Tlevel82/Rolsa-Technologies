<?php
session_start();
require_once "dbh.inc.php";

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $timeframe = $_GET['timeframe']; // 'monthly' or 'yearly'

    if ($timeframe === 'monthly') {
        $sql = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS period, SUM(total_carbon_footprint) AS total_carbon 
                FROM carbon_footprint 
                WHERE user_id = :user_id 
                GROUP BY DATE_FORMAT(created_at, '%Y-%m')";
    } else {
        $sql = "SELECT YEAR(created_at) AS period, SUM(total_carbon_footprint) AS total_carbon 
                FROM carbon_footprint 
                WHERE user_id = :user_id 
                GROUP BY YEAR(created_at)";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);
    exit();
}