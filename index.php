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
   <script src="https://fb.me/JSXTransformer-0.13.3.js"></script>
  </head>
  <body style="background-color : #BDBDBD">

<div class="tit">
<h1>YoutubeAPI</h1>
</div>


<center>
<p>
<div  id="player"></div>
</p>
<p>
<button id="play">再生</button>
<button id="pause">一時停止</button>
<button id="prev">1分前へ</button>
<button id="next">1分先へ</button>
<button id="volup">音量アップ</button>
<button id="voldown">音量ダウン</button>
<button id="mute">ミュート</button>
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


  var list,next_page ;
  var playerFLG=0,
        play_id =0, got=[],search_word;

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
      videoId: list[current_num]['id']['videoId'],
      events: {
              'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
      }
    }
  );
  //console.log(ytPlayer);
      }

    else{
      ytPlayer.loadVideoById(list[current_num]['id']['videoId'],0);
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
        ytPlayer.loadVideoById(list[current_num]['id']['videoId'],0);
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
           list: [],
           word: "",
           hst_flag: false,
           hst_list: ["linux","windows"],
           detail_list : []
         };
       },

     componentDidMount: function () {
      console.log("componentDitMount");
      window.addEventListener('scroll', this.onScroll);
       },

       onScroll: function(detail) {

        var scrollHeight = $(document).height();
        var scrollPosition = $(window).height() + $(window).scrollTop();
        
        // 画面最下部までスクロールしたタイミングで
        if ((scrollHeight - scrollPosition) / scrollHeight < 0.1) {
      console.log("bottom");
          // window.removeEventListener('scroll', this.handleScroll);
         this.api_call_search();
      }
    },

    get_detail: function(){
      const self = this;
      var dt_list = self.state.detail_list;
       
        channel = event.srcElement.className;
        var param = {"key":"AIzaSyD3R2gavNlItHEZWTt-_UOMEwFwMN5reiQ",
        "part":"statistics,snippet,contentDetails",
        "id":channel
        };
        console.log("get_detail",channel, event.srcElement.className);

  $.getJSON(
  "https://www.googleapis.com/youtube/v3/channels?",
   param
    ,
      function(data, status) {
          var title  =data["items"][0]["snippet"]["title"],
          uploads=data["items"][0]["contentDetails"]["relatedPlaylists"]["uploads"];
          dt_list[channel] = {"uploads" : uploads, "video_num": data["items"][0]["statistics"]["videoCount"]};
          self.setState({detail_list : dt_list});
      });
    },

    api_call_search: function(){
      const self = this;

      var param = {"key":"AIzaSyD3R2gavNlItHEZWTt-_UOMEwFwMN5reiQ",
        "part":"snippet",
        "maxResults":50,
        "order":"date",
        "type":"video",
        "videoDefinition":"any",
        "q" : search_word
      }; 
      console.log("api_call_search", next_page, search_word);
      if(got.includes(next_page))return;
      if(next_page){param["pageToken"] = next_page; got.push(next_page);}

      $.getJSON(
      "https://www.googleapis.com/youtube/v3/search?",
       param
        ,
        function(data, status) { 
      console.log(data);
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

 onHistory : function()  {
    list=null; got=[]; next_page=null;
    search_word=event.srcElement.className;
    this.api_call_search();
  },

 render: function() {

  var on_search = (event) =>{
    this.setState({word:event.target.value});
  },

  handleKeyPress = (event) => {
  if(event.key == 'Enter'){
    console.log("enter");
    this.setState({detail_list : []}); 

    list=null; got=[],next_page=null;
    search_word=event.target.value;
    this.setState(prevState => ({ hst_list: prevState.hst_list.concat([search_word]) } ));
    this.api_call_search();
  }};

  MouseOver = (event) => {
    this.setState({hst_flag : true});
    console.log("onMouse");
  };

  MouseOut = (event) => {
    this.setState({hst_flag : false});
    console.log("onOut");
  };

     // console.log("render");
      const self = this;
      const dt_list = this.state.detail_list;
      const videos = this.state.list.map( function(data, index){
      
      const video_url="https://www.youtube.com/watch?v=";
      const  dt_url = "https://nandaka.herokuapp.com/uplist.html#";


      var img_url=data["snippet"]["thumbnails"]["medium"]["url"],
           title_o=data["snippet"]["title"],title_cut = title_o;
      if(title_o.length > 30) title_cut = title_o.slice(0,30);

      var detail = <span onClick={self.get_detail} className={data["snippet"]["channelId"]}>detail</span>;
      if(dt_list[data["snippet"]["channelId"]])
      detail = <a href={dt_url+dt_list[data["snippet"]["channelId"]].uploads} target={"_blank"}>
      {dt_list[data["snippet"]["channelId"]].video_num+" videos"}</a>;

      return (
      <div className={"imagebox2"}>
      <a href={video_url+data['id']['videoId']} target={"_blank"} title={title_o}>
      <p className={"image2"}><img src={img_url} alt="video_thumb"  width={200} height={150} /></p>
      <p className={"caption2"}>{title_cut}</p></a>{detail}
      <span className="play" id={index} onClick={self.playVideo}> play</span>
      </div>
      );});

      console.log("render",videos);
      
      const hst_data = this.state.hst_list.map( function(data, index){ 
      return <span className={data} onClick={self.onHistory}>{data+" "}</span>;
      }); 

      const hst = this.state.hst_flag ?  <div className={"history"}>{hst_data}</div> : <div>history</div> ;

         return <div>
         <p><input type="text" onChange={on_search} value={this.state.word} onKeyPress={handleKeyPress} /><div onMouseEnter={MouseOver} onMouseLeave={MouseOut} style={{display : 'inline-block'}}> {hst}</div></p>
      {videos}</div>;
       }
     });
  
   // id='app' に <Parent />を表示する（マウント）
     var m = ReactDOM.render(<Parent />, document.getElementById('app'));



    </script>

  </body>
</html>