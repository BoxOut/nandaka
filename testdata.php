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
echo "<p>".$pdo->getAttribute(PDO::ATTR_SERVER_VERSION)."</p>";
//var_dump($pdo->getAttribute(PDO::ATTR_SERVER_VERSION));
$sql = "CREATE TABLE IF NOT EXISTS `FIRST_TABLE`"
."("
. "`color` text,"
. "`playlists` text,"
.");";
$stmt = $pdo -> prepare($sql);
$stmt -> execute();
?>
</body>
</html>