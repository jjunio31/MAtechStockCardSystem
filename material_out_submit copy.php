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

if (!empty($_POST["partName"])){ 
    $partName = $_POST['partName']; 
}else{
    $partName = "N/A";
}

if (!empty($_POST["partNumber"])){ 
    $partNumber = $_POST['partNumber']; 
}else{
    $partNumber = "N/A";
}

if (!empty($_POST["selectedRemark"]))
{ 
    $remark = $_POST['selectedRemark']; 
}

if (!empty($_POST["goodsCode"])){ $goodsCode = $_POST['goodsCode']; }
if (!empty($_POST["itemCode"])){ $itemCode = $_POST['itemCode']; }
if (!empty($_POST["currentQty"])){ $currentQty = $_POST['currentQty']; }
if (!empty($_POST["issuedQty"])){ $issuedQty = $_POST['issuedQty']; }
if (!empty($_POST["orderNum"])){ $orderNum = $_POST['orderNum']; }


//SELECT Total_Stock 

$sql_select = "SELECT * From Total_Stock"; 
$sql_select_run = sqlsrv_query($conn1, $sql_select);

if( $sql_select_run === false) {
    die( print_r( sqlsrv_errors(), true) );
}

//SET TOTAL STOCK INTO VARIABLE
$sql_select_stock = "SELECT TOTAL_STOCK From Total_Stock
WHERE GOODS_CODE = '$goodsCode' or ITEM_CODE = '$itemCode' ";
$sql_select_stock_run = sqlsrv_query( $conn1, $sql_select_stock);

if( $sql_select_stock_run === false) {
    die( print_r( sqlsrv_errors(), true) );
}else{

    while($row = sqlsrv_fetch_array($sql_select_stock_run, SQLSRV_FETCH_ASSOC))
        {
            $total_stock = $row['TOTAL_STOCK'];
        }
}


//SET TOTAL STOCK of EARLIEST INVOICE INTO VARIABLE
$sql_select1 = "SELECT DATE_RECEIVE, GOODS_CODE,INVOICE, SUM(QTY_S) as total_qty 
FROM [Receive] WHERE GOODS_CODE = '$goodsCode' or ITEM_CODE = '$itemCode' 
GROUP BY DATE_RECEIVE, [INVOICE], [GOODS_CODE]";

$sql_select1_run = sqlsrv_query( $conn1, $sql_select1 );

if( $sql_select1_run  === false) 
{
die( print_r( sqlsrv_errors(), true) );
}

    if($sql_select1_run)
    {
    while($row = sqlsrv_fetch_array($sql_select1_run, SQLSRV_FETCH_ASSOC))
        {

            $total_stock_qtys = $row['total_qty'];

        if ($total_stock_qtys > 0)

            {
                $total_qtys[] = $row['total_qty']; 
                $e_invoice[] = $row['INVOICE'];
            }

        }
                
        $earliest_qtys = $total_qtys[0];
        $earliest_invoice = $e_invoice[0]; 

        
        //SET count of invoice that has the same value
        $sql_invoice = "SELECT DATE_RECEIVE, INVOICE, COUNT(*) as inv_row
        FROM [Receive] 
        WHERE GOODS_CODE = '$goodsCode' or ITEM_CODE = '$itemCode' 
        GROUP BY DATE_RECEIVE, INVOICE 
        ORDER BY DATE_RECEIVE;";

        $sql_invoice_run = sqlsrv_query( $conn1, $sql_invoice );

        while($row = sqlsrv_fetch_array($sql_invoice_run , SQLSRV_FETCH_ASSOC))
        {

            $inv_row = $row['inv_row'];

        if ($total_stock_qtys > 0)

            {
                $total_inv_row[] = $row['inv_row'];
            }
        }

        $inv_total_c = $total_inv_row[0];

    } 

//CODE for deduct qty from returned table goes below-------------------

$issQty = 75500;


while ($issQty > 0) {
    $sql_select_returned = "SELECT TOP 1 * FROM [returned_tbl]
                        WHERE QTY_S_RET > 0
                        -- WHERE GOODS_CODE = '$goodsCode' or ITEM_CODE = '$itemCode'
                        ORDER BY id ASC";
    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    
    $sql_select_returned_run = sqlsrv_query( $conn2, $sql_select_returned, $params, $options);
    $row_count = sqlsrv_num_rows( $sql_select_returned_run );

    while($row_ret = sqlsrv_fetch_array($sql_select_returned_run , SQLSRV_FETCH_ASSOC)) {
                $checkID =  $row_ret['id'];
                $checkQTY =  $row_ret['QTY_S_RET'];
                echo $checkID ."ID". " " . $checkQTY. "QTY";
            }

        if($issQty > $checkQTY) {

            $sql_update_ret = "UPDATE returned_tbl
                               SET QTY_S_RET = 0
                               WHERE id = $checkID";
            $sql_update_ret_run = sqlsrv_query($conn2, $sql_update_ret);
           
        } else {
        
                    if($sql_update_ret_run) {
                        
                        $issQty-=$checkQTY;
                        $new2 = $issQty *-1;
                        $sql_update_ret = "UPDATE returned_tbl
                                           SET QTY_S_RET = $new2
                                           WHERE id = $checkID";
                        $sql_update_ret_run = sqlsrv_query($conn2, $sql_update_ret);

                    } else {
                
                        $new3 = $checkQTY-$issQty;
                        $sql_update_ret = "UPDATE returned_tbl
                                           SET QTY_S_RET = $new3 
                                           WHERE id = $checkID";
                        $sql_update_ret_run = sqlsrv_query($conn2, $sql_update_ret);
                    }
        }


        if($sql_update_ret_run) {
        $issQty-=$checkQTY;
        }
}

//CODE for deduct qty from returned table goes above-------------------



//UPDATE TOTAL STOCK

    // if($sql_select_stock_run && $sql_select1_run)
    // {
    
    //     if ($issuedQty < $earliest_qtys && $issuedQty < $total_stock)
    //     {
    //         $new_total_stock = $total_stock - $issuedQty;
    
    //         $sql_update= "UPDATE Total_Stock set TOTAL_STOCK = $new_total_stock
    //                       WHERE GOODS_CODE = '$goodsCode' or ITEM_CODE = '$itemCode'";
    //         $sql_update_run = sqlsrv_query($conn1, $sql_update);
    //                         if($sql_update_run)
    //                         {
    //                             echo "Total Stock is updated to $new_total_stock.\n";
                                
    //                         }else
    //                         {
    //                             die( print_r( sqlsrv_errors(), true) );
    //                         }  
    //     }           
        
    //             // QUERY to update transaction report
    //             date_default_timezone_set('Asia/Hong_Kong');  
    //             $date = date('m-d-Y H:i:s');
        
    //             $sql_insert = "INSERT INTO transaction_record_tbl (TRANSACTION_DATE, GOODS_CODE, QTY_ISSUED, TOTAL_STOCK, PART_NUMBER, PART_NAME, ORDER_NO, REMARKS) 
    //             VALUES (?, ?, ?, ?, ?, ?, ?, ?) ";
    //             $params1 = array($date, $goodsCode, $issuedQty, $new_total_stock, $partNumber, $partName, $orderNum, $remark );
    //             $sql_insert_run = sqlsrv_query($conn2, $sql_insert, $params1);
        
    //             if( $sql_insert_run === false) {
    //                  echo 'Unable to process transaction' . die( print_r( sqlsrv_errors(), true) );
    //             }
    //         }
           

?>