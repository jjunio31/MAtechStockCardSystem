$(document).ready(function () {
  //AJAX on LIVE SEARCH
  $("#qrResult").keyup(function (e) { 
      var codeResult = $(this).val();

      $.ajax({
          type: "post",
          url: "assyLine_mat_out.php",
          data: {codeResult: codeResult},
          dataType: "text",
          success: function (data) {
           $("#assyLineDiv").html(data);
          }
      });
      
  });
});