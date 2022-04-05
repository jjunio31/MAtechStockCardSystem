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
if (!empty($_POST["issuedQty"])){ $issuedQty = $_POST['issuedQty']; }
if (!empty($_POST["orderNum"])){ $orderNum = $_POST['orderNum']; }

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

            $new_total_stock = $total_stock - $issuedQty;

            $sql_update= "UPDATE Total_Stock set TOTAL_STOCK = $new_total_stock
            WHERE GOODS_CODE = '$goodsCode' or ITEM_CODE = '$itemCode'";
            $sql_update_run = sqlsrv_query($conn1, $sql_update);
                if($sql_update_run){
                    echo "Total Stock is updated to $new_total_stock.\n";
                    
                }else{
                    die( print_r( sqlsrv_errors(), true) );
                }                 
                         

            // // // put earliest invoice into a variable
            $sql_select_invoice = "SELECT id, DATE_RECEIVE, GOODS_CODE,INVOICE, QTY_S FROM [Receive] WHERE QTY_S > 0 AND GOODS_CODE = '$goodsCode' or ITEM_CODE = '$itemCode' GROUP BY id, QTY_S, DATE_RECEIVE, [INVOICE], [GOODS_CODE] 
            ORDER BY DATE_RECEIVE ASC";
            $sql_select_invoice_run = sqlsrv_query( $conn1, $sql_select_invoice);
            if($sql_select_invoice_run)
            {
                while($row = sqlsrv_fetch_array($sql_select_invoice_run, SQLSRV_FETCH_ASSOC))
                {
                   if ($row['INVOICE'] > 0){

                   }
                   $invoices[] = $row['INVOICE'];
                   $earliest_invoice = $invoices [0];

                   $ids[]= $row['id'];
                   $earliest_id = $ids [0];

                   $qtys[] = $row['total_qty'];
                   $earliest_qtys = $qtys[0];

                   $qtys[] = $row['QTY_S'];
                   $total_qtys = array_sum($qtys);

                }
            } else {
               die( print_r( sqlsrv_errors(), true) );
            }
  
            echo $qtys;
            // echo $earliest_invoice . $earliest_qtys;
            // $new_qtys = $earliest_qtys - $issuedQty;
            // // update query for qtys 

            
            // $sql_update_qtys = "UPDATE [Receive] set QTY_S = $new_qtys
            // WHERE GOODS_CODE = '$goodsCode' AND INVOICE = '$earliest_invoice' AND id = '$earliest_id' ";
            // $sql_update_qtys_run= sqlsrv_query($conn1, $sql_update_qtys);
            //     if($sql_update_qtys_run === false){
            //         die( print_r( sqlsrv_errors(), true) );
            //     } else{
            //         echo  $earliest_invoice ." " . "stock is updated to" . " " . $new_qtys;
            //     }

            
            //QUERY to update transaction report
            date_default_timezone_set('Asia/Hong_Kong');  
            $date = date('m-d-Y H:i:s');
    
            $sql_insert = "INSERT INTO transaction_record_tbl (TRANSACTION_DATE, GOODS_CODE, QTY_ISSUED, TOTAL_STOCK, PART_NUMBER, PART_NAME, ORDER_NO) 
            VALUES (?, ?, ?, ?, ?, ?, ?) ";
            $params1 = array($date, $goodsCode, $issuedQty, $new_total_stock, $partNumber, $partName, $orderNum );
            $sql_insert_run = sqlsrv_query($conn2, $sql_insert, $params1);
    
            if( $sql_insert_run === false) {
                 echo "Unable to process transaction" . die( print_r( sqlsrv_errors(), true) );
            }
       


//END of if($sql_select_run && $sql_select_stock_run)
}else{
    die( print_r( sqlsrv_errors(), true) );
}

?>