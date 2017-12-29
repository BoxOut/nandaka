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
		$stmt = $pdo->prepare('insert into playlist VALUES (?, ?)');
		$stmt->bindValue(1, $_POST['video_id']);
		$stmt->bindValue(2, $_POST['video_title']);
		$stmt->execute();
	}
	elseif ($_POST['op_type']=='delete_video_data') {
		echo $_POST['video_id'];
		$stmt = $pdo->prepare('delete from playlist where video_id = ?');
		$stmt->bindValue(1, $_POST['video_id']);
		$stmt->execute();

	}
	else {
		$sql = "SELECT * FROM playlist";
		$res = $pdo->query($sql);
		$list = "";
		foreach ($res as $data) {
			// echo "$data[video_title]";
			$array[] = array('video_id' => $data[video_id], 'video_title' => $data[video_title]);
			// $list .=  "$data[video_id] $data[video_title] ";
		}
		echo json_encode($array);
	}
?>