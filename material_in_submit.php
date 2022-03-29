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
//    echo "connection established";
}

if (!empty($_POST["goodsCode"])){ $goodsCode = $_POST['goodsCode']; }
if (!empty($_POST["itemCode"])){ $itemCode = $_POST['itemCode']; }
if (!empty($_POST["partName"])){ $partName = $_POST['partName']; }
if (!empty($_POST["partNumber"])){ $partNumber = $_POST['partNumber']; }
if (!empty($_POST["returnedqty"])){ $returnedqty = $_POST['returnedqty']; }
if (!empty($_POST["reason"])){ $reason = $_POST['reason']; }

    date_default_timezone_set('Asia/Hong_Kong'); 
    $date = date('m-d-Y H:i:s');
                
                $sql_select_returned = "SELECT * FROM returned_tbl";
                $params = array();
                $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                $stmt = sqlsrv_query( $conn, $sql_select_returned , $params, $options);
                $row_count = sqlsrv_num_rows( $stmt );
                $currentRow = $row_count + 1;

                if($sql_select_returned){
                   
                   $sql_insert = "INSERT INTO returned_tbl (id, DATE_RECEIVED, GOODS_CODE, ITEM_CODE, PART_NAME, PART_NUMBER, QTY_RECEIVED, REASON) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    $params1 = array($currentRow, $date, $goodsCode, $itemCode, $partName, $partNumber, $returnedqty, $reason);

                    $sql_insert_run = sqlsrv_query($conn, $sql_insert, $params1);

                    if($sql_insert_run){
                        echo "Successfully Saved";
                    }else{
                        die( print_r( sqlsrv_errors(), true) );
                    }
                }

?> 




