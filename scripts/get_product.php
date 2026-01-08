<?php
// get_product.php
// Usage: php scripts/get_product.php 1
$argvCount = isset($argv) ? count($argv) : 0;
if ($argvCount < 2) {
    echo "Usage: php scripts/get_product.php <product_id>\n";
    exit(1);
}
$productId = (int)$argv[1];
$envPath = __DIR__ . '/../.env';
if (!file_exists($envPath)) { echo ".env not found\n"; exit(1); }
$env = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$config = [];
foreach ($env as $line) {
    if (strpos(trim($line), '#') === 0) continue;
    if (strpos($line, '=') === false) continue;
    [$key, $val] = explode('=', $line, 2);
    $config[trim($key)] = trim(trim($val), "\"'");
}
$dbHost = $config['DB_HOST'] ?? '127.0.0.1';
$dbPort = $config['DB_PORT'] ?? '3306';
$dbName = $config['DB_DATABASE'] ?? null;
$dbUser = $config['DB_USERNAME'] ?? null;
$dbPass = $config['DB_PASSWORD'] ?? null;
$dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $pdo->prepare('SELECT id,name,image FROM products WHERE id = :id');
    $stmt->execute([':id' => $productId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) { echo "Product not found\n"; exit(1); }
    echo "Product: \n";
    echo "id: " . $row['id'] . "\n";
    echo "name: " . $row['name'] . "\n";
    echo "image: " . ($row['image'] ?? 'NULL') . "\n";
} catch (PDOException $e) {
    echo "DB error: " . $e->getMessage() . "\n";
    exit(1);
}
