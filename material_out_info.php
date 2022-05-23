<!DOCTYPE html>
<html lang="en">

<?php 
    include 'html/head.php';
    include 'connections/ma_receiving_conn.php'; 
    include 'connections/stock_card_conn.php';
  ?>

<body>
<form  id="formInfo" method="post">

<?php

if(isset($_POST['AssybuttonVal'])){
    $AssybuttonVal = $_POST['AssybuttonVal'];
    
}

if (isset($_POST['codeResult'])) {
    $qrResult = $_POST['codeResult'];

    // $qrResult = 'RE0-00056';



    //QUERY FOR FETCHING RETURNED MATERIALS 
    $sql_total_ret = "SELECT SUM(QTY_S_RET) 
                      as total_qty_ret 
                      FROM returned_tbl 
                      WHERE GOODS_CODE = '$qrResult'";
                     
    $sql_total_ret_run = sqlsrv_query( $conn2, $sql_total_ret );
        while($row_total_ret = sqlsrv_fetch_array($sql_total_ret_run, SQLSRV_FETCH_ASSOC))
        {
        $total_qty_ret = $row_total_ret['total_qty_ret'];

        }

    $sql_part_number = "SELECT PART_NUMBER From MS21_MASTER_LIST
                        WHERE GOODS_CODE = '$qrResult'
                        or PART_NUMBER = '$qrResult' 
                        or ITEM_CODE = '$qrResult' ";
    $sql_part_number_run = sqlsrv_query( $conn1, $sql_part_number );

    while($row_partNumber = sqlsrv_fetch_array($sql_part_number_run, SQLSRV_FETCH_ASSOC))
        {
            $partNumber = $row_partNumber['PART_NUMBER'];
        }
   
        $sql_select = "SELECT * From Total_Stock
        WHERE GOODS_CODE = '$qrResult'
        AND ASSY_LINE = '$AssybuttonVal';";
        $sql_select1_run = sqlsrv_query( $conn1, $sql_select );
    

    
    if( $sql_select1_run === false) {
        die( print_r( sqlsrv_errors(), true) );
    }


    if($sql_select1_run){ 
        while($row = sqlsrv_fetch_array($sql_select1_run, SQLSRV_FETCH_ASSOC))
        {
            
           ?>
           
           <div class="scan-result bg-dark">
 
           <?php 
                include 'html/materialsInfo.php';
            ?>

                <div class="result-container ">
                <label class="">Issued QTY</label>
                <input  type="number" min="1" required step="1" onkeypress="return event.keyCode === 8 || event.charCode >= 48 && event.charCode <= 57" id="issuedQty">
                </div>

                <!--hidden input for total returned QTY-->
                <input type="text" readonly class="txtbox bg-secondary text-warning" name="totalReturnedValue" id="totalReturnedValue" value="<?php echo $total_qty_ret?>">
                <!--hidden input for total returned QTY-->

                <div class="result-container ">
                <label class="">Order No.</label>
                <input type="text"  autocomplete="off"  class="txtbox" name="orderNum" id="orderNum" value="">
                </div>

                <div class="result-container ">
                <label class="">Remarks</label>
                <form action="" method="POST">
                    <select class="text-white bg-primary" name="SelectRemark" id="SelectRemark">
                    <option value="ISSUED-TO-PRODUCTION" class="dropdown-item bg-primary text-white" selected>ISSUED TO PRODUCTION</option>
                    <option value="SHIP-TO-CUSTOMER" class="dropdown-item text-white" >SHIP TO CUSTOMER</option>
                    <option value="ENGINEERING-EVALUATION" class="dropdown-item text-white" >ENGINEERING EVALUATION</option>
                    <option value="RETURN-TO-SUPPLIER" class="dropdown-item text-white" >RETURN TO SUPPLIER</option>
                    <option value="DISPOSE" class="dropdown-item text-white" >DISPOSE</option>
                    <option value="EDIT" class="dropdown-item bg-primary text-white">EDIT</option>
                    </select>
                </form>
                </div>

                
                <!--  CODE FOR INVOICE -->
                
                <div class = "old_invoice_div">
                <?php 

                //CHECK ROW-COUNT of INVOICE FIFO

                $sql_get_rowcount = "SELECT GOODS_CODE, INVOICE, COUNT(*) as invoice_count
                                    FROM [Receive]
                                    WHERE GOODS_CODE = '$qrResult'
                                    AND [STATUS] = 'INSPECTED'
                                    GROUP BY GOODS_CODE, INVOICE HAVING COUNT (*) > 1;";

                $params_invoice_count = array();
                $options_invoice_count =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                
                $sql_get_rowcount_run = sqlsrv_query($conn1, $sql_get_rowcount, $params_invoice_count, $options_invoice_count);

                $count_result_invoice = sqlsrv_num_rows( $sql_get_rowcount_run );


                date_default_timezone_set('Asia/Hong_Kong');  
                $date = date('m-d-Y H:i:s');
                   
                    $noInfo = "N/A";

                             echo '
                             <div class="" id=""><table class="rounded table table-bordered">
                             
                             <thead class="thead bg-secondary">
                                 <tr class="text-white align-middle">
                                 <th >RECEIVED DATE</th>
                                 <th >QTY RECEIVED</th>
                                 <th >INVOICE NO.</th>  
                                 </tr>
                               </thead>
                             <tbody>';

                    //QUERY FOR FETCHING RETURNED MATERIALS FROM PRODUCTION
                    $sql_select_returned = "SELECT * FROM [returned_tbl]
                                            WHERE GOODS_CODE = '$qrResult'
                                            AND QTY_S_RET > 0
                                            ORDER BY id ASC";
                    $params = array();
                    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

                    $sql_select_returned_run = sqlsrv_query( $conn2, $sql_select_returned, $params, $options);
                    $row_count = sqlsrv_num_rows( $sql_select_returned_run );

                    if($sql_select_returned_run && $row_count){
                        date_default_timezone_set('Asia/Hong_Kong');  
                        $date = date('m-d-Y H:i:s');

                        while ($row_ret = sqlsrv_fetch_array($sql_select_returned_run , SQLSRV_FETCH_ASSOC)){
                            echo '<tr class="active bg-danger">
                                       <td class="text-white align-middle rowDate">'.$row_ret['DATE_RECEIVED']->format("m-d-Y").'</td>
                                       <td class="text-white align-middle">'.$row_ret['QTY_S_RET'].'</td>
                                       <td class="text-white align-middle rowInvoice">'."(RETURNED)".'</td>
                                  </tr>';
                        }
                    }

                     //QUERY FOR FETCHING RECEIVED MATERIALS FROM SUPPLIER
                     $sql_select_total_qty = "SELECT DATE_RECEIVE, GOODS_CODE, INVOICE, SUM(QTY_S) as total_qty 
                                              FROM [Receive] 
                                              WHERE GOODS_CODE = '$qrResult' AND QTY_S > 0 
                                              AND [STATUS] = 'INSPECTED'
                                              AND ASY_LINE  = '$AssybuttonVal'
                                              GROUP BY DATE_RECEIVE, [INVOICE], [GOODS_CODE]";
                     
                     $sql_select_total_qty_run = sqlsrv_query( $conn1, $sql_select_total_qty );
                             if(!$sql_select_total_qty_run) {
                             die( print_r( sqlsrv_errors(), true) );
                             }else{

                                while($row = sqlsrv_fetch_array($sql_select_total_qty_run, SQLSRV_FETCH_ASSOC))
                                {
                                   $total_stock_qtys = $row['total_qty'];
                                 
                                   if ($count_result_invoice> 0){
                                        if ($total_stock_qtys > 0)
                                        {   
                                        
                                            echo '<tr class="active">
                                            <td class="text-white align-middle rowDate">'.$row['DATE_RECEIVE']->format("m-d-Y").'</td>
                                            <td class="text-white align-middle">'.$row['total_qty'].'</td>
                                            <td class="text-white align-middle rowInvoice">'.$row['INVOICE'].' '. '<a id="breakdown-btn" style="display: none;" data-toggle="modal" data-target="#myModal">
                                            <i class="fa-regular fa-circle-up fa-xl text-white icon-modal"></i></a>' .'</td>
                                            </tr>';
                                            
                                        } 

                                   }else{

                                            echo '<tr class="active">
                                            <td class="text-white align-middle rowDate">'.$row['DATE_RECEIVE']->format("m-d-Y").'</td>
                                            <td class="text-white align-middle">'.$row['total_qty'].'</td>
                                            <td class="text-white align-middle rowInvoice">'.$row['INVOICE'].'</td>
                                            </tr>';
                                        
                                   }
                                     
                                }
                            }               
                             echo '</tbody></table></div>';
                             

                ?>
                </div>
              
            
                <div class="result-container d-flex justify-content-center"> 
                <h6 id="messageDisplay" class="text-warning text-center"></h6>
                </div>

                <div class="result-container d-flex justify-content-center" id="modalbtn">
                <input type="button" name="submit" value="SAVE DATA" id="submitBtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-primary btn-block control" />
                </div>

                <div class="result-container d-flex justify-content-center" id="btnDiv2">
                <button type="submit" class="btn btn-primary btn-block control" id="btn_showReport">Show Transactions</button>
                </div>


                <!-- MODAL CONFIRM SAVE-->
                <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header h5">
                            Confirm Details
                        </div>
                        <div class="modal-body">
                            Are you sure you want to save the following details?

                            <!-- We display the details entered by the user here -->
                            <table class="table-bordered">
                                <tr>
                                    <th class="check-info-label-modal">Issued Quantity :</th>
                                    <td id="typed-info" class="text-dark"><input type="text" readonly class="txtbox text-primary" name="issuedQty2" id="issuedQty2" value=""></td>
                                </tr>
                                <tr>
                                    <th class="check-info-label-modal">Order Number :</th>
                                    <td id="typed-info"><input type="text" readonly class="txtbox text-primary" name="orderNum2" id="orderNum2" value=""></td>
                                </tr>
                                <tr>
                                    <th class="check-info-label-modal">Remarks :</th>
                                    <td id="typed-info"><input type="text" readonly class="txtbox text-primary" name="remarks" id="remarks" value=""></td>
                                </tr>
                                
                            </table>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button href="#" id="submitIssued" class="btn btn-primary success" data-dismiss="modal">Save</button>
                        </div>
                    </div>
                </div>
                </div>
                <!-- END MODAL CONFIRM SAVE-->


                
                <!--  MODAL CHECK INVOICE BREAKDOWN TABLE-->

                        <div class="container bg-dark">
                         
                        <!-- The Modal -->
                        <div class="modal" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h6 class="modal-title">Quantity Breakdown</h6>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body bg-dark" id="breakdownDiv">
                                
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                            </div>

                            </div>
                        </div>
                        </div>
                        </div>

                <!--  END MODAL CHECK INVOICE BREAKDOWN TABLE-->
            
            </div>
            
           <?php
        } 
    }
    else
    {
        echo $qrResult . " Not Found";
    }

}

?>
</form>

<script src="js/ajax_mat_out.js"></script>
<script>
      //AJAX FOR MODAL BREAKDOWN
  $(document).ready(function () {
    $("#breakdown-btn").click(function (e) { 
        e.preventDefault();

        var qrResult = $('input[id=goodsCode]').val();
        $.ajax({
            type: "post",
            url: "modal_breakdown.php",
            data: {qrResult:qrResult},
            dataType: "text",
            success: function (response) {
                
                $('#breakdownDiv').html(response);
            }
        });
    });
  });
      

</script>
</body>
</html>


              