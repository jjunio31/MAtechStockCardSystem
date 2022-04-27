<!DOCTYPE html>
<html lang="en">

  <?php   
    include 'html/head.php';
  ?>
  
<body>

<?php 

$serverName = "192.168.2.15,40001";
$connectionInfo1 = array( "UID" => "iqc_db_user_dev", "PWD" => "iqcdbuserdev", "Database" => "MA_Receiving");
$conn1 = sqlsrv_connect($serverName, $connectionInfo1);

if( $conn1 === false )
{
echo "Could not connect.\n";
die( print_r( sqlsrv_errors(), true));
}
else {
//    echo "connection established 1";
}

// DATA FROM AJAX--
if (!empty($_POST["qrResult"])){ $qrResult = $_POST['qrResult']; }


//QUERY FOR FETCHING RECEIVED MATERIALS FROM SUPPLIER
$sql_select1 = "SELECT DATE_RECEIVE, GOODS_CODE,INVOICE, SUM(QTY_S) as total_qty 
FROM [Receive] 
WHERE GOODS_CODE = '$qrResult' AND QTY_S > 0 
GROUP BY DATE_RECEIVE, [INVOICE], [GOODS_CODE]";
   
 $sql_select1_run = sqlsrv_query( $conn1, $sql_select1 );
        if(!$sql_select1_run) {
         die( print_r( sqlsrv_errors(), true) );
         }else{

            while($row = sqlsrv_fetch_array($sql_select1_run, SQLSRV_FETCH_ASSOC))
              {
                 $total_stock_qtys = $row['total_qty'];
             }
         }



$sql_get_rowcount = "SELECT * FROM dbo.[Receive] 
                     WHERE GOODS_CODE = '$qrResult' AND [STATUS] = 'INSPECTED'
                     ORDER BY id ASC";
                $params_row_count = array();
                $options_row_count  =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                $stmt_row_count =  sqlsrv_query($conn1, $sql_get_rowcount, $params_row_count, $options_row_count);
                $result_row_count = sqlsrv_num_rows( $stmt_row_count );

                echo '<h5 class="text-white">'.'GoodsCode:' .' '.$qrResult.'</h5>';
                echo '

                             <div class="" id=""><table class="rounded table table-bordered">
                             
                             <thead class="thead">
                                 <tr class="text-white">
                                 <th scope="col">Invoice #</th> 
                                 <th scope="col">Received</th>
                                 <th scope="col">Remaining</th>
                                 </tr>
                               </thead>
                             <tbody>';

                             while ($row_ret = sqlsrv_fetch_array($stmt_row_count , SQLSRV_FETCH_ASSOC)){
                                echo '<tr class="">
                                           <td class="text-white">'.$row_ret['INVOICE'].'</td>
                                           <td class="text-white">'.$row_ret['QTY'].'</td>
                                           <td class="text-white">'.$row_ret['QTY_S'].'</td>
                                           </tr>';
                            }

                            echo '<tr class="">
                                           <td colspan= "3" class="text-white text-center">'.'Total Remaining:'. ' ' .$total_stock_qtys.'</td>
                                           </tr>';
                            


                echo        '</div>';

?>

    
</body>
</html>


