<?php
// api/db.php
header('Content-Type: application/json');

// Ativa a exibição de erros brutos no PHP para diagnóstico de problemas
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Caminho absoluto dinâmico baseado na pasta atual do script para total portabilidade
    $dbPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'database.sqlite';
    
    // Conecta ao banco de dados SQLite
    $db = new PDO('sqlite:' . $dbPath);
    
    // Configurações de segurança e tratamento de dados
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // [Função Nuvem] Garante que a tabela de usuários exista no ambiente de produção
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL
    )");

    // [Função Nuvem] Garante que a tabela de favoritos exista e tenha o relacionamento correto
    $db->exec("CREATE TABLE IF NOT EXISTS favorites (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        name TEXT NOT NULL,
        species TEXT,
        image TEXT,
        url TEXT,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");

} catch (PDOException $e) {
    // Se houver falha de conexão ou tabelas na nuvem, retorna o erro estruturado
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Erro interno na conexão com o banco de dados: ' . $e->getMessage()
    ]);
    exit;
}