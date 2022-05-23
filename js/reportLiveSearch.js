$(document).ready(function () {
    //AJAX on LIVE SEARCH
    $("#qrResult").keyup(function (e) { 
        var codeResult = $(this).val();

        $.ajax({
            type: "post",
            url: "assyLine.php",
            data: {codeResult: codeResult},
            dataType: "text",
            success: function (data) {
             $("#assyLineDiv").html(data);
            }
        });
        
    });
});


//ORIG CODE
// $(document).ready(function () {
//     //AJAX on LIVE SEARCH
//     $("#qrResult").keyup(function (e) { 
//         var codeResult = $(this).val();

//         $.ajax({
//             type: "post",
//             url: "assyLine.php",
//             data: {codeResult: codeResult},
//             dataType: "text",
//             success: function (data) {
//              $("#assyLineDiv").html(data);
//             }
//         });
        
//       if(codeResult != ""){
//           $.ajax({

//               url:"reports_info.php",
//               method:"POST",
//               data:{codeResult:codeResult},

//               success:function(data){
//                   $("#formDiv").html(data)
//                 //   console.log(codeResult);

//                   //AJAX TO PASS CURRENT MONTH TO reports_month.php
//                   var d = new Date(),
//                   n = '0' + (d.getMonth()+1);
                  
//                   $.ajax({
//                       type: "post",
//                       url: "reports_month.php",
//                       data: {
//                           n:n,
//                           codeResult:codeResult
//                       },
//                       dataType: "text",
//                       success: function (data) {
//                           $('.monthReportDiv').html(data);
//                           // console.log(n);
//                       }
//                   });

//                   //AJAX TO PASS CURRENT MONTH TO reports_month.php
//               }
//           })
//       }
//     });
// });