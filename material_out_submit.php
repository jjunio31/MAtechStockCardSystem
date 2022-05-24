<?php

    include 'connections/ma_receiving_conn.php'; 
    include 'connections/stock_card_conn.php';


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
if (!empty($_POST["issuedQty"])){ $issued_Qty = $_POST['issuedQty']; }
if (!empty($_POST["orderNum"])){ $orderNum = $_POST['orderNum']; }
if (!empty($_POST["Assy"])){ $Assy = $_POST['Assy']; }


$issuedQty = (int)$issued_Qty ;

//SET TOTAL STOCK INTO VARIABLE
$sql_select_stock = "SELECT TOTAL_STOCK From Total_Stock
WHERE GOODS_CODE = '$goodsCode' AND ASSY_LINE = '$Assy' ";
$sql_select_stock_run = sqlsrv_query( $conn1, $sql_select_stock);

if( $sql_select_stock_run === false) {
    die( print_r( sqlsrv_errors(), true) );
}else{

    while($row = sqlsrv_fetch_array($sql_select_stock_run, SQLSRV_FETCH_ASSOC))
        {
            $total_stock = $row['TOTAL_STOCK'];
        }
        
}

function UPDATE_STOCK_AND_TRANSACTION($conn1, $conn2, $total_stock, $issuedQty, $goodsCode, $itemCode, $partNumber, $partName, $orderNum, $remark, $Assy){
    $new_total_stock = $total_stock - $issuedQty;
            
                    $sql_update= "UPDATE Total_Stock set TOTAL_STOCK = $new_total_stock
                                  WHERE GOODS_CODE = '$goodsCode' AND ASSY_LINE = '$Assy'";
                    $sql_update_run = sqlsrv_query($conn1, $sql_update);
                    if($sql_update_run){
                        echo "Total Stock is updated to $new_total_stock.\n";                             
                    }else{
                            die( print_r( sqlsrv_errors(), true) );
                    }             

                date_default_timezone_set('Asia/Hong_Kong');  
                $date = date('m-d-Y H:i:s');
        
                $sql_insert = "INSERT INTO transaction_record_tbl (TRANSACTION_DATE, GOODS_CODE, QTY_ISSUED, TOTAL_STOCK, PART_NUMBER, PART_NAME, ORDER_NO, REMARKS, ASSY_LINE) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ";
                $params1 = array($date, $goodsCode, $issuedQty, $new_total_stock, $partNumber, $partName, $orderNum, $remark, $Assy );
                $sql_insert_run = sqlsrv_query($conn2, $sql_insert, $params1);
        
                if( $sql_insert_run === false) {
                     echo 'Unable to process transaction' . die( print_r( sqlsrv_errors(), true) );
                }
}




//QUERY TO SUM QTY_S_RET OF RETURNED TABLE
$sql_sum_returned = "SELECT  GOODS_CODE, SUM(QTY_S_RET) as qtys_sum 
FROM [StockCard].[dbo].[returned_tbl]
WHERE GOODS_CODE = '$goodsCode' AND QTY_S_RET > 0 
GROUP BY [GOODS_CODE]";

$params_returned = array();
$options_returned =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

$sql_select1_run2 = sqlsrv_query( $conn2, $sql_sum_returned, $params_returned, $options_returned);

$row_count_returned = sqlsrv_num_rows( $sql_select1_run2 );
        if(!$sql_select1_run2) {
        die( print_r( sqlsrv_errors(), true) );
        }else{

           while($row_sum_ret = sqlsrv_fetch_array($sql_select1_run2, SQLSRV_FETCH_ASSOC))
           {
               //DECLARE VARIABLE FOR TOTAL SUM OF SUM(QTY_S_RET)
              $qtys_sum = $row_sum_ret['qtys_sum'];
           }
        }

//CONDITION IF DEDUCT WILL BE IN RETURNED TABLE OR RECEIVED TABLE
if($row_count_returned > 0){
//********************************CODE for deduct qty from returned table goes below****************************************************
        if($issuedQty > $qtys_sum){
            echo ('Unable to process request.'.' ' . 'Release first all returned materials before releasing new invoices. ');
        }else{

             // UPDATE TOTAL STOCK and SAVE TRANSACTION FUNCTION
            UPDATE_STOCK_AND_TRANSACTION($conn1, $conn2, $total_stock, $issuedQty, $goodsCode, $itemCode, $partNumber, $partName, $orderNum, $remark, $Assy);
            
                   
                while ($issuedQty> 0) {
                    $sql_select_returned = "SELECT TOP 1 * FROM [returned_tbl]
                                            WHERE GOODS_CODE = '$goodsCode' AND QTY_S_RET > 0
                                            AND ASSY_LINE = '$Assy'
                                            ORDER BY id ASC";
                    $params = array();
                    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                    
                    $sql_select_returned_run = sqlsrv_query( $conn2, $sql_select_returned, $params, $options);
                    $row_count = sqlsrv_num_rows( $sql_select_returned_run );
                
                    while($row_ret = sqlsrv_fetch_array($sql_select_returned_run , SQLSRV_FETCH_ASSOC)) {
                                $checkID =  $row_ret['id'];
                                $checkQTY =  $row_ret['QTY_S_RET'];
                            }
                
                        if($issuedQty> $checkQTY) {
                
                            $sql_update_ret = "UPDATE returned_tbl
                                               SET QTY_S_RET = 0
                                               WHERE id = $checkID";
                            $sql_update_ret_run = sqlsrv_query($conn2, $sql_update_ret);
                        
                        } else {
                                        $issuedQty-=$checkQTY;
                                        $new2 = $issuedQty *-1;
                                        $sql_update_ret = "UPDATE returned_tbl
                                                           SET QTY_S_RET = $new2
                                                           WHERE id = $checkID";
                                        $sql_update_ret_run = sqlsrv_query($conn2, $sql_update_ret);
                
                        }
                
                
                        if($sql_update_ret_run) {
                            $issuedQty-=$checkQTY;
                        }
                }
    //***********************************CODE for deduct qty from returned table  above****************************************
}

}else{
    //******************************CODE for deduct qty from RECEIVE table goes BELOW///////////////////////////////////////////

    // UPDATE TOTAL STOCK and SAVE TRANSACTION FUNCTION
    UPDATE_STOCK_AND_TRANSACTION($conn1, $conn2, $total_stock, $issuedQty, $goodsCode, $itemCode, $partNumber, $partName, $orderNum, $remark, $Assy);


while ($issuedQty > 0) {
    $sql_select_receive = "SELECT TOP 1 * FROM [Receive]
                        WHERE GOODS_CODE = '$goodsCode' AND QTY_S > 0
                        AND ASY_LINE = '$Assy'
                        ORDER BY id ASC";
    $params2 = array();
    $options2 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    
    $sql_select_receive_run = sqlsrv_query( $conn1, $sql_select_receive, $params2, $options2 );
    $row_count2 = sqlsrv_num_rows( $sql_select_receive_run );

    while($row_rec = sqlsrv_fetch_array($sql_select_receive_run, SQLSRV_FETCH_ASSOC)) {
                $checkID2 =  $row_rec['id'];
                $checkQTY2 =  $row_rec['QTY_S'];
            }


        if($issuedQty > $checkQTY2) {

            $sql_update_rec = "UPDATE [Receive]
                               SET QTY_S = 0
                               WHERE id = $checkID2";
            $sql_update_rec_run = sqlsrv_query($conn1, $sql_update_rec);
           
        } else {
      
                        $issuedQty-=$checkQTY2;
                        $new_qty = $issuedQty *-1;
                        $sql_update_rec = "UPDATE [Receive]
                                           SET QTY_S = $new_qty
                                           WHERE id = $checkID2";
                        $sql_update_rec_run = sqlsrv_query($conn1, $sql_update_rec);

        }

        if($sql_update_rec_run) {
            $issuedQty-=$checkQTY2;
        }
}

}
//*************************************CODE for deduct qty from RECEIVE table goes above//////////////////////////////////////////////
   

?>