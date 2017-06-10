<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/box.css">
</head>
<body style="background-color : #BDBDBD">
<?php
$url = parse_url(getenv('DATABASE_URL'));
$dsn = sprintf('pgsql:host=%s;dbname=%s', $url['host'], substr($url['path'], 1));
$pdo = new PDO($dsn, $url['user'], $url['pass']);
ehco $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
//var_dump($pdo->getAttribute(PDO::ATTR_SERVER_VERSION));
?>
</body>
</html>