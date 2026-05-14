<?php
// api/save_character.php

require_once 'config.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Você precisa estar logado para salvar um personagem!']);
    exit;
}

$user_id = $_SESSION['user_id'];
$name    = $_POST['name'] ?? '';
$species = $_POST['species'] ?? '';
$image   = $_POST['image'] ?? '';
$url     = $_POST['url'] ?? '';
$now     = date('Y-m-d H:i:s');

try {
    $check = $db->prepare("SELECT id FROM favorites WHERE url = ? AND user_id = ?");
    $check->execute([$url, $user_id]);
    if ($check->fetch()) {
        echo json_encode(['status' => 'error', 'message' => 'Você já salvou este personagem!']);
        exit;
    }
    $stmt = $db->prepare("INSERT INTO favorites (name, species, image, url, created_at, updated_at, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $species, $image, $url, $now, $now, $user_id]);
    echo json_encode(['status' => 'success', 'message' => 'Personagem salvo com sucesso no portal local!']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao salvar: ' . $e->getMessage()]);
}