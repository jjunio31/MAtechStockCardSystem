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

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Jquery CDN-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <title>Reports</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
      .c2{
        overflow-x: scroll;
      }
    </style>
  </head>
  <body>

  <?php
$serverName = "192.168.2.15,40001";
$connectionInfo1 = array( "UID" => "iqc_db_user_dev", "PWD" => "iqcdbuserdev", "Database" => "MA_Receiving");
$conn1 = sqlsrv_connect($serverName, $connectionInfo1);

$connectionInfo2 = array( "UID" => "iqc_db_user_dev", "PWD" => "iqcdbuserdev", "Database" => "StockCard");
$conn2 = sqlsrv_connect($serverName, $connectionInfo2);

if( $conn1 === false )
{
echo "Could not connect.\n";
die( print_r( sqlsrv_errors(), true));
}
else {
//    echo "connection established 1";
}

if( $conn2 === false )
{
echo "Could not connect.\n";
die( print_r( sqlsrv_errors(), true));
}
else {
//    echo "connection established 2";
}

if (!empty($_POST["goodsCode"])){ 
    $goodsCode = $_POST['goodsCode']; 
}
if (!empty($_POST["itemCode"])){
     $itemCode = $_POST['itemCode']; 
}

  

    $sql_select1 = "SELECT * FROM transaction_record_tbl WHERE [GOODS_CODE] = '$goodsCode' ORDER BY id ASC";
    $sql_select1_run = sqlsrv_query( $conn2, $sql_select1 );
            if( $sql_select1_run  === false) {
            die( print_r( sqlsrv_errors(), true) );
            }
            
            $date = date('M d, Y');
            echo '<h3 class="text-center text-white bg-secondary rounded py-1">Transaction Report</h3>
            <div class="c2" id=""><table class="table table-bordered">
            
            <thead class="thead-dark">
                <tr>
                <th scope="col">DATE</th>
                <th scope="col">RECEIVED</th>
                <th scope="col">ISSUED</th>
                <th scope="col">STOCK</th>
                <th scope="col">INVOICE NO.</th>
                <th scope="col">ORDER NO.</th>
                
                </tr>
              </thead>
            
            <tbody>';
            if($sql_select1_run)
            {
                while($row = sqlsrv_fetch_array($sql_select1_run, SQLSRV_FETCH_ASSOC))
                {

                  if($row['TRANSACTION_DATE']->format("m") == '01'){

                    echo '<tr class="active bg-primary text-white">
                                      <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                      <td class="">'.$row['QTY_RECEIVED'].'</td>
                                      <td class="">'.$row['QTY_ISSUED'].'</td>
                                      <td class="">'.$row['TOTAL_STOCK'].'</td>
                                      <td class="">'.$row['INVOICE_KIT'].'</td>
                                      <td class="">'.$row['ORDER_NO'].'</td>
                                </tr>';
                    }

                else if($row['TRANSACTION_DATE']->format("m") == '02'){

                    echo '<tr class="active text-white" style = "background-color: #8a2be2;">
                                      <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                      <td class="">'.$row['QTY_RECEIVED'].'</td>
                                      <td class="">'.$row['QTY_ISSUED'].'</td>
                                      <td class="">'.$row['TOTAL_STOCK'].'</td>
                                      <td class="">'.$row['INVOICE_KIT'].'</td>
                                      <td class="">'.$row['ORDER_NO'].'</td>
                                </tr>';
                    }

               else if($row['TRANSACTION_DATE']->format("m") == '03'){

                    // if($count == 0){
                    //             echo '<tr class="bg-warning">
                    //                 <td></td>
                    //                 <td></td>
                    //                 <td></td>
                    //                 <td>'.$row['TOTAL_STOCK'].'</td>
                    //                 <td>MARCH BOH</td>
                    //             </tr>';
                    //             $count = 1;
                    //         }

                echo '<tr class="active text-white" style = "background-color:#FF6347;">
                                      <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                      <td class="">'.$row['QTY_RECEIVED'].'</td>
                                      <td class="">'.$row['QTY_ISSUED'].'</td>
                                      <td class="">'.$row['TOTAL_STOCK'].'</td>
                                      <td class="">'.$row['INVOICE_KIT'].'</td>
                                      <td class="">'.$row['ORDER_NO'].'</td>
                            </tr>';

                }


                else if($row['TRANSACTION_DATE']->format("m") == '04'){

                    echo '<tr class="active bg-secondary text-white">
                                      <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                      <td class="">'.$row['QTY_RECEIVED'].'</td>
                                      <td class="">'.$row['QTY_ISSUED'].'</td>
                                      <td class="">'.$row['TOTAL_STOCK'].'</td>
                                      <td class="">'.$row['INVOICE_KIT'].'</td>
                                      <td class="">'.$row['ORDER_NO'].'</td>
                                </tr>';
                    }

                    else if($row['TRANSACTION_DATE']->format("m") == '05'){

                        echo '<tr class="active bg-success">
                                      <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                      <td class="">'.$row['QTY_RECEIVED'].'</td>
                                      <td class="">'.$row['QTY_ISSUED'].'</td>
                                      <td class="">'.$row['TOTAL_STOCK'].'</td>
                                      <td class="">'.$row['INVOICE_KIT'].'</td>
                                      <td class="">'.$row['ORDER_NO'].'</td>
                                    </tr>';
                        }

                    else if($row['TRANSACTION_DATE']->format("m") == '06'){

                        echo '<tr class="active bg-dark text-white">
                                          <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                          <td class="">'.$row['QTY_RECEIVED'].'</td>
                                          <td class="">'.$row['QTY_ISSUED'].'</td>
                                          <td class="">'.$row['TOTAL_STOCK'].'</td>
                                          <td class="">'.$row['INVOICE_KIT'].'</td>
                                          <td class="">'.$row['ORDER_NO'].'</td>
                                    </tr>';
                        }

                    else if($row['TRANSACTION_DATE']->format("m") == '07'){

                        echo '<tr class="active text-white" style = "background-color:#FFC0CB;" >
                                          <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                          <td class="">'.$row['QTY_RECEIVED'].'</td>
                                          <td class="">'.$row['QTY_ISSUED'].'</td>
                                          <td class="">'.$row['TOTAL_STOCK'].'</td>
                                          <td class="">'.$row['INVOICE_KIT'].'</td>
                                          <td class="">'.$row['ORDER_NO'].'</td>
                                    </tr>';
                        }

                    else if($row['TRANSACTION_DATE']->format("m") == '08'){

                        echo '<tr class="active text-white" style = "background-color:#964B00;" >
                                          <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                          <td class="">'.$row['QTY_RECEIVED'].'</td>
                                          <td class="">'.$row['QTY_ISSUED'].'</td>
                                          <td class="">'.$row['TOTAL_STOCK'].'</td>
                                          <td class="">'.$row['INVOICE_KIT'].'</td>
                                          <td class="">'.$row['ORDER_NO'].'</td>
                                    </tr>';
                        }

                    else if($row['TRANSACTION_DATE']->format("m") == '09'){

                        echo '<tr class="active text-white bg-warning";" >
                                          <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                          <td class="">'.$row['QTY_RECEIVED'].'</td>
                                          <td class="">'.$row['QTY_ISSUED'].'</td>
                                          <td class="">'.$row['TOTAL_STOCK'].'</td>
                                          <td class="">'.$row['INVOICE_KIT'].'</td>
                                          <td class="">'.$row['ORDER_NO'].'</td>
                                    </tr>';
                        }

                    else if($row['TRANSACTION_DATE']->format("m") == '10'){

                        echo '<tr class="active text-white" style = "background-color:#ADD8E6;" >
                                          <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                          <td class="">'.$row['QTY_RECEIVED'].'</td>
                                          <td class="">'.$row['QTY_ISSUED'].'</td>
                                          <td class="">'.$row['TOTAL_STOCK'].'</td>
                                          <td class="">'.$row['INVOICE_KIT'].'</td>
                                          <td class="">'.$row['ORDER_NO'].'</td>
                                    </tr>';
                        }

                    else if($row['TRANSACTION_DATE']->format("m") == '11'){

                        echo '<tr class="active text-black bg-white">
                                          <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                          <td class="">'.$row['QTY_RECEIVED'].'</td>
                                          <td class="">'.$row['QTY_ISSUED'].'</td>
                                          <td class="">'.$row['TOTAL_STOCK'].'</td>
                                          <td class="">'.$row['INVOICE_KIT'].'</td>
                                          <td class="">'.$row['ORDER_NO'].'</td>
                                    </tr>';
                        }

                    else if($row['TRANSACTION_DATE']->format("m") == '12'){

                        echo '<tr class="active text-white bg-danger">
                                          <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                          <td class="">'.$row['QTY_RECEIVED'].'</td>
                                          <td class="">'.$row['QTY_ISSUED'].'</td>
                                          <td class="">'.$row['TOTAL_STOCK'].'</td>
                                          <td class="">'.$row['INVOICE_KIT'].'</td>
                                          <td class="">'.$row['ORDER_NO'].'</td>
                                    </tr>';
                        }

                        

            }

        }               
          
        echo '</tbody></table></div>';
    
        

            sqlsrv_free_stmt( $sql_select1_run);

    
        ?>
         
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
 


