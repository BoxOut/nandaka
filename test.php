<?php
	$dbopts = parse_url(getenv('DATABASE_URL'));
	echo 'hello';
	print_r($dbopts);
	echo  "host ".$dbopts["host"];
	echo  "port ".$dbopts["port"];
	echo  "pass ".$dbopts["pass"];
	echo  "path ".$dbopts["path"];
	try {
		// 各種パラメータを指定して接続
		$pdo_conn = new PDO( 'pgsql:host='.$dbopts["host"].'; dbname='.$dbopts["path"], $dbopts["user"], $dbopts["pass"] );
		var_dump("接続に成功しました");
	}
	catch(PDOException $e) {
	var_dump($e->getMessage());
	}
?>