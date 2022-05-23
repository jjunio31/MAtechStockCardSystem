$(document).ready(function(){
    $("#on-camera").click(function(){
        var scanner = new Instascan.Scanner({ video: document.getElementById('preview'),backgroundScan:true, continuous: true, mirror:false});
                   Instascan.Camera.getCameras().then(function(cameras){
                    if (cameras.length > 0) {
                        var selectedCam = cameras[0];
                        $.each(cameras, (i, c) => {
                            if (c.name.indexOf('back') !== -1) {
                                selectedCam = c;
                                return false;
                            }
                        });
                
                        scanner.start(selectedCam);
                    }

                    $("#off-camera").click(function (e) { 
                        e.preventDefault();
                        scanner.stop(selectedCam);

                      });
        
                   }).catch(function(e) {
                       console.error(e);
                   });

                   scanner.addListener('scan',function(c){
                       document.getElementById('qrResult').value=c;

                    //code for beep sound
                    function play() {   
                    var beepsound = new Audio(   
                    'sound/beep.mp3');   
                        beepsound.play();   
                    }   
                    play();
                    //code for beep sound

                       //code for ajax // show result when qr is scanned
                       var codeResult = $('input[id=qrResult]').val();

                       $.ajax({
                        type: "post",
                        url: "assyLine.php",
                        data: {codeResult: codeResult},
                        dataType: "text",
                        success: function (data) {
                         $("#assyLineDiv").html(data);
                        }
                    });

                    //    $.ajax({
                    //     type: "POST",
                    //     url: "reports_info.php",
                    //     data: {codeResult: codeResult},
                    //     dataType: "text",
                    //     success: function(data, response)
                    //     {
                    //         $("#formDiv").html(data);
                    //         $('#messageDisplay2').text(response);
                    //         // console.log(codeResult);

                    //         //AJAX TO PASS CURRENT MONTH TO reports_month.php
                    //         var d = new Date(),
                    //         n = '0' + (d.getMonth()+1);
                    
                    //         $.ajax({
                    //             type: "post",
                    //             url: "reports_month.php",
                    //             data: {
                    //                 n:n,
                    //                 codeResult:codeResult
                    //             },
                    //             dataType: "text",
                    //             success: function (data) {
                    //                 $('.monthReportDiv').html(data);
                    //                 // console.log(n);
                    //             }
                    //         });
                    // //AJAX TO PASS CURRENT MONTH TO reports_month.php
                    //     }
                    // });
 
                    
                   });
            });
        });

         
$("#on-camera").click(function (e) { 
    e.preventDefault();
    $('.previewDiv').show();
});
          

$(document).ready(function () {
    $("#off-camera").click(function (e) { 
        e.preventDefault();
        $('.previewDiv').hide();

      });
});

