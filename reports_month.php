<!doctype html> 
<html lang="en">

  <?php 
    //INCLUDE HEADERS FROM HTML FOLDER
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

// Conn for StockCard
$connectionInfo2 = array( "UID" => "iqc_db_user_dev", "PWD" => "iqcdbuserdev", "Database" => "StockCard");
$conn2 = sqlsrv_connect($serverName, $connectionInfo2);

if( $conn2 === false )
{
echo "Could not connect.\n";
die( print_r( sqlsrv_errors(), true));
}


if (!empty($_POST['codeResult']))
{ 
  $codeResult = $_POST['codeResult'];
}

if (!empty($_POST['n']))
{ 
  $currentMonth_Default = $_POST['n']; 
  $currentMonthDefault = (int) $currentMonth_Default;
}



if (!empty($_POST["selectedMonth"]))
{ 
    $selectedMonth = $_POST['selectedMonth']; 
}
//
if (empty($_POST["selectedMonth"]))
{ 
    $selectedMonth = $currentMonthDefault;
}else{
  $selectedMonth = $_POST['selectedMonth']; 
}
//

if (!empty($_POST["goodsCode"]))
{ 
  $goodsCode = $_POST['goodsCode']; 
}
//
if (empty($_POST["goodsCode"]))
{ 
  $goodsCode = $codeResult;
}else{
  $goodsCode = $_POST["goodsCode"];
}
//


if (!empty($_POST["itemCode"]))
{ 
  $itemCode = $_POST['itemCode']; 
}


if (!empty($_POST["partNumber"]))
{ 
  $partNumber = $_POST['partNumber']; 
}




echo '<div class="table_reports bg-light">';
$date = date('M d, Y');

    echo '<h3 class="text-center text-white bg-dark rounded py-1">Transaction Report</h3>
    <div class="c2" id=""><table class="table table-bordered .w-auto" id="reportsTable">
    <thead></thead>
    <thead class="thead bg-dark py-1">
        <tr class="text-white">
        <th class="">DATE</th>
        <th class="">RECEIVED</th>
        <th class="">ISSUED</th>
        <th class="">STOCK</th>
        <th class="">INVOICE #</th>
        <th class="">ORDER #</th>
        <th class="">REMARKS</th>
        </tr>
      </thead>
    <tbody>';

    
$currentYear = date("Y");
$endDay = '';

switch ($selectedMonth){
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

if ($selectedMonth == "all"){

  $sql_select1 = "SELECT * FROM transaction_record_tbl WHERE GOODS_CODE = '$goodsCode'
  ORDER BY id ASC;";

    $sql_select1_run = sqlsrv_query($conn2, $sql_select1);

    if($sql_select1_run === false)
    {
      die( print_r( sqlsrv_errors(), true));
    }

    else
    {
      while($row = sqlsrv_fetch_array($sql_select1_run, SQLSRV_FETCH_ASSOC))
      {

        echo '<tr class="active text-white">
        <td class="align-middle rowDate color">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
        <td class="align-middle color">'.$row['QTY_RECEIVED'].'</td>
        <td class="align-middle color">'.$row['QTY_ISSUED'].'</td>
        <td class="align-middle color">'.$row['TOTAL_STOCK'].'</td>
        <td class="align-middle rowInvoice color">'.$row['INVOICE_KIT'].'</td>
        <td class="align-middle rowOrder color">'.$row['ORDER_NO'].'</td>
        <td class="align-middle rowRemarks color">'.$row['REMARKS'].'</td>
        </tr>';
      }
    }


}else {

  $sql_select1 = "SELECT * FROM transaction_record_tbl WHERE GOODS_CODE = '$goodsCode'
  AND TRANSACTION_DATE BETWEEN '$currentYear/$selectedMonth/01 00:00:00' AND '$currentYear/$selectedMonth/$endDay 23:59:59'
  ORDER BY id ASC;";

    $sql_select1_run = sqlsrv_query($conn2, $sql_select1);

    if($sql_select1_run === false)
    {
      die( print_r( sqlsrv_errors(), true));
    }

    else
    {
      while($row = sqlsrv_fetch_array($sql_select1_run, SQLSRV_FETCH_ASSOC))
      {

        echo '<tr class="active text-white">
        <td class="align-middle rowDate color">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
        <td class="align-middle color">'.$row['QTY_RECEIVED'].'</td>
        <td class="align-middle color">'.$row['QTY_ISSUED'].'</td>
        <td class="align-middle color">'.$row['TOTAL_STOCK'].'</td>
        <td class="align-middle rowInvoice color">'.$row['INVOICE_KIT'].'</td>
        <td class="align-middle rowOrder color">'.$row['ORDER_NO'].'</td>
        <td class="align-middle rowRemarks color">'.$row['REMARKS'].'</td>
        </tr>';
      }
    }

}

  echo '</tbody></table></div>';
  echo '</div>';
  
?>



    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/table_bg_color.js"></script>
  </body>
</html>
