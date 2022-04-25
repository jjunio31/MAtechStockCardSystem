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


if (!empty($_POST["partNumber"])){ 
    $partNumber = $_POST['partNumber']; 
}else{
    $partNumber = "N/A";
}

if (!empty($_POST["partName"])){ 
    $partName = $_POST['partName']; 
}else{
    $partName = "N/A";
}


if (!empty($_POST["goodsCode"])){ $goodsCode = $_POST['goodsCode']; }
if (!empty($_POST["itemCode"])){ $itemCode = $_POST['itemCode']; }
if (!empty($_POST["currentQty"])){ $currentQty = $_POST['currentQty']; }
if (!empty($_POST["returnedqty"])){ $returnedqty = $_POST['returnedqty']; }
if (!empty($_POST["orderNum"])){ $orderNum = $_POST['orderNum']; }
if (!empty($_POST["selectedRemark"]))
{ 
    $remark = $_POST['selectedRemark']; 

}

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

            //QUERY to UPDATE TOTAL STOCK
            $sql_update= "UPDATE Total_Stock set TOTAL_STOCK = $new_total_stock
            WHERE GOODS_CODE = '$goodsCode'";
            $sql_update_run = sqlsrv_query($conn1, $sql_update);

            // if $sql_update_run, SAVE TRANSACTION TO RETURNED TABLE AND TRANSACTION TABLE

                if($sql_update_run){
                    echo "Total Stock is updated to $new_total_stock.\n";

                    //QUERY to INSERT to transaction_record_tbl

            $sql_transaction_tbl = "SELECT * FROM transaction_record_tbl";
            $sql_transaction_tbl_run = sqlsrv_query( $conn1, $sql_select_stock);

            if( $sql_transaction_tbl_run === false ) {
                die( print_r( sqlsrv_errors(), true));
           }

            date_default_timezone_set('Asia/Hong_Kong');  
            $date = date('m-d-Y H:i:s');
    
            $sql_insert = "INSERT INTO transaction_record_tbl (TRANSACTION_DATE, GOODS_CODE, ITEM_CODE, QTY_ISSUED, QTY_RECEIVED, TOTAL_STOCK, PART_NUMBER, PART_NAME, REMARKS) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ";
            $params1 = array($date, $goodsCode, $itemCode, '0', $returnedqty, $new_total_stock, $partNumber, $partName, $remark );
            $sql_insert_run = sqlsrv_query($conn2, $sql_insert, $params1);
    
            if(!$sql_insert_run) {
                 echo "Unable to process transaction" . die( print_r( sqlsrv_errors(), true) );
            }
       

            //QUERY to INSERT Returned Table
            $sql_insert_returned = "INSERT INTO [StockCard].[dbo].[returned_tbl] (DATE_RECEIVED, GOODS_CODE, ITEM_CODE, PART_NAME, PART_NUMBER, QTY_RECEIVED, REMARKS, QTY_S_RET)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?) ";
            $params2 = array($date, $goodsCode, $itemCode,  $partName, $partNumber, $returnedqty, $remark, $returnedqty );
            $sql_insert_returned_run = sqlsrv_query($conn2, $sql_insert_returned , $params2);
            
            if(!$sql_insert_returned_run) {
                echo "Unable to process transaction" . die( print_r( sqlsrv_errors(), true) );
           }
                    

        //    END of if($sql_update_run){
                }else{
                    die( print_r( sqlsrv_errors(), true) );
                }                 
                         
            
            

//END of if($sql_select_run && $sql_select_stock_run)
}else{
    die( print_r( sqlsrv_errors(), true) );
}

?>