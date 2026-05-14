<?php
// api/config.php

$sessionPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'sessions';
if (!file_exists($sessionPath)) {
    mkdir($sessionPath, 0777, true);
}
ini_set('session.save_path', $sessionPath);

require_once __DIR__ . '/db.php';