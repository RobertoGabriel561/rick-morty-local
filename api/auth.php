<?php
// api/auth.php
require_once 'config.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

if ($action === 'register') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);

    try {
        $stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $password]);
        echo json_encode(['status' => 'success', 'message' => 'Cadastro realizado!']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Email já cadastrado.']);
    }
} 

elseif ($action === 'login') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        echo json_encode(['status' => 'success', 'userName' => $user['name']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Dados inválidos.']);
    }
}

elseif ($action === 'logout') {
    session_destroy();
    echo json_encode(['status' => 'success']);
}
?>