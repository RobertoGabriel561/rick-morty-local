<?php
// api/config.php

ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_samesite', 'None');
ini_set('session.cookie_secure', 1);

require_once __DIR__ . '/db.php';

$handler = new class($db) implements SessionHandlerInterface {
    private $db;
    public function __construct($db) { $this->db = $db; }
    public function open($path, $name): bool { return true; }
    public function close(): bool { return true; }
    public function read($id): string {
        $stmt = $this->db->prepare("SELECT data FROM sessions WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? $row['data'] : '';
    }
    public function write($id, $data): bool {
        $stmt = $this->db->prepare("REPLACE INTO sessions (id, data, updated_at) VALUES (?, ?, ?)");
        return $stmt->execute([$id, $data, time()]);
    }
    public function destroy($id): bool {
        $stmt = $this->db->prepare("DELETE FROM sessions WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public function gc($max_lifetime): int|false {
        $stmt = $this->db->prepare("DELETE FROM sessions WHERE updated_at < ?");
        $stmt->execute([time() - $max_lifetime]);
        return $stmt->rowCount();
    }
};

session_set_save_handler($handler, true);