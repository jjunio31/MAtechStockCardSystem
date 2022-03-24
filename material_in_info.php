<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Result</title>
    <!-- bootstrap CDN and CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
 
    <!-- Jquery CDN-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

  
    <style>


@import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');
.control {
  appearance: button;
  backface-visibility: hidden;
  border-radius: 25px;
  border-width: 0;
  box-shadow: rgba(50, 50, 93, .1) 0 0 0 1px inset,rgba(50, 50, 93, .1) 0 2px 5px 0,rgba(0, 0, 0, .07) 0 1px 1px 0;
  box-sizing: border-box;
  color: #fff;
  cursor: pointer;
  font-family: -apple-system,system-ui,"Segoe UI",Roboto,"Helvetica Neue",Ubuntu,sans-serif;
  font-size: 100%;
  height: 44px;
  line-height: 1.15;
  margin: 0;
  outline: none;
  overflow: hidden;
  padding:  0 ;
  position: relative;
  text-align: center;
  text-transform: none;
  transform: translateZ(0);
  transition: all .2s,box-shadow .08s ease-in;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  width: 100%;
}

        .button-9:disabled {
        cursor: default;
        }

        .button-9:focus {
        box-shadow: rgba(50, 50, 93, .1) 0 0 0 1px inset, rgba(50, 50, 93, .2) 0 6px 15px 0, rgba(0, 0, 0, .1) 0 2px 2px 0, rgba(50, 151, 211, .3) 0 0 0 4px;
        }

        
        .scan-result{
            padding: 1rem;
            height: 100%;
            width: 100%;
            border-radius: 10px;
        }
        .result-container input{
            width: 50%;
        }
       
        label{
            width: 9rem;
        }
        label{
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
        }

        #btn_showReport{
            margin: 0;
            display: none;
        }
        #btnDiv1, #btnDiv2{
            margin: 0;
            padding: 0;
        }
        #submitIssued{
            margin: 0;
        }
        #btnDiv2{
            margin-top: .3rem;
            
        }
        input{
            border-radius: 25px;
            border: 2px solid white;
            padding: 15px; 
            height: 11px;
        }

        .ui-state-active,
        .ui-widget-content .ui-state-active,
        .ui-widget-header .ui-state-active,
        a.ui-button:active,
        .ui-button:active,
        .ui-button.ui-state-active:hover {
        border: none!important;
        background: white;
        width: 10rem;
        font-weight: normal;
        color: black;
        padding: .5rem;
        font-size: 1.5rem;
        border-radius: 10px;
        }
        ul.ui-autocomplete {
            list-style: none;
            list-style-type: none;
            padding: .7rem;
            margin: .5rem 0px;
            background-color: #6c757d;
            max-width: 11rem;
            border-radius: 10px;
        }
        ul.ui-autocomplete{
            color: white;
            
        }
        li{
            padding: .2rem;
        }
        .ui-helper-hidden-accessible { display:none; 
        }
  
        
    </style>
<link rel="stylesheet" type="text/css" href="css/styles.css" />
</head>
<body>
    
<?php
$serverName = "192.168.2.15,40001";
$connectionInfo = array( "UID" => "iqc_db_user_dev", "PWD" => "iqcdbuserdev", "Database" => "StockCard");
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
    
    $sql_select = "SELECT * From stocks_record_tbl
    WHERE GOODS_CODE = '$qrResult'or PART_NUMBER = '$qrResult' or ITEM_CODE = '$qrResult' or ITEM_NUMBER = '$qrResult'";
    $stmt = sqlsrv_query( $conn, $sql_select );

    
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }

    if($stmt)
    {
        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
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
                <label class="text-white label">Item Number</label>
                <input type="text" readonly class="txtbox bg-secondary text-white" name="itemNumber" id="itemNumber" value="<?php echo $row['ITEM_NUMBER']?>">
                </div>
               
                <div class="result-container ">
                <label class="text-white label">Item Code</label>
                <input type="text" readonly class="txtbox bg-secondary text-white" name="itemCode" id="itemCode" value="<?php echo $row['ITEM_CODE']?>">
                </div>

                <!-- <div class="result-container ">
                <label class="text-white label">Item Number</label>
                <input type="text" readonly class="txtbox" name="itemNumber" id="itemNumber" value="<?php echo $row['ITEM_NUMBER']?>">
                </div> -->

                <div class="result-container ">
                <label class="text-white pr-2">Part Name</label>
                <input type="text" readonly class="txtbox bg-secondary text-white" name="partName" id="partName" value="<?php echo $row['PART_NAME']?>">
                </div>

                <div class="result-container ">
                <label class="text-white pr-2">Part Number</label>
                <input type="text" readonly class="txtbox bg-secondary text-white" name="partNumber" id="partNumber" value="<?php echo $row['PART_NUMBER']?>">
                </div>

                <div class="result-container ">
                <label class="text-white pr-2">Current Stock</label>
                <input type="text" readonly class="txtbox bg-secondary text-white" name="qty" id="currentStock" value="<?php echo $row['TOTAL_STOCK']?>">
                </div>

                <!-- <div class="result-container ">
                <label class="text-white pr-2">Date Received</label>
                <input type="date" class="txtbox" name="pt_date" id="pt_date" value="">
                </div> -->

                <div class="result-container ">
                <label class="text-white pr-2">Invoice/Kit No.</label>
                <input type="text"  class="txtbox" name="invoiceKit" id="invoiceKit" value="">
                </div>

                <div class="result-container ">
                <label class="text-white pr-2">QTY Received</label>
                <input  type="number" min="1" step="1" onkeypress="return event.keyCode === 8 || event.charCode >= 48 && event.charCode <= 57" id="receivedQTY">
                </div>

                <div class="result-container locationDivIn">
                <label class="text-white pr-2">Location</label> 
                <input type="text" class="txtbox" name="location" id="location" value="Location">
                <input type="text" class="txtbox" name="qtyStored" id="qtyStored" value="QTY Stored">
                </div>

            
                <div class="result-container d-flex justify-content-center">
                <h6 id="messageDisplay" class="text-warning"></h6>
                </div>

                <div class="result-container d-flex justify-content-center" id="btnDiv1">
                <button type="submit" class="btn btn-primary btn-block control" id="saveBTN">Save Data</button>
                </div>

                <div class="result-container d-flex justify-content-center" id="btnDiv2">
                <button type="submit" class="btn btn-primary btn-block control" id="btn_showReport">Show Transactions</button>
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

    sqlsrv_free_stmt( $stmt);
}

?>
<script src="js/ajax_mat_in.js"></script>
</body>
</html>


              