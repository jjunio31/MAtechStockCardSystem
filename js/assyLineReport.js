$(document).ready(function () {
    $('.assyBTN').click(function (e) { 
        e.preventDefault();

        var AssybuttonVal = $(this).val();
        var codeResult = $('.codeResult').val();

        $.ajax({
            type: "POST",
            url: "reports_info.php",
            data: {
                AssybuttonVal:AssybuttonVal,
                codeResult:codeResult
            },
            dataType: "text",
            success: function (data) {
                $("#formDiv").html(data)
                // AJAX TO PASS CURRENT MONTH TO reports_month.php
              var d = new Date(),
              n = '0' + (d.getMonth()+1);
              
              $.ajax({
                  type: "post",
                  url: "reports_month.php",
                  data: {
                      n:n,
                      codeResult:codeResult,
                      AssybuttonVal:AssybuttonVal
                  },
                  dataType: "text",
                  success: function (data) {
                      $('.monthReportDiv').html(data);
                      // console.log(n);
                  }
              });
            }
        });
    
        // console.log(AssybuttonVal);
        // console.log(codeResult);
    });
});