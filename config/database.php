<?php

function loadDotEnv(string $path): void
{
    if (!is_file($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        return;
    }

    foreach ($lines as $line) {
        if (preg_match('/^\s*[#;]/', $line)) {
            continue;
        }

        if (strpos($line, '=') === false) {
            continue;
        }

        [$key, $value] = array_map('trim', explode('=', $line, 2));
        $key = trim($key);
        $value = trim($value);

        if ($key === '') {
            continue;
        }

        if (!array_key_exists($key, $_ENV)) {
            $_ENV[$key] = $value;
        }

        if (!array_key_exists($key, $_SERVER)) {
            $_SERVER[$key] = $value;
        }

        putenv("{$key}={$value}");
    }
}

function env(string $key, $default = null)
{
    $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

    if ($value === false || $value === null || $value === '') {
        return $default;
    }

    return $value;
}

loadDotEnv(__DIR__ . '/../.env');

$databaseConfig = [
    'host' => env('DB_HOST', 'localhost'),
    'port' => env('DB_PORT', '3306'),
    'name' => env('DB_NAME', 'turnamen_sepakbola'),
    'user' => env('DB_USER', 'root'),
    'pass' => env('DB_PASS', ''),
];

function getDatabaseConfig(): array
{
    global $databaseConfig;
    return $databaseConfig;
}

function getPDOConnection(): PDO
{
    $config = getDatabaseConfig();
    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        $config['host'],
        $config['port'],
        $config['name']
    );

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    return new PDO($dsn, $config['user'], $config['pass'], $options);
}

function getMySQLiConnection(): mysqli
{
    $config = getDatabaseConfig();
    $connection = mysqli_connect(
        $config['host'],
        $config['user'],
        $config['pass'],
        $config['name'],
        (int) $config['port']
    );

    if ($connection === false) {
        throw new RuntimeException('Database connection failed: ' . mysqli_connect_error());
    }

    return $connection;
}

try {
    $conn = getPDOConnection();
    $koneksi = getMySQLiConnection();

    if ($koneksi !== null) {
        $tablesResult = mysqli_query($koneksi, "SHOW TABLES LIKE 'pendaptaran'");
        if ($tablesResult !== false && mysqli_num_rows($tablesResult) === 0) {
            mysqli_query($koneksi, "CREATE TABLE pendaptaran (
                id_pendaftaran INT AUTO_INCREMENT PRIMARY KEY,
                kampung VARCHAR(255) NOT NULL,
                nama_team VARCHAR(255) NOT NULL,
                status VARCHAR(30) NOT NULL DEFAULT 'pending',
                alasan_penolakan TEXT DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB");
        } else {
            $columnsResult = mysqli_query($koneksi, "SHOW COLUMNS FROM pendaptaran");
            $columns = [];
            while ($column = mysqli_fetch_assoc($columnsResult)) {
                $columns[] = $column['Field'];
            }

            $requiredColumns = [
                'status' => "ALTER TABLE pendaptaran ADD COLUMN status VARCHAR(30) NOT NULL DEFAULT 'pending'",
                'alasan_penolakan' => "ALTER TABLE pendaptaran ADD COLUMN alasan_penolakan TEXT DEFAULT NULL",
                'created_at' => "ALTER TABLE pendaptaran ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
                'updated_at' => "ALTER TABLE pendaptaran ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"
            ];

            foreach ($requiredColumns as $columnName => $alterSql) {
                if (!in_array($columnName, $columns, true)) {
                    mysqli_query($koneksi, $alterSql);
                }
            }
        }
    }
} catch (Throwable $exception) {
    $conn = null;
    $koneksi = null;
}
