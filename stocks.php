<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Instascan-->
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <!--font-awesome CDN-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">

    <!--Link CSS-->
    <link rel="stylesheet" href="/css/material-out.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Jquery CDN-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="js/release.js"></script>
    <title>Stocks</title>
  </head>
  <body>    
            <!-- topnav -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">M.A. Technology Inc.</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <a class="nav-item nav-link text-info" href="index.php">Reports</a>
              <a class="nav-item nav-link text-info" href="material_in.php">Material-In</a>
              <a class="nav-item nav-link text-info" href="material_out.php">Material-Out</a>
              <a class="nav-item nav-link text-info" href="stocks.php">Stocks</a>
              <a class="nav-item nav-link text-info" id="logout" href="logOut.php">Logout</a>
            </div>
            </div>
            </nav>

            

            
        

            <div class="page-header">
                <h2 class="text-center">Stocks Record</h2>
            </div>
        
            
                
              <?php
            $serverName = "192.168.2.15,40001";
            $connectionInfo = array( "UID" => "iqc_db_user_dev", "PWD" => "iqcdbuserdev", "Database" => "MA_Receiving");
            $conn = sqlsrv_connect($serverName, $connectionInfo);
            
            if( $conn === false )
            {
            echo "Could not connect.\n";
            die( print_r( sqlsrv_errors(), true));
            }
            else {
                //echo "connection established";
            }

            $sql = "SELECT TOP 20 id, PRODUCT_COAT, PRODUCT_KEY, PRODUCT_NAME FROM Masterlist";
            $stmt = sqlsrv_query( $conn, $sql );
            $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);
            if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
            }

            echo '<div class="c2"><table class="table table-bordered table-dark">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Product Coat</th>
                <th scope="col">Product Key</th>
                <th scope="col">Product Name</th>
                <th scope="col">Current Stock</th>
                </tr>
              </thead>
            
            <tbody>';
            if($stmt)
            {
                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
                {

            echo '<tr class="active">
                                      <td class="active">'.$row['id'].'</td>
                                      <td class="success">'.$row['PRODUCT_COAT'].'</td>
                                      <td class="warning">'.$row['PRODUCT_KEY'].'</td>
                                      <td class="danger">'.$row['PRODUCT_NAME'].'</td>
                                </tr>';
                }
            }               
              
            echo '</tbody></table></div>';
        

            sqlsrv_free_stmt( $stmt);

        ?>
                  
             
             
        


<!-- $sql = "SELECT TOP 20 id, PRODUCT_COAT, PRODUCT_KEY, PRODUCT_NAME FROM Masterlist";
            $stmt = sqlsrv_query( $conn, $sql );
            if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
            }

            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                  echo $row['id'].", ".$row['PRODUCT_COAT']. ", " .$row['PRODUCT_NAME']. "<br />";
            }

            sqlsrv_free_stmt( $stmt); -->
           
          
           
        
        

        <!-- Footer -->
        <!-- <footer class="page-footer font-small blue bg-dark"> -->

        <!-- Copyright -->
        <!-- <div class="footer-copyright text-center py-3 ">© 2022 Copyright:
        <a href="#">M.A Technologies Inc</a>
        </div> -->
        <!-- Copyright -->
  
        <!-- </footer> -->
        <!-- Footer -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/materialOut.js"></script>
    <script src="js/logout.js"></script>
</body>
</html>