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
    
    
    
        thead th, tr, td {
        font-size: .9rem;
        padding: .5rem !important;
        height: 15px;
        }

        thead th{
        font-size: .8rem;
        padding: .2rem !important;
     
        }

        .table_reports{
            overflow: scroll;
        }

        #SelectMonth{
            width: 50%;
            border-radius: 25px;
            border: 2px solid white;
            padding: .2rem; 
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


    $sql_part_number = "SELECT PART_NUMBER From [Receive]
    WHERE GOODS_CODE = '$qrResult'or PART_NUMBER = '$qrResult' or ITEM_CODE = '$qrResult' ";
    $sql_part_number_run = sqlsrv_query( $conn, $sql_part_number );

    while($row_partNumber = sqlsrv_fetch_array($sql_part_number_run, SQLSRV_FETCH_ASSOC))
        {
            $partNumber = $row_partNumber['PART_NUMBER'];
        }


    
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
            

                <div class="result-container ">
                <label class="text-warning label">Goods Code</label>
                <input type="text" readonly class="txtbox bg-secondary text-warning" name="goodscode" id="goodsCode" value="<?php echo $row['GOODS_CODE']?>">
                </div>
               
                <div class="result-container ">
                <label class="text-warning label">Item Code</label>
                <input type="text" readonly class="txtbox bg-secondary text-warning" name="itemCode" id="itemCode" value="<?php echo $row['ITEM_CODE']?>">
                </div>

                <div class="result-container ">
                <label class="text-warning pr-2">Part Name</label>
                <input type="text" readonly class="txtbox bg-secondary text-warning" name="partName" id="partName" value="<?php echo $row['MATERIALS']?>">
                </div>

                <div class="result-container ">
                <label class="text-warning pr-2">Part Number</label>
                <input type="text" readonly class="txtbox bg-secondary text-warning" name="partNumber" id="partNumber" value="<?php echo $partNumber?>">
                </div>

                <div class="result-container ">
                <label class="text-warning pr-2">Total Stock</label>
                <input type="text" readonly class="txtbox bg-secondary text-warning" name="qty" id="currentStock" value="<?php echo $row['TOTAL_STOCK']?>">
                </div>

                <div class="result-container ">
                <label class="text-warning pr-2">Location</label>
                <input type="text" readonly class="txtbox bg-secondary text-warning" name="location" id="currentStock" value="<?php echo $row['LOC']?>">
                </div>

                <div class="result-container ">
                <label class="text-warning pr-2">Select Month</label>
                <form action="" method="POST">
                    <select class="text-white bg-primary" name="SelectMonth" id="SelectMonth">
                    <option value="none" disabled selected class="dropdown-item bg-dark text-primary px-5">Select Month</option>
                    <option value="01" id="1" class="dropdown-item bg-primary text-white">January</option>
                    <option value="02" class="dropdown-item text-white" style="background-color: #8a2be2">February</option>
                    <option value="03" class="dropdown-item text-white" style="background-color: #FF6347">March</option>
                    <option value="04" class="dropdown-item text-white bg-secondary">April</option>
                    <option value="05" class="dropdown-item text-white bg-success">May</option>
                    <option value="06" class="dropdown-item text-white bg-dark" >June</option>
                    <option value="07" class="dropdown-item text-white" style="background-color: #FFC0CB">July</option>
                    <option value="08" class="dropdown-item text-white" style="background-color: #964B00">August</option>
                    <option value="09" class="dropdown-item text-white bg-warning">September</option>
                    <option value="10" class="dropdown-item text-white" style="background-color: #ADD8E6">October</option>
                    <option value="11" class="dropdown-item text-dark bg-white" >November</option>
                    <option value="12" class="dropdown-item text-white bg-danger">December</option>
                    <option value="all" class="dropdown-item text-white bg-secondary">All Transactions</option>
                    </select>
                </form>
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
      
}
 ?>

<script src="js/reports.js"></script>
<script src="js/reports_month.js"></script>
</body>
</html>


              