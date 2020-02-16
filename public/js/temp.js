<script>
    
      jQuery(function($) {
         
  
        $( document ).ready(function() {

          var midYoutubeDiv = $("#mid-youtube-video-div");
          var waveImage = $("#wave-image");
          var factor = 1.527777778;
  
          windowsCurrent = $( window );
          configureWindows(windowsCurrent);
  
          $(window).on('resize', function(){
              var win = $(this); //this = window
              midYoutubeDiv = $("#mid-youtube-video-div");

              console.log(midYoutubeDiv);
              configureWindows(win);
          });
  
  
          function configureWindows(win) {
              widthCurrent = win.width();

              console.log(widthCurrent);
  
              var heitghtCurrent = parseInt(widthCurrent / factor).toString();
  
              midYoutubeDiv.css("height", heitghtCurrent + "px");
            

              if (widthCurrent >= 1530) {
                waveImage.css("marginTop", "-200px");
                midYoutubeDiv.css("marginTop", "-75px");
              }

              
              if (widthCurrent < 1380) {
                waveImage.css("marginTop", "-180px");
                midYoutubeDiv.css("marginTop", "-75px");
              }

              if (widthCurrent < 1294) {
                waveImage.css("marginTop", "-180px");
                midYoutubeDiv.css("marginTop", "-75px");
              }


              if (widthCurrent < 1131) {
                waveImage.css("marginTop", "-170px");
                midYoutubeDiv.css("marginTop", "-75px");
              }

              if (widthCurrent < 1116) {
                waveImage.css("marginTop", "-150px");
                midYoutubeDiv.css("marginTop", "-50px");
              }
              
  
              if (widthCurrent < 1028) {
                waveImage.css("marginTop", "-140px");
                midYoutubeDiv.css("marginTop", "-50px");
              }
  
              if (widthCurrent < 808) {
                waveImage.css("marginTop", "-120px");
                midYoutubeDiv.css("marginTop", "-50px");
              }

              if (widthCurrent < 642) {
                waveImage.css("marginTop", "-100px");
                midYoutubeDiv.css("marginTop", "-50px");
              }
  
              if (widthCurrent < 527) {
                waveImage.css("marginTop", "-90px");
                midYoutubeDiv.css("marginTop", "-30px");
              }
  
              if (widthCurrent < 500) {
                waveImage.css("marginTop", "-90px");
                midYoutubeDiv.css("marginTop", "-25px");
              }
  
              if (widthCurrent < 449) {
                waveImage.css("marginTop", "-85px");
                midYoutubeDiv.css("marginTop", "-23px");
              }
  
              if (widthCurrent < 407) {
                waveImage.css("marginTop", "-80px");
                midYoutubeDiv.css("marginTop", "-21px");
              }
  
              if (widthCurrent < 315) {
                waveImage.css("marginTop", "-75px");
                midYoutubeDiv.css("marginTop", "-21px");
              }
          }
  
        });
      });
      

      var tag = document.createElement('script');
      var player;

      document.addEventListener("DOMContentLoaded", function(event) {
          // 2. This code loads the IFrame Player API code asynchronously.
          
    
          tag.src = "https://www.youtube.com/iframe_api";
          var firstScriptTag = document.getElementsByTagName('script')[0];
          firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

          
          onYouTubeIframeAPIReady();
          
          window.onYouTubePlayerAPIReady = function() {
            onYouTubeIframeAPIReady();
          };

          // 3. This function creates an <iframe> (and YouTube player)
          //    after the API code downloads.
          
          function onYouTubeIframeAPIReady() {
            player = new YT.Player('mid-youtube-video-div', {
              height: '100%',
              width: '100%',
              videoId: '_Y3ARjF4SJA',
              playerVars: { 'autoplay': 1, 'playsinline': 1, 'playlist': '_Y3ARjF4SJA', 'mute': 1, 'controls': 0, 'showinfo': 0, 'loop': 1, 'modestbranding': 1, 'rel': 0, 'disablekb': 1 },
              events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
              }
            });
          }

          // 4. The API will call this function when the video player is ready.
          function onPlayerReady(event) {
            event.target.playVideo();
          }

          // 5. The API calls this function when the player's state changes.
          //    The function indicates that when playing a video (state=1),
          //    the player should play for six seconds and then stop.
          var done = false;
          function onPlayerStateChange(event) {
            if (event.data == YT.PlayerState.PLAYING && !done) {
              // setTimeout(stopVideo, 6000);
              done = true;
            }
          }
          function stopVideo() {
            player.stopVideo();
          }
      });
  
      </script>
