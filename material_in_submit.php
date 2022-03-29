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

if (!empty($_POST["goodsCode"])){ $goodsCode = $_POST['goodsCode']; }
if (!empty($_POST["itemCode"])){ $itemCode = $_POST['itemCode']; }
if (!empty($_POST["partName"])){ $partName = $_POST['partName']; }
if (!empty($_POST["partNumber"])){ $partNumber = $_POST['partNumber']; }

if (!empty($_POST["currentStock"])){ $currentStock = $_POST['currentStock']; }
if (!empty($_POST["receivedQTY"])){ $receivedQTY = $_POST['receivedQTY']; }
if (!empty($_POST["invoiceKit"])){ $invoiceKit = $_POST['invoiceKit']; }
if (!empty($_POST["location"])){ $location = $_POST['location']; }
if (!empty($_POST["itemNumber"])){ $itemNumber = $_POST['itemNumber']; }
// if (!empty($_POST["qtyStored"])){ $qtyStored = $_POST['qtyStored']; }
// if (!empty($_POST["pt_date"])){ $pt_date = $_POST['pt_date']; }


$sql_select = "SELECT * From stocks_record_tbl"; 
$sql_select_run = sqlsrv_query($conn, $sql_select);

    date_default_timezone_set('Asia/Hong_Kong'); 
    $updatedStock = $currentStock + $receivedQTY;
    $date = date('m-d-Y H:i:s');

    if ($sql_select_run){
                // //Query for Insert
                $sql_select_reports = "SELECT * FROM transaction_reports_tbl";
                $params = array();
                $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                $stmt = sqlsrv_query( $conn, $sql_select_reports, $params, $options);
                $row_count = sqlsrv_num_rows( $stmt );
                $currentRow = $row_count + 1;

                $sql_insert = "INSERT INTO transaction_reports_tbl (id, TRANSACTION_DATE, GOODS_CODE, ITEM_CODE, QTY_RECEIVED, TOTAL_STOCK, PART_NUMBER, PART_NAME, INVOICE_KIT, ITEM_NUMBER) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ";
                $params1 = array($currentRow, $date, $goodsCode, $itemCode, $receivedQTY, $updatedStock, $partNumber, $partName, $invoiceKit, $itemNumber);

                $sql_insert_run = sqlsrv_query($conn, $sql_insert, $params1);

                if($sql_insert_run){
                    $sql_insert2 = "INSERT INTO stocks_location_tbl (id, GOODS_CODE, ITEM_CODE, QTY_STORED, DATE_STORED, LOCATION_NAME, ITEM_NUMBER) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $params2 = array($currentRow, $goodsCode, $itemCode, $receivedQTY, $date, $location, $itemNumber);
                    $sql_insert2_run= sqlsrv_query($conn, $sql_insert2, $params2);

                    $sql_update = "UPDATE stocks_record_tbl set TOTAL_STOCK = $updatedStock
                    WHERE GOODS_CODE = '$goodsCode' AND ITEM_CODE = '$itemCode' ";
                    $sql_update_run = sqlsrv_query($conn, $sql_update);
                    
                    if($sql_update_run){
                        echo "Successful! Stock is updated to $updatedStock.";
                    }
                }
                if( $sql_insert_run === false) {
                    die( print_r( sqlsrv_errors(), true) );
                }

            }else{
                echo "Unable to process" . die( print_r( sqlsrv_errors(), true) );
            }
        
        
 


?> 



                