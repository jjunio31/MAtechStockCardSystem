<!doctype html> 
<html lang="en">

  <?php 
    include 'html/head.php';
    include 'connections/ma_receiving_conn.php'; 
    include 'connections/stock_card_conn.php';
  ?>
  
  <body>

  <?php

if (!empty($_POST["goodsCode"])){ 
    $goodsCode = $_POST['goodsCode']; 
}
if (!empty($_POST["itemCode"])){
     $itemCode = $_POST['itemCode']; 
}

if (!empty($_POST["Assy"])){
  $Assy = $_POST['Assy']; 
}

$currentYear = date("Y");
$currentMonth = date("m");
$endDay = '';

switch ($currentMonth){
    case '01': 
    case '03':
    case '05':
    case '07':
    case '08':
    case '10':
    case '12':
      $endDay = '31';
      break;
    case '04':
    case '06':
    case '09':  
    case '11':
      $endDay = '30';
      break;
    case '02':
      $endDay = '28';
      break;
  }


    $sql_select1 = "SELECT * FROM transaction_record_tbl WHERE GOODS_CODE = '$goodsCode' AND ASSY_LINE = '$Assy'
    AND TRANSACTION_DATE BETWEEN '$currentYear/$currentMonth/01 00:00:00' AND '$currentYear/$currentMonth/$endDay 23:59:59'
    ORDER BY id DESC;";


    $sql_select1_run = sqlsrv_query( $conn2, $sql_select1 );
    
            if( $sql_select1_run  === false) {
            die( print_r( sqlsrv_errors(), true) );
            }
            
            $date = date('M d, Y');
            echo '<div class="bg-dark rounded py-1"><h3 class="text-center text-warning">Transaction Report</h3></div>
            <div class="c2" id=""><table class="table table-bordered" id="reportsTable">
            
            <thead class="thead-dark">
                <tr>
                <th >DATE</th>
                <th >RECEIVED</th>
                <th >ISSUED</th>
                <th >STOCK</th>
                <th >INVOICE #</th>
                <th >ORDER #</th>
                <th >REMARKS</th>
                <th >ASSY LINE</th>
                
                </tr>
              </thead>
            
            <tbody>';
            if($sql_select1_run)
            {
                while($row = sqlsrv_fetch_array($sql_select1_run, SQLSRV_FETCH_ASSOC))
                {
                    
                    if($row['TRANSACTION_DATE']->format("m") == $currentMonth)
                    {

                    
                    echo '<tr class="active text-white">
                                      <td class="align-middle rowDate color">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                      <td class="align-middle color">'.$row['QTY_RECEIVED'].'</td>
                                      <td class="align-middle color">'.$row['QTY_ISSUED'].'</td>
                                      <td class="align-middle color">'.$row['TOTAL_STOCK'].'</td>
                                      <td class="align-middle rowInvoice color">'.$row['INVOICE_KIT'].'</td>
                                      <td class="align-middle rowOrder color">'.$row['ORDER_NO'].'</td>
                                      <td class="align-middle rowRemarks color">'.$row['REMARKS'].'</td>
                                      <td class="align-middle rowRemarks color">'.$row['ASSY_LINE'].'</td>
                          </tr>';

                    }
                }


            }               
          
        echo '</tbody></table></div>';
    
        

            sqlsrv_free_stmt( $sql_select1_run);

    
        ?>
         
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/table_bg_color.js"></script>
  </body>
</html>
 


