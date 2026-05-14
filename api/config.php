<?php
// api/config.php
session_start();
try {
    $db = new PDO('sqlite:' . __DIR__ . '/../db/database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Criar tabela de usuários
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT, 
        name TEXT, 
        email TEXT UNIQUE, 
        password TEXT
    )");

    // Criar tabela de favoritos
    $db->exec("CREATE TABLE IF NOT EXISTS favorites (
        id INTEGER PRIMARY KEY AUTOINCREMENT, 
        name TEXT, 
        species TEXT, 
        image TEXT, 
        url TEXT, 
        created_at DATETIME, 
        updated_at DATETIME, 
        user_id INTEGER
    )");
} catch (PDOException $e) {
    die("Erro ao conectar ao banco: " . $e->getMessage());
}
?>