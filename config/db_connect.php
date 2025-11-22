<?php
$host = "localhost";
$dbname = "portfolio_db";
$username = "root";
$password = "";

try {
    $dotenvPath = __DIR__ . '/../.env';
    $env = [];

    if (file_exists($dotenvPath)) {
        $lines = file($dotenvPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#') {
                continue;
            }
            $parts = explode('=', $line, 2);
            if (count($parts) === 2) {
                $key = trim($parts[0]);
                $val = trim($parts[1]);
                $val = trim($val, " \t\n\r\0\x0B\"'");
                $env[$key] = $val;
            }
        }
    }


    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $stmt = $pdo->query("SELECT * FROM personal_info LIMIT 1");
    $personalInfo = $stmt->fetch(PDO::FETCH_ASSOC);


    $stmt = $pdo->query("SELECT * FROM skills ORDER BY category, proficiency DESC");
    $skills = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $stmt = $pdo->query("SELECT * FROM categories");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $stmt = $pdo->query("SELECT * FROM projects");
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

  
    $projectIds = array_column($projects, 'id');
    
    if (!empty($projectIds)) {

        $in = str_repeat('?,', count($projectIds) - 1) . '?';

        
        $stmt = $pdo->prepare("SELECT project_id, tag FROM project_tags WHERE project_id IN ($in)");
        $stmt->execute($projectIds);

        
        $tagsMap = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tagsMap[$row['project_id']][] = $row['tag'];
        }

       
        foreach ($projects as &$project) {
            $project['tags'] = $tagsMap[$project['id']] ?? [];
        }
        unset($project);
    } else {

        foreach ($projects as &$project) {
            $project['tags'] = [];
        }
        unset($project);
    }


    $stmt = $pdo->query("SELECT * FROM certificates");
    $certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->query("SELECT * FROM experience ORDER BY start_date DESC");
    $experience = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $defaultEmail = $env['DEFAULT_USER_EMAIL'];
    $defaultPassword = password_hash($env['DEFAULT_USER_PASSWORD'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$defaultEmail]);
    $exists = $stmt->fetch();

    if (!$exists) {
        $insert = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $insert->execute([$defaultEmail, $defaultPassword]);
    }


} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
