<!DOCTYPE html>
<html lang="en">
<?php 
    include 'html/head.php';
    include 'connections/ma_receiving_conn.php'; 
    // include 'connections/stock_card_conn.php';
?>
<body>
    
<?php

if(isset($_POST['AssybuttonVal'])){
    $AssybuttonVal = $_POST['AssybuttonVal'];
}


if (isset($_POST['codeResult'])) {
    $qrResult = $_POST['codeResult'];


    $sql_part_number = "SELECT PART_NUMBER From MS21_MASTER_LIST
    WHERE GOODS_CODE = '$qrResult' or PART_NUMBER = '$qrResult' or ITEM_CODE = '$qrResult' ";
    $sql_part_number_run = sqlsrv_query( $conn1, $sql_part_number );

    while($row_partNumber = sqlsrv_fetch_array($sql_part_number_run, SQLSRV_FETCH_ASSOC))
        {
            $partNumber = $row_partNumber['PART_NUMBER'];
        }

    //Count Row of Assy
    $sql_select_assy = "SELECT ASSY_LINE 
                        FROM Total_Stock
                        WHERE GOODS_CODE = '$qrResult'";
    $paramsAssy = array();
    $optionsAssy =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $stmtAssy = sqlsrv_query( $conn1, $sql_select_assy, $paramsAssy, $optionsAssy );
    $row_count_Assy = sqlsrv_num_rows($stmtAssy);

    if($row_count_Assy > 1){
        $sql_select = "SELECT * From Total_Stock
        WHERE GOODS_CODE = '$qrResult'
        AND ASSY_LINE = '$AssybuttonVal'";
        $sql_select_run = sqlsrv_query( $conn1, $sql_select );
    }else{
        $sql_select = "SELECT * From Total_Stock
        WHERE GOODS_CODE = '$qrResult'";
        $sql_select_run = sqlsrv_query( $conn1, $sql_select );
    }
  

    if( $sql_select_run === false) {
        die( print_r( sqlsrv_errors(), true) );
    }

    if($sql_select_run)
    {
        while($row = sqlsrv_fetch_array($sql_select_run, SQLSRV_FETCH_ASSOC))
        {
            
           ?>
           <form  id="formInfo" method="post">
           <div class="scan-result bg-dark">

            <?php 
                include 'html/materialsInfo.php';
            ?>

                <div class="result-container ">
                <label class="">Month</label>
                <form action="" method="POST">
                    <select class="text-white bg-primary" name="SelectMonth" id="SelectMonth">
                    <option value="none" disabled selected class="dropdown-item bg-dark text-primary px-5">Select Month</option>
                    <option value="01" id="1" class="dropdown-item bg-primary text-white">January</option>
                    <option value="02" class="dropdown-item text-white" style="background-color: #8a2be2">February</option>
                    <option value="03" class="dropdown-item text-white" style="background-color: #FF6347">March</option>
                    <option value="04" class="dropdown-item text-white bg-secondary">April</option>
                    <option value="05" class="dropdown-item text-white bg-success">May</option>
                    <option value="06" class="dropdown-item text-white bg-dark" >June</option>
                    <option value="07" class="dropdown-item text-white" style="background-color: #FFC0CB">July</option>
                    <option value="08" class="dropdown-item text-white" style="background-color: #964B00">August</option>
                    <option value="09" class="dropdown-item text-white bg-warning">September</option>
                    <option value="10" class="dropdown-item text-white" style="background-color: #ADD8E6">October</option>
                    <option value="11" class="dropdown-item text-dark bg-white" >November</option>
                    <option value="12" class="dropdown-item text-white bg-danger">December</option>
                    <option value="all" class="dropdown-item text-white bg-secondary">All Transactions</option>
                    </select>
                </form>
                </div>

                
         
            </div>
            </form> 
           <?php
        }
    }
    else
    {
        echo $qrResult . " Not Found";
    }
      
}
 ?>

<script src="js/reports.js"></script>
<script src="js/reports_month.js"></script>

<script>
    $(document).ready(function () {
        var d = new Date(),
        n = '0' + (d.getMonth()+1);

        $('#SelectMonth option:eq('+n+')').prop('selected', true);

    });

</script>
</body>
</html>


  

    