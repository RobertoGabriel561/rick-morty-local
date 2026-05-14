<?php
// api/update_character.php
require_once 'config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) exit;

$id = $_POST['id'];
$name = $_POST['name'];
$species = $_POST['species'];
$updated_at = date('Y-m-d H:i:s');

$stmt = $db->prepare("UPDATE favorites SET name = ?, species = ?, updated_at = ? WHERE id = ? AND user_id = ?");
$success = $stmt->execute([$name, $species, $updated_at, $id, $_SESSION['user_id']]);

echo json_encode(['status' => $success ? 'success' : 'error']);
?>