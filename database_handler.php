<?php

	$dbopts = parse_url(getenv('DATABASE_URL'));
	// header('Content-Type: application/json');

	try {
		// 各種パラメータを指定して接続
		$pdo = new PDO( 'pgsql:host='.$dbopts["host"].'; dbname='.ltrim($dbopts["path"],'/'), $dbopts["user"], $dbopts["pass"] );
		//var_dump("接続に成功しました\n");
	}
	catch(PDOException $e) {
	var_dump($e->getMessage());
	}
	if($_POST['op_type']=='add'){
		$stmt = $pdo->prepare('insert into playlist VALUES (?, ?, ?)');
		$stmt->bindValue(1, $_POST['video_id']);
		$stmt->bindValue(2, $_POST['video_title']);
		$stmt->bindValue(3, $_POST['img_id']);
		$stmt->execute();
	}
	else {
		$sql = "SELECT * FROM playlist";
		$res = $pdo->query($sql);
		$list = "";
		foreach ($data as $res) {
			$list +=  $_POST['video_id']+" "+$_POST['video_title']+" "+$_POST['video_img_id']+" ";
		}
    	echo $list
	}
?>