<!DOCTYPE html>
<html>
  <head>
<link rel="stylesheet" type="text/css" href="css/box.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://unpkg.com/react@15/dist/react.min.js"></script>
<script src="https://unpkg.com/react-dom@15/dist/react-dom.min.js"></script>
  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser.min.js"></script>
    <script src="http://fb.me/react-0.13.3.js"></script>
https://www.youtube.com/channel/UCBHA7pLwHqxk3NCYGT-p1KA
   -->
   <script src="http://fb.me/JSXTransformer-0.13.3.js"></script>
  </head>
  <body style="background-color : #BDBDBD">

<div class="tit">
<h1>YoutubeAPI</h1>
</div>


<center>
<p>
<div  id="player"></div>
</p>

</center>

    <div id="app"></div>

 <!--
  <script type="text/jsx">
 -->
 <script type="text/jsx">

//UUX1xppLvuj03ubLio8jsly
//UU1MwWJ2mFWp51xy9yzyhTlg

var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var channel = location.hash;
channel = channel.substr(1,channel.length);

console.log(channel);

  var list,next_page ;
  var playerFLG=0,
        play_id =0, got=[];

   function playVideo2(id) {
      
      console.log("play");
      current_num = id;

      $('body, html').scrollTop(0);

     if(playerFLG<1){
      playerFLG++;
      ytPlayer = new YT.Player(
    'player', // 埋め込む場所の指定
    {
      width: 740, // プレーヤーの幅
      height: 500, // プレーヤーの高さ
      videoId: list[current_num]['snippet']['resourceId']['videoId'],
      events: {
              'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
      }
    }
  );
  //console.log(ytPlayer);
      }

    else{
      ytPlayer.loadVideoById(list[current_num]['snippet']['resourceId']['videoId'],0);
    }

    function onPlayerStateChange(event){
      if(event.data == YT.PlayerState.ENDED){
        console.log("video end");
        var time = 0;
        if( ++current_num == list.length ){ 
          if(list["nextPageToken"]){
            time = 2000;
           // api_call(list["nextPageToken"]);
          }
          current_num = 0;
         }
         setTimeout(function() {
        ytPlayer.loadVideoById(list[current_num]['snippet']['resourceId']['videoId'],0);
         }, time);
      }
    }
          function onPlayerReady(event) {
        event.target.playVideo();
      }
    }

     // 親：<Parent />の定義
var Parent = React.createClass({
       // State（※状態は親が管理）
       // この値はブラウザを閉じたり、リロードするまでは保持される
       getInitialState: function () {
      console.log("getInitialState");
         return {
           list: []
         };
       },

     componentDidMount: function () {
      console.log("componentDitMount");
      window.addEventListener('scroll', this.onScroll);
      this.api_call();
       },

       onScroll: function(detail) {

        var scrollHeight = $(document).height();
        var scrollPosition = $(window).height() + $(window).scrollTop();
        
        // 画面最下部までスクロールしたタイミングで
        if ((scrollHeight - scrollPosition) / scrollHeight < 0.1) {
      console.log("bottom");
          // window.removeEventListener('scroll', this.handleScroll);
         this.api_call();
      }
    },


    api_call: function(){ 

     const self = this;

  var param = {"key":"AIzaSyD3R2gavNlItHEZWTt-_UOMEwFwMN5reiQ",
    "part":"snippet",
    "playlistId":channel+"",
"maxResults":50
    }; 

  console.log(got);
  if(got.includes(next_page))return;
  if(next_page){param["pageToken"] = next_page; got.push(next_page);}

  $.getJSON(
  "https://www.googleapis.com/youtube/v3/playlistItems?",
   param
    ,
    function(data, status) {    // 通信成功時にデータを表示
    console.log(next_page);

   list = list ? list.concat(data["items"]):data["items"];
   next_page = data["nextPageToken"]?data["nextPageToken"]:null;
    self.setState({list:list});

    }
  );
},

  playVideo : function(event){
        console.log("playVideo", event.target.id);
        play_id=event.target.id;
    playVideo2(play_id);
  },

   on_click: function(){
        this.setState({list:list});
       },
       // <Parent />の表示
       render: function() {

     // console.log("render");
      const self = this;
      const videos = this.state.list.map( function(data, index){ 
      
      const video_url="https://www.youtube.com/watch?v=";


       var img_url=data["snippet"]["thumbnails"]["medium"]["url"],
           title_o=data["snippet"]["title"],title_cut = title_o;
      if(title_o.length > 30) title_cut = title_o.slice(0,30);

       //title=substr($title_o, 0,70);
//echo '<div class="play" id="'.$count++.'" >play</div>';

        return (
      <div className={"imagebox2"}>
      <a href={video_url+data["snippet"]['resourceId']['videoId']} target={"_blank"} title={title_o}>
      <p className={"image2"}><img src={img_url} alt="video_thumb"  width={200} height={150} /></p>
      <p className={"caption2"}>{title_cut}</p></a>
      <div className="play" id={index} onClick={self.playVideo}>play</div>
      </div>
      ); } 
        ); 

         return <div>{videos}</div>;
       }
     });
  
   // id='app' に <Parent />を表示する（マウント）
     var m = ReactDOM.render(<Parent />, document.getElementById('app'));



    </script>

  </body>
</html>