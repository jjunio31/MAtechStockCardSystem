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

if (!empty($_POST["goodsCode"])){ $goodsCode = $_POST['goodsCode']; }
if (!empty($_POST["itemCode"])){ $itemCode = $_POST['itemCode']; }
if (!empty($_POST["partName"])){ $partName = $_POST['partName']; }
if (!empty($_POST["partNumber"])){ $partNumber = $_POST['partNumber']; }

if (!empty($_POST["currentQty"])){ $currentQty = $_POST['currentQty']; }
if (!empty($_POST["issuedQty"])){ $issuedQty = $_POST['issuedQty']; }
if (!empty($_POST["invoiceKit"])){ $invoiceKit = $_POST['invoiceKit']; }
 


$sql_select = "SELECT * From Total_Stock"; 
$sql_select_run = sqlsrv_query($conn1, $sql_select);

$sql_select2 = "SELECT * From transaction_record_tbl"; 
$sql_select_run2 = sqlsrv_query($conn2, $sql_select2);

if( $sql_select_run2 === false) {
    die( print_r( sqlsrv_errors(), true) );
}

if( $sql_select_run === false) {
    die( print_r( sqlsrv_errors(), true) );
}

    if ($sql_select_run){

        if ($currentQty < $issuedQty){
            echo "Not Enough Stock";
        }else{
            $updatedStock = $currentQty - $issuedQty;
            $sql_update= "UPDATE Total_Stock set TOTAL_STOCK = $updatedStock
            WHERE GOODS_CODE = '$goodsCode' AND ITEM_CODE = '$itemCode' ";
            $sql_update_run = sqlsrv_query($conn1, $sql_update);
            if($sql_update_run){
                echo "Successful! Stock is updated to $updatedStock.";
            }else{
                echo "Unable to process" . die( print_r( sqlsrv_errors(), true) );
            }

        if($sql_update_run){
            $sql_select_reports = "SELECT * FROM transaction_record_tbl";
            $params = array();
            $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
            $stmt = sqlsrv_query( $conn2, $sql_select_reports, $params, $options);
            $row_count = sqlsrv_num_rows( $stmt );
            $currentRow = $row_count + 1;

            if( $sql_select_reports  === false) {
                echo "Unable to record transaction" . die( print_r( sqlsrv_errors(), true) );
            }

            date_default_timezone_set('Asia/Hong_Kong');  
            $date = date('m-d-Y H:i:s');

            $sql_insert = "INSERT INTO transaction_record_tbl (id, TRANSACTION_DATE, GOODS_CODE, ITEM_CODE, QTY_ISSUED, TOTAL_STOCK, PART_NUMBER, PART_NAME, INVOICE_KIT) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ";
            $params1 = array($currentRow, $date, $goodsCode, $itemCode, $issuedQty, $updatedStock, $partNumber, $partName, $invoiceKit );
            $sql_insert_run = sqlsrv_query($conn2, $sql_insert, $params1);
            
            if( $sql_insert_run === false) {
                echo "Unable to process transaction" . die( print_r( sqlsrv_errors(), true) );
            }
            }else{
            echo "Unable to record transaction" . die( print_r( sqlsrv_errors(), true) );
            }
        }
        

}

?> 



                