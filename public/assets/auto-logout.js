function autoLogout() {
  var lastActivity = new Date().getTime();

  $(document).on("mousemove keyup", function() {
    lastActivity = new Date().getTime();
  });

  setInterval(function() {
    var now = new Date().getTime();

    if (now - lastActivity > 300000) { // 5 minutes
     window.location.href = '/logout';
    }
  }, 300000);
}

$(document).ready(autoLogout);