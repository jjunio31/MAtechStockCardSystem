<?php

    include 'connections/ma_receiving_conn.php'; 
    include 'connections/stock_card_conn.php';


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
if (!empty($_POST["returnedqty"])){ $returned_qty = $_POST['returnedqty']; }
if (!empty($_POST["Assy"])){ $Assy = $_POST['Assy']; }
if (!empty($_POST["orderNum"])){ $orderNum = $_POST['orderNum']; }
if (!empty($_POST["selectedRemark"]))
{ 
    $remark = $_POST['selectedRemark']; 

}
//STRING TO INT CONVERSION
$returnedqty = (int)$returned_qty;

//SELECT Total_Stock $new_total_stock 
$sql_select_stock = "SELECT TOTAL_STOCK From Total_Stock
                     WHERE GOODS_CODE = '$goodsCode' AND ASSY_LINE = '$Assy'";
$sql_select_stock_run = sqlsrv_query( $conn1, $sql_select_stock);

if( $sql_select_stock_run === false) {
    die( print_r( sqlsrv_errors(), true) );
}else{

    while($row = sqlsrv_fetch_array($sql_select_stock_run, SQLSRV_FETCH_ASSOC))
        {
            $total_stock = $row['TOTAL_STOCK'];
        }

        $new_total_stock = $total_stock + $returnedqty;

        //QUERY to UPDATE TOTAL STOCK
        $sql_update= "UPDATE Total_Stock set TOTAL_STOCK = $new_total_stock
                      WHERE GOODS_CODE = '$goodsCode' AND ASSY_LINE = '$Assy'";
        $sql_update_run = sqlsrv_query($conn1, $sql_update);

        if($sql_update_run){
            echo "Total Stock is updated to $new_total_stock.\n";
        }else{
            die( print_r( sqlsrv_errors(), true) );
        }

}

if($sql_update_run){

    date_default_timezone_set('Asia/Hong_Kong');  
    $date = date('m-d-Y H:i:s');

    //QUERY to INSERT Returned Table
    $sql_insert_returned = "INSERT INTO [StockCard].[dbo].[returned_tbl] (DATE_RECEIVED, GOODS_CODE, ITEM_CODE, PART_NAME, PART_NUMBER, QTY_RECEIVED, REMARKS, QTY_S_RET, ASSY_LINE)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ";
    $params2 = array($date, $goodsCode, $itemCode,  $partName, $partNumber, $returnedqty, $remark, $returnedqty, $Assy );
    $sql_insert_returned_run = sqlsrv_query($conn2, $sql_insert_returned , $params2);

    if(!$sql_insert_returned_run) {
    echo "Unable to process transaction" . die( print_r( sqlsrv_errors(), true) );
    }


    //QUERY to INSERT to transaction_record_tbl
    $sql_insert = "INSERT INTO transaction_record_tbl (TRANSACTION_DATE, GOODS_CODE, ITEM_CODE, QTY_ISSUED, QTY_RECEIVED, TOTAL_STOCK, PART_NUMBER, PART_NAME, REMARKS, INVOICE_KIT, ASSY_LINE) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ";
    $params1 = array($date, $goodsCode, $itemCode, '0', $returnedqty, $new_total_stock, $partNumber, $partName, $remark, 'RETURNED', $Assy);
    $sql_insert_run = sqlsrv_query($conn2, $sql_insert, $params1);

    if(!$sql_insert_run) {
         echo "Unable to process transaction" . die( print_r( sqlsrv_errors(), true) );
    }

} 


?>