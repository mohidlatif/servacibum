<?php
// Only allow browser cross-origin access from approved ServaCibum domains.
// This is not authentication; protected endpoints must enforce authorization.
$allowedOrigins = [
    'https://servacibum.org',
    'https://www.servacibum.org',
];
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if (in_array($origin, $allowedOrigins, true)) {
    header('Access-Control-Allow-Origin: ' . $origin);
    header('Vary: Origin');
    header('Access-Control-Allow-Headers: Content-Type');
    header('Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS');
}
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    if ($origin !== '' && !in_array($origin, $allowedOrigins, true)) {
        http_response_code(403);
        exit;
    }
    http_response_code(204);
    exit;
}
$cfg = require __DIR__ . '/../config/database.php';
try {
    $dsn = "mysql:host={$cfg['host']};dbname={$cfg['database']};charset={$cfg['charset']}";
    $pdo = new PDO($dsn, $cfg['username'], $cfg['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed. Check config/database.php and the MySQL user privileges."]);
    exit;
}
function body(){ return json_decode(file_get_contents("php://input"), true) ?? []; }
function out($x,$code=200){ http_response_code($code); echo json_encode($x); exit; }
?>
