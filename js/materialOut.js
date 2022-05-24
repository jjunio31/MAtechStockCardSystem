$(document).ready(function(){
    $("#on-camera").click(function(){
        // let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});
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
                    //    document.forms[0].submit();

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
                        url: "assyLine_mat_out.php",
                        data: {codeResult: codeResult},
                        dataType: "text",
                        success: function (data) {
                         $("#assyLineDiv").html(data);
                        }
                    });

                    //    $.ajax({
                    //     type: "POST",
                    //     url: "material_out_info.php",
                    //     data: {codeResult: codeResult},
                    //     dataType: "text",
                    //     success: function(data)
                    //     {
                    //         $("#formDiv").html(data);
                    //     }
                    // });
                    

                   });
            }); 
        });

          $(document).ready(function () {
            $("#on-camera").click(function (e) { 
              e.preventDefault();
              $('.previewDiv').show();
            });
          });


$(document).ready(function () {
    $("#off-camera").click(function (e) { 
        e.preventDefault();
        $('.previewDiv').hide();

      });
});

          