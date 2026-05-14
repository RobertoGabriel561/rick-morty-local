<?php
// api/list_favorites.php

require_once 'config.php';
session_start();
header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? 0;

try {
    $stmt = $db->prepare("SELECT * FROM favorites WHERE user_id = ? ORDER BY id DESC");
    $stmt->execute([$user_id]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}