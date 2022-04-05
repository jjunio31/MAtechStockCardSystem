<?php
$serverName = "192.168.2.15,40001";
$connectionInfo1 = array( "UID" => "iqc_db_user_dev", "PWD" => "iqcdbuserdev", "Database" => "MA_Receiving");
$conn1 = sqlsrv_connect($serverName, $connectionInfo1);

if( $conn1 === false )
{
echo "Could not connect.\n";
die( print_r( sqlsrv_errors(), true));
}

// Conn for StockCard
$connectionInfo2 = array( "UID" => "iqc_db_user_dev", "PWD" => "iqcdbuserdev", "Database" => "StockCard");
$conn2 = sqlsrv_connect($serverName, $connectionInfo2);

if( $conn2 === false )
{
echo "Could not connect.\n";
die( print_r( sqlsrv_errors(), true));
}

if (!empty($_POST["goodsCode"])){ $goodsCode = $_POST['goodsCode']; }
if (!empty($_POST["itemCode"])){ $itemCode = $_POST['itemCode']; }
if (!empty($_POST["partName"])){ $partName = $_POST['partName']; }
if (!empty($_POST["partNumber"])){ $partNumber = $_POST['partNumber']; }

if (!empty($_POST["currentQty"])){ $currentQty = $_POST['currentQty']; }
if (!empty($_POST["returnedqty"])){ $returnedqty = $_POST['returnedqty']; }
if (!empty($_POST["orderNum"])){ $orderNum = $_POST['orderNum']; }
if (!empty($_POST["reason"])){ $reason = $_POST['reason']; }
if (!empty($_POST["invoice"])){ $invoice = $_POST['invoice']; }




//SELECT Total_Stock 

$sql_select = "SELECT * From Total_Stock"; 
$sql_select_run = sqlsrv_query($conn1, $sql_select);

if( $sql_select_run === false) {
    die( print_r( sqlsrv_errors(), true) );
}

//SELECT Total_Stock $new_total_stock 
$sql_select_stock = "SELECT TOTAL_STOCK From Total_Stock
WHERE GOODS_CODE = '$goodsCode'";
$sql_select_stock_run = sqlsrv_query( $conn1, $sql_select_stock);

if( $sql_select_stock_run === false) {
    die( print_r( sqlsrv_errors(), true) );
}

if($sql_select_run && $sql_select_stock_run){

    while($row = sqlsrv_fetch_array($sql_select_stock_run, SQLSRV_FETCH_ASSOC))
        {
            $total_stock = $row['TOTAL_STOCK'];
        }

            $new_total_stock = $total_stock + $returnedqty;

            $sql_update= "UPDATE Total_Stock set TOTAL_STOCK = $new_total_stock
            WHERE GOODS_CODE = '$goodsCode'";
            $sql_update_run = sqlsrv_query($conn1, $sql_update);
                if($sql_update_run){
                    echo "Total Stock is updated to $new_total_stock.\n";
                    
                }else{
                    die( print_r( sqlsrv_errors(), true) );
                }                 
                         
            
            //QUERY to update transaction report

            $sql_transaction_tbl = "SELECT * FROM transaction_record_tbl";
            $sql_transaction_tbl_run = sqlsrv_query( $conn1, $sql_select_stock);

            if( $sql_transaction_tbl_run === false ) {
                die( print_r( sqlsrv_errors(), true));
           }

            date_default_timezone_set('Asia/Hong_Kong');  
            $date = date('m-d-Y H:i:s');
    
            $sql_insert = "INSERT INTO transaction_record_tbl (TRANSACTION_DATE, GOODS_CODE, QTY_ISSUED, QTY_RECEIVED, TOTAL_STOCK, PART_NUMBER, PART_NAME, INVOICE_KIT, REASON) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ";
            $params1 = array($date, $goodsCode, '0', $returnedqty, $new_total_stock, $partNumber, $partName, $invoice, $reason );
            $sql_insert_run = sqlsrv_query($conn2, $sql_insert, $params1);
    
            if( $sql_insert_run === false) {
                 echo "Unable to process transaction" . die( print_r( sqlsrv_errors(), true) );
            }
       


//END of if($sql_select_run && $sql_select_stock_run)
}else{
    die( print_r( sqlsrv_errors(), true) );
}

?>