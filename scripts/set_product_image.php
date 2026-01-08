<?php
// set_product_image.php
// Usage: php scripts/set_product_image.php 7 product4.png
// Reads .env for DB credentials and updates products table

$argvCount = isset($argv) ? count($argv) : 0;
if ($argvCount < 3) {
    echo "Usage: php scripts/set_product_image.php <product_id> <image_filename>\n";
    exit(1);
}
$productId = (int)$argv[1];
$image = $argv[2];

$envPath = __DIR__ . '/../.env';
if (!file_exists($envPath)) {
    echo ".env not found at $envPath\n";
    exit(1);
}
$env = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$config = [];
foreach ($env as $line) {
    if (strpos(trim($line), '#') === 0) continue;
    if (strpos($line, '=') === false) continue;
    [$key, $val] = explode('=', $line, 2);
    $key = trim($key);
    $val = trim($val);
    $val = trim($val, "\"'");
    $config[$key] = $val;
}

$dbHost = $config['DB_HOST'] ?? '127.0.0.1';
$dbPort = $config['DB_PORT'] ?? '3306';
$dbName = $config['DB_DATABASE'] ?? null;
$dbUser = $config['DB_USERNAME'] ?? null;
$dbPass = $config['DB_PASSWORD'] ?? null;
if (!$dbName || !$dbUser) {
    echo "DB configuration missing in .env\n";
    exit(1);
}

dsn:
$dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $sql = "UPDATE products SET image = :image WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':image' => $image, ':id' => $productId]);
    $count = $stmt->rowCount();
    echo "Updated product $productId image to $image (rows affected: $count)\n";
} catch (PDOException $e) {
    echo "DB error: " . $e->getMessage() . "\n";
    exit(1);
}
