$(document).ready(function () {
  $("#register").click(function () {
    $("#loginnow").slideUp("slow", function () {
      $("#registernow").slideDown("slow");
    });
  });

  $("#return").click(function () {
    $("#registernow").slideUp("slow", function () {
      $("#loginnow").slideDown("slow");
    });
  });
});
