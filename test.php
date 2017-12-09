<?php
	$dbopts = parse_url(getenv('DATABASE_URL'));
	echo 'hello';
	// print_r($dbopts);

	try {
		// 各種パラメータを指定して接続
		$pdo_conn = new PDO( 'pgsql:host='.$dbopts["host"].'; dbname='.ltrim($dbopts["path"],'/'), $dbopts["user"], $dbopts["pass"] );
		var_dump("接続に成功しました");
	}
	catch(PDOException $e) {
	var_dump($e->getMessage());
	}
?>