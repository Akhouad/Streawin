// -------------------------------
// SHOW & HIDE POPUPS (series page)
// -------------------------------
function showPopup(action, iframe){
  if(action === "trailer"){
    $(".popup_container").children(".popup_content").html(iframe);
  }

  $(".popup_container").css("top", 0);
  setTimeout(function(){
    $(".popup_container").css('left', 0);
  }, 600);
}

function hidePopup(){
  $(".popup_container").css("left", "-99%");
  setTimeout(function(){
    $(".popup_container").css("top", "100%");
  }, 600);
}

// -------------------------------
// FULL SCREEN CONTROL
// -------------------------------
function toggleFullScreen() {
  if (!document.fullscreenElement &&    // alternative standard method
      !document.mozFullScreenElement && !document.webkitFullscreenElement) {  // current working methods
    if (document.documentElement.requestFullscreen) {
      document.documentElement.requestFullscreen();
    } else if (document.documentElement.mozRequestFullScreen) {
      document.documentElement.mozRequestFullScreen();
    } else if (document.documentElement.webkitRequestFullscreen) {
      document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
    }
  } else {
    if (document.cancelFullScreen) {
      document.cancelFullScreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.webkitCancelFullScreen) {
      document.webkitCancelFullScreen();
    }
  }
}

$(window).load(function(){
  var full_screen = document.querySelector(".full_screen");
  full_screen.onclick = function(e){
    e.preventDefault();
    toggleFullScreen();
  };

  // -------------------------------
  // BROWSE FILTER
  // -------------------------------
  if($(".browse_filter").html() !== undefined){
    var filter_item = $(".filter_item"),
        line        = $(".browse_filter").children(".line");
    line.css("width", filter_item.first().width() + "px");

    filter_item.on("click", function(){
      var left = $(this).offset().left - $(".browse_filter").offset().left;
      $(".filter_item").css("color","#bfbfbf")
      $(this).css("color","#a6a6a6");
      line.css({
        left : left + "px",
        width : $(this).width()
      });
    });
  }


  // SWITCH SEASONS
  if(typeof $(".season") !== "undefined") {
    $(".season").on("click", function(e){
      e.preventDefault();
      $(".season.active").removeClass("active");
      $(this).addClass("active");
      $(".episodes_list").html('<div class="col-md-3"><div class="panel" style="padding:20px"><i class="icon ion-loading-a"></i></div></div>');


      $.ajax({
        type : "post",
        url  : "index.php?p=episodes-by-season&r=true",
        data : {
          "id_series" : $(".id_series").html(),
          "season" : $(this).data("season"),
        },
        success : function(data){
          $(".episodes_list").html(data);
        }
      });
    });
  }

    
  // SWITCH EPISODES
  if(typeof $(".episode") !== "undefined"){
    $(document).on("click", ".episode", function(e){
      e.preventDefault();
      console.log($(".title").html());
      $(".episode.active").removeClass("active");
      $(this).addClass("active");
      $(".num_e").html("Episode " + $(this).data("num"));
      $(".synopsis_e").html($(this).children(".synopsis").html());
      $(".title_e").html($(this).children(".title").html());
    });
  }


  // WATCH TRAILER
  if( typeof $(".trailer_btn") !== "undefined" ){
    $(".trailer_btn").on("click", function(e){
      e.preventDefault();
      window.location.hash = "trailer";

      var iframe = '<iframe style="width:100%;height:100%" src="https://www.youtube.com/embed/'+ $(".trailer_video").html() +'"  frameborder="0" allowfullscreen></iframe>';
      showPopup("trailer", iframe);
    });
  }


  // CLOSE POPUP
  if( typeof $(".close_popup") !== "undefined" ){
    $(".close_popup").on("click", function(){
      hidePopup();
      window.location.hash = "";
    });
  }


}); // end window load