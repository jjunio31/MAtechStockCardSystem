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

        //hidden table 
        // $sql_99 = "SELECT * FROM [Receive]
        //                 WHERE GOODS_CODE = '$goodsCode' or ITEM_CODE = '$itemCode' 
        //                 ORDER BY id";

        // $sql_99_run = sqlsrv_query( $conn1, $sql_99);

        // if ($sql_99_run){
        //     while($row = sqlsrv_fetch_array($sql_99_run , SQLSRV_FETCH_ASSOC))
        //     {
        //                         echo '  <table>
        //                                 <tr class="active">
        //                                 <td class="text-white">'.$row['id'].'</td>
        //                                 <td class="text-white">'.$row['DATE_RECEIVE']->format("m-d-Y (h:i:sa)").'</td>
        //                                 <td class="text-white">'.$row['QTY'].'</td>
        //                                 <td class="text-white">'.$row['INVOICE'].'</td>
        //                                 </tr>
        //                             </table>';
        //     }
        // }


                                        

        //hidden table 

        //SET count of goodscode that has the same invoice 
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

//UPDATE TOTAL STOCK
if ($total_stock <  $issuedQty){
    echo 'Unable to process request. Not enough stock';

}else {

    if($sql_select_stock_run && $sql_select1_run)
    {
    
        if ($issuedQty < $total_stock)
        {
            $new_total_stock = $total_stock - $issuedQty;
    
            $sql_update= "UPDATE Total_Stock set TOTAL_STOCK = $new_total_stock
                          WHERE GOODS_CODE = '$goodsCode' or ITEM_CODE = '$itemCode'";
            $sql_update_run = sqlsrv_query($conn1, $sql_update);
                            if($sql_update_run)
                            {
                                echo "Total Stock is updated to $new_total_stock.\n";
                                
                            }else
                            {
                                die( print_r( sqlsrv_errors(), true) );
                            }  



                            ////
    
                            $query = "SELECT * FROM [MA_Receiving].[dbo].[Receive]

                            WHERE GOODS_CODE = '$goodsCode' ORDER BY DATE_RECEIVE ASC";
                
                            $result = sqlsrv_query($conn1, $query);
                
                       
                
                            $result_number = 0;
                
                       
                
                            while($rows=sqlsrv_fetch_array($result)){
                
                
                
                                $checkid = $rows['id'];
                
                       
                
                                if($issuedQty > $rows['QTY_S']){
                
                
                
                                    $tsql = "UPDATE [Receive]
                
                                    SET QTY_S = '0' WHERE id = '$checkid'";
                
                
                
                                    $stmt2 = sqlsrv_query( $conn1, $tsql);
                
                
                
                                    if($stmt2){
                
                                        // echo ' NOICE ';
                
                                        $issuedQty = $issuedQty - $rows['QTY_S'] ;
                
                                    }
                
                
                
                                }
                
                
                
                                else{
                
                
                
                                    $NEW = $issuedQty - $rows['QTY_S'] ;
                
                
                
                                    $BASTA = $NEW * -1;
                
                
                
                                    $tsql = "UPDATE [Receive]
                
                                    SET QTY_S = '$BASTA'
                
                                    WHERE id = '$checkid'";
                
                
                
                                    $stmt2 = sqlsrv_query( $conn1, $tsql);
                
                
                
                                    if($stmt2){
                
                                        echo ' NOICE ';
                
                                    }
                
                                }
                
                       
                
                            }
            
    
        }           
    // }         
     

    
  
    
    
    
    
                    
                // // update query for qtys 
    
    
                
                // $sql_update_qtys = "UPDATE [Receive] set QTY_S = $new_qtys
                // WHERE GOODS_CODE = '$goodsCode' AND INVOICE = '$earliest_invoice' AND id = '$earliest_id' ";
                // $sql_update_qtys_run= sqlsrv_query($conn1, $sql_update_qtys);
                //     if($sql_update_qtys_run === false){
                //         die( print_r( sqlsrv_errors(), true) );
                //     } else{
                //         echo  $earliest_invoice ." " . "stock is updated to" . " " . $new_qtys;
                //     }
    
                
                // QUERY to update transaction report
                date_default_timezone_set('Asia/Hong_Kong');  
                $date = date('m-d-Y H:i:s');
        
                $sql_insert = "INSERT INTO transaction_record_tbl (TRANSACTION_DATE, GOODS_CODE, QTY_ISSUED, TOTAL_STOCK, PART_NUMBER, PART_NAME, ORDER_NO) 
                VALUES (?, ?, ?, ?, ?, ?, ?) ";
                $params1 = array($date, $goodsCode, $issuedQty, $new_total_stock, $partNumber, $partName, $orderNum );
                $sql_insert_run = sqlsrv_query($conn2, $sql_insert, $params1);
        
                if( $sql_insert_run === false) {
                     echo 'Unable to process transaction' . die( print_r( sqlsrv_errors(), true) );
                }
            }
           

    
}



//END of if($sql_select_run && $sql_select_stock_run)
// }else{
//     die( print_r( sqlsrv_errors(), true) );
// }

?>