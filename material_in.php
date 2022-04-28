<!doctype html> 
<html lang="en">


<?php 
//INCLUDE HEADERS FROM HTML FOLDER
  include 'html/head.php';
?>

  <body>   

<?php 
//INCLUDE NAVIGATION FROM HTML FOLDER
  include 'html/nav.php';
?>


            <!-- Material Out Section-->
  <div class="container-fluid">
                
              <div class="scandiv bg-dark">
              <p class="text-white" id="date"><?php echo "Hi," . " " . $firstName[0]."!". " "?>Today is <span><?php $date = date('M d, Y'); echo $date; ?></span> </p>
              <h3 class="text-center text-warning">QR Code Scanner</h3>
                    <div class="previewDiv">
                        <video id="preview" class="reportsPreview" style="background-image: url('img/packing.png');"></video>
                        <audio id="beepsound">
                        <source src="sound/beep.mp3" type="audio/mpeg">
                        </audio>
                        
                    </div>
                    <?php   
                    include 'html/scannerbtn.php';
                    ?>
              </div>

                <div class="scanresultdiv">

                    <div class="formresult bg-dark" >
                  
                    <h3 class="text-center text-warning material-title">Material-In</h3>
                    <div class="qrResultDiv d-flex justify-content-center">
                    <input type="text" name="qrResult" id="qrResult" value="" placeholder="Goods Code">
                    </div>
                      

                </div>

                  <div id="formDiv" class="bg-dark"></div> <!--div for Result (AJAX)-->

                  <!--div for Report (AJAX)-->
                  <div id="reportDiv" class="bg-light">
                  <div class="report" id="report">
                  

                  </div>

                  </div> 


                
  </div>
            <!--end of main container-->

      
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/logout.js"></script>
    <script src="js/materialIn.js"></script>
    <script src="js/mat_in_liveSearch.js"></script>
    <script src="js/ajax_mat_in.js"></script>
</body>
</html>
