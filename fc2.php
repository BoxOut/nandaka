<!DOCTYPE html>
<html lang="ja">

<head>
<link rel="stylesheet" type="text/css" href="css/box.css">
<meta charset="UTF-8">
<title>fc2API</title>

</head>

<body style="background-color : #BDBDBD">



<h1>FC2★Live★API</h1>
<center>


<?php


/////////   プレーヤー   /////////////

$url="https://live.fc2.com/embedPlayer/?id=";
$url2='&lang=ja&suggest=1&thumbnail=1&adultaccess=0&afid=31773606" frameborder="0" scrolling="no" autoplay="1"';


 if($_GET["id"]){

$video_url = $url.$_GET["id"].$url2; 
echo "<p>";
echo '<iframe width="650" height="500" src='. $video_url .'></iframe>';
echo "</p>";

 }
  else  echo "<p>click video you want to watch</p>";


echo "<br><br><br><br><br><br><br><br>";



/////////   一覧      /////////////


 
$url="http://live.fc2.com/contents/allchannellist.php";

    $json = file_get_contents($url.$_GET["url"]);
    $array=json_decode($json, true);
//    var_dump($array);

/*
<div class="imagebox">
   <p class="image"><img src="photo.jpg" width="120" height="96" alt="????"></p>
   <p class="caption">?????????</p>
</div>
*/

//array_multisort($array, array_column($array, 'count'));
//echo 'Current PHP version: ' . phpversion();

$channel=$array["channel"];
usort($channel, function ($a, $b) { return $b['count'] - $a['count']; });

    foreach ($channel as $val){
   $img=$val["image"];
   $title=$val["title"];
   $id=$val["id"];

  
echo '<a href="https://nandaka.herokuapp.com/fc2.php?id='.$id.'">' ;

  echo "<div class=\"imagebox\">";
  echo '<p class="image"><img src='.$img.' alt="video_thumb" width="140" height="100"></p>';
  echo "<p class=\"caption\">".$title."</p>";
  echo "</div>";

echo '</a>';

}

?>



</center>
</body>

</html>
