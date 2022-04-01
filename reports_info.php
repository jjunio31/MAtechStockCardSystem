<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Result</title>
    <!-- bootstrap CDN and CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
    <!-- Jquery CDN-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <style>
    
    
        .result-container input{
            width: 50%;
        }
       
        label{
            width: 9rem;
            margin-bottom: 0;
        }
       
        .result-container{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: .3rem;
            width: 100%;
        }
        #formInfo{
            margin-top: .3rem;
            margin-bottom: .7rem;
            border-radius: 10px;
            width: 100%;
            height: auto;
            padding: .3rem;
        }
        #submitIssued{
            margin: 0;
        }
        input{
            border-radius: 25px;
            border: 2px solid white;
            padding: 15px; 
            height: 11px;
        }
        .table_reports{
            overflow: scroll;
        }

        thead th, tr, td {
        font-size: 1rem;
        padding: .5rem !important;
        height: 15px;
        }
      
    </style>
</head>
<body>
    
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


if (isset($_POST['codeResult'])) {
    $qrResult = $_POST['codeResult'];
    
    $sql_select = "SELECT TOP 1 * From Total_Stock
    WHERE GOODS_CODE = '$qrResult'or PART_NUMBER = '$qrResult' or ITEM_CODE = '$qrResult'";
    $sql_select_run = sqlsrv_query( $conn, $sql_select );

    if( $sql_select_run === false) {
        die( print_r( sqlsrv_errors(), true) );
    }

    if($sql_select_run)
    {
        while($row = sqlsrv_fetch_array($sql_select_run, SQLSRV_FETCH_ASSOC))
        {
            
           ?>
           <form  id="formInfo" method="post">
           <div class="scan-result bg-dark">


                <div class="result-container">
                
                </div>

                <div class="result-container ">
                <label class="text-white label">Goods Code</label>
                <input type="text" readonly class="txtbox bg-secondary text-white" name="goodscode" id="goodsCode" value="<?php echo $row['GOODS_CODE']?>">
                </div>
               
                <div class="result-container ">
                <label class="text-white label">Item Code</label>
                <input type="text" readonly class="txtbox bg-secondary text-white" name="itemCode" id="itemCode" value="<?php echo $row['ITEM_CODE']?>">
                </div>

                <div class="result-container ">
                <label class="text-white pr-2">Part Name</label>
                <input type="text" readonly class="txtbox bg-secondary text-white" name="partName" id="partName" value="<?php echo $row['MATERIALS']?>">
                </div>

                <div class="result-container ">
                <label class="text-white pr-2">Part Number</label>
                <input type="text" readonly class="txtbox bg-secondary text-white" name="partNumber" id="partNumber" value="<?php echo $row['PART_NUMBER']?>">
                </div>

                <div class="result-container ">
                <label class="text-white pr-2">Total Stock</label>
                <input type="text" readonly class="txtbox bg-secondary text-white" name="qty" id="currentStock" value="<?php echo $row['TOTAL_STOCK']?>">
                </div>

                <div class="result-container ">
                <label class="text-white pr-2">Location</label>
                <input type="text" readonly class="txtbox bg-secondary text-white" name="location" id="currentStock" value="<?php echo $row['LOC']?>">
                </div>

            </div>
            </form>
           <?php
        }
    }
    else
    {
        echo $qrResult . " Not Found";
    }

    if (isset($_POST['codeResult'])) {
        $qrResult = $_POST['codeResult'];
    }
        
        $serverName = "192.168.2.15,40001";
        $connectionInfo = array( "UID" => "iqc_db_user_dev", "PWD" => "iqcdbuserdev", "Database" => "StockCard");
        $conn = sqlsrv_connect($serverName, $connectionInfo);
         
        if( $conn === false )
        {
        echo "Could not connect.\n";
        die( print_r( sqlsrv_errors(), true));
        }
        
        $sql_select2 = "SELECT * From [transaction_record_tbl]
        WHERE GOODS_CODE = '$qrResult'or PART_NUMBER = '$qrResult' or ITEM_CODE = '$qrResult' ORDER BY id ASC";
        $sql_select_run2 = sqlsrv_query( $conn, $sql_select2 );

        if( $sql_select_run2 === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        echo '<div class="table_reports bg-light">';
        $date = date('M d, Y');

            echo '<div class="c2" id=""><table class="table table-bordered">
            <thead class="thead bg-primary py-1">
                <tr class="text-white">
                <th scope="col" class="w-25 text-center">DATE</th>
                <th scope="col" class="w-25">RECEIVED</th>
                <th scope="col" class="w-25">ISSUED</th>
                <th scope="col" class="w-25">STOCK</th>
                <th scope="col" class="w-25">INVOICE#</th>
                <th scope="col" class="w-25">ORDER#</th>
                </tr>
              </thead>

            <tbody>';
            if($sql_select_run2)
            {
                
                $count = 0;
                while($row = sqlsrv_fetch_array($sql_select_run2, SQLSRV_FETCH_ASSOC))
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
                                              <td class="active">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                              <td class="success">'.$row['QTY_RECEIVED'].'</td>
                                              <td class="warning">'.$row['QTY_ISSUED'].'</td>
                                              <td class="danger">'.$row['TOTAL_STOCK'].'</td>
                                              <td class="danger">'.$row['INVOICE_KIT'].'</td>
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
        




            sqlsrv_free_stmt( $sql_select_run2);

            echo '</div>';
}
 ?>

<script src="js/reports.js"></script>
</body>
</html>


              