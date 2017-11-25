<?php
	$dbopts = parse_url(getenv('DATABASE_URL'));
	echo 'hello';
	print_r($dbopts);
	echo  "host ".$dbopts["host"].'\n';
	echo  "port ".$dbopts["port"].'\n';
	echo  "pass ".$dbopts["pass"].'\n';
	echo  "path ".$dbopts["path"].'\n';
	try {
		// 各種パラメータを指定して接続
		$pdo_conn = new PDO( 'pgsql:host='.$dbopts["host"].'; dbname='.$dbopts["path"], $dbopts["user"], ltrim($dbopts["path"],'/') );
		var_dump("接続に成功しました");
	}
	catch(PDOException $e) {
	var_dump($e->getMessage());
	}
?>