//AJAX on LIVE SEARCH
$(document).ready(function () {
    $("#qrResult").keyup(function (e) { 
        var codeResult = $(this).val();

      if(codeResult != ""){
          $.ajax({

              url:"material_out_info.php",
              method:"POST",
              data:{codeResult:codeResult},

              success:function(data){
                  $("#formDiv").html(data)
                //   console.log(codeResult);
              }
          })
      }
    });
});