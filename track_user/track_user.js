$(document).ready(function() {
  var start = new Date();
  var mouse_clicks = 0;

  $(document).click(function() {
  mouse_clicks += 1;  
});

  $(window).on("unload", function() {
      var end = new Date();
      var time = (end - start) / 1000;

      $.ajax({
      	type: "post", 
        url: "/visitors/track_user/track_user.php",
        data: {'time_spent': time,
        	   'clicks': mouse_clicks
    			},
        async: false
      });
   });
});