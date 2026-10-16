<?php

declare(strict_types=1);

// Starter page: confirms PHP-FPM and MySQL are wired up.
// Replace the contents of app/ with your project, or point APP_DIR at it.

$db = 'not connected';
try {
    $pdo = new PDO(
        sprintf('mysql:host=%s;port=%s;dbname=%s', getenv('DB_HOST'), getenv('DB_PORT'), getenv('DB_DATABASE')),
        (string) getenv('DB_USERNAME'),
        (string) getenv('DB_PASSWORD'),
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    $db = 'MySQL ' . $pdo->query('SELECT VERSION()')->fetchColumn();
} catch (PDOException $e) {
    http_response_code(503);
    $db = 'MySQL error: ' . $e->getMessage();
}

$extensions = get_loaded_extensions();
sort($extensions, SORT_FLAG_CASE | SORT_STRING);

header('Content-Type: text/html; charset=utf-8');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>php-docker-stack</title>
    <style>
        body { font: 16px/1.5 system-ui, sans-serif; max-width: 48rem; margin: 3rem auto; padding: 0 1rem; }
        code { background: #f2f2f2; padding: .1rem .3rem; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>php-docker-stack is running</h1>
    <ul>
        <li id="php">PHP <?= htmlspecialchars(PHP_VERSION) ?></li>
        <li id="db"><?= htmlspecialchars($db) ?></li>
        <li>Timezone: <?= htmlspecialchars(date_default_timezone_get()) ?></li>
    </ul>
    <p>Extensions: <?= htmlspecialchars(implode(', ', $extensions)) ?></p>
    <p>Edit <code>app/public/index.php</code>, or set <code>APP_DIR</code> in <code>.env</code> to your project.</p>
</body>
</html>
