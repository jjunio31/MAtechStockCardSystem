<!doctype html> 
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Instascan-->
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <!--font-awesome CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    

    <!-- bootstrap CDN and CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    

    <!-- Jquery CDN-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="css/styles.css">

    <title>Reports</title>
    
  </head>
  <body>    
            <!-- topnav -->
            <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <a class="navbar-brand companyName" href="#">M.A. Technology Inc.</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <a class="nav-item nav-link text-white bg-primary" href="reports.php">Reports</a>
              <a class="nav-item nav-link text-white bg-primary" href="material_in.php">Material-In</a>
              <a class="nav-item nav-link text-white bg-primary" href="material_out.php">Material-Out</a>
              <!-- <a class="nav-item nav-link text-info" href="stocks.php">Stocks</a> -->
              <a class="nav-item nav-link text-white bg-primary" id="logout" href="logOut.php">Logout<i class="fa-solid fa-power-off fa-lg"></i></a>
            </div>
            </div>
            </nav>

            <!-- Material Out Section-->
  <div class="container-fluid">
                
              <div class="scandiv bg-dark">
              <p class="text-info font-italic" id="date">Today is <span><?php $date = date('M d, Y'); echo $date; ?></span> </p>
                <h3 class="text-center text-white">QR Code Scanner</h3>
              
                    <div class="previewDiv">
                        <video id="preview" class="reportsPreview" style="background-image: url('img/case-study.png');"></video>
                        <audio id="beepsound">
                        <source src="sound/beep.mp3" type="audio/mpeg">
                        </audio>
                        
                    </div>
                    <div class="controlsDiv">
                      <button  class="control" id="on-camera">Open Camera</button>
                      <button  class="control" id="off-camera">Close Camera</button>
                      <button  class="btn btn-dark btn-md control switch" id="flashlight-icon"><i class="fa-solid fa-lightbulb fa-xl"></i></button>
                      
                    </div>
              </div>

                <div class="scanresultdiv">

                    <div class="formresult bg-dark" >
                  
                    <h3 class="text-center text-white">Search Report</h3>
                    <div class="qrResultDiv d-flex justify-content-center">
                    <input type="text" name="qrResult" id="qrResult" value="">
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
    <script src="js/reports.js"></script>
    <script src="js/logout.js"></script>

</body>
</html>
