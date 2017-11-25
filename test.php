<?php
	$dbopts = parse_url(getenv('DATABASE_URL'));
	echo 'hello';
	print_r($dbopts);
?>