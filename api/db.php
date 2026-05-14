
<?php
// api/db.php
 
ini_set('display_errors', 1);
error_reporting(E_ALL);
 
try {
    $dbPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'database.sqlite';
    $db = new PDO('sqlite:' . $dbPath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
 
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL
    )");
 
    $db->exec("CREATE TABLE IF NOT EXISTS favorites (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        name TEXT NOT NULL,
        species TEXT,
        image TEXT,
        url TEXT,
        created_at TEXT,
        updated_at TEXT,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");
 
    $db->exec("CREATE TABLE IF NOT EXISTS sessions (
        id TEXT PRIMARY KEY,
        data TEXT,
        updated_at INTEGER
    )");
 
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
 
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Erro de conexão: ' . $e->getMessage()]);
    exit;
}