<?php
// api/delete_character.php

require_once 'config.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Não autorizado']);
    exit;
}

$id      = $_GET['id'] ?? 0;
$user_id = $_SESSION['user_id'];

try {
    $stmt = $db->prepare("DELETE FROM favorites WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
    echo json_encode(['status' => 'success', 'message' => 'Personagem removido com sucesso!']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}