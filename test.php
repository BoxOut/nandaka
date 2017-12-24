<?php
	$dbopts = parse_url(getenv('DATABASE_URL'));
	echo 'hello\n';
	// print_r($dbopts);

	try {
		// 各種パラメータを指定して接続
		$pdo = new PDO( 'pgsql:host='.$dbopts["host"].'; dbname='.ltrim($dbopts["path"],'/'), $dbopts["user"], $dbopts["pass"] );
		var_dump("接続に成功しました\n");
	}
	catch(PDOException $e) {
	var_dump($e->getMessage());
	}
	echo $_POST['video_id'],$_POST['img_id'];
	$stmt = $pdo->prepare('insert into playlist VALUES (?, ?)');
	$stmt->bindValue(1, $_POST['video_id']);
	$stmt->bindValue(2, $_POST['img_id']);
	$stmt->execute();

	$sql = "SELECT * FROM playlist";
	$res = $pdo->query($sql);
	foreach( $res as $value ) {
		echo "$value[name] $value[id] <br>";
	}
?>