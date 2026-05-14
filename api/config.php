<?php
// api/config.php

// Define a pasta 'sessions' do projeto para guardar os logins na nuvem
$sessionPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'sessions';
if (!file_exists($sessionPath)) {
    mkdir($sessionPath, 0777, true);
}
ini_set('session.save_path', $sessionPath);

// Importa a conexão com o banco de dados
require_once __DIR__ . '/db.php';
