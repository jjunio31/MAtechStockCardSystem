$(document).ready(function(){
    $("#on-camera").click(function(){
        $('.previewDiv').show();
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
                        type: "POST",
                        url: "material_in_info.php",
                        data: {codeResult: codeResult},
                        dataType: "text",
                        success: function(data)
                        {
                            $("#formDiv").html(data);
                           
                        }
                    });

                   });
            });
        });
          //AJAX on LIVE SEARCH

          $(document).ready(function () {
              $("#qrResult").keyup(function (e) { 
                  var codeResult = $(this).val();

                if(codeResult != ""){
                    $.ajax({

                        url:"material_in_info.php",
                        method:"POST",
                        data:{codeResult:codeResult},

                        success:function(data){
                            $("#formDiv").html(data);
                            
                        }
                    })
                }
              });
          });


$(document).ready(function () {
    $("#off-camera").click(function (e) { 
        e.preventDefault();
        $('.previewDiv').hide();
      });
    
});

$(document).ready(function () {
    $("#LocQRbtn").click(function(){
        $('#on-camera').hide();
        $('.previewDiv').show();

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
                        $('#on-camera').show();
                      });
        
                   }).catch(function(e) {
                       console.error(e);
                   });
                   scanner.addListener('scan',function(c){
                       document.getElementById('location').value=c;

                    //code for beep sound
                    function play() {   
                    var beepsound = new Audio(   
                    'sound/beep.mp3');   
                        beepsound.play();   
                    }   
                    play();
                    //code for beep sound
                });
    })
});
          
$(document).ready(function () {
    $("#reset").click(function(){
        $("#qrResult").val("");
    })
});