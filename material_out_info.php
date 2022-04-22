<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Result</title>
    <!-- bootstrap CDN and CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   
    <!--font-awesome CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" type="text/css" href="css/styles.css" />
    <!-- Jquery CDN-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <style>
        
       
        #btn_showReport{
            margin: 0;
            display: none;
        }

        #btnDiv1, #btnDiv2{
            margin: 0;
            padding: 0;
        }
        #submitIssued{
            margin: 0;
        }
        #btnDiv2{
            margin-top: .3rem;
            
        }
    
         th, tr, td {
        font-size: .9rem;
        padding: .5rem !important;
        height: 15px;
        }

        th{
        font-size: .8rem;
        padding: .2rem !important;
        }

        .old_invoice_div{
            max-width: 850px;
            margin: auto;
        }

        #SelectRemark{
            width: 50%;
            border-radius: 25px;
            border: 2px solid white;
            padding: .2rem; 
        }

        @media (max-width:767px){
    
            label{
                width: 7.5rem;
            }
            .c2{
                overflow-x: scroll;
            }
            td{
                font-size: .8rem;
            }
        }
       
       .icon-modal{
           font-weight: 300;
       }
       #totalReturnedValue{
           display: none;
       }

    </style>
</head>
<body>
<form  id="formInfo" method="post">
<?php
$serverName = "192.168.2.15,40001";
$connectionInfo1 = array( "UID" => "iqc_db_user_dev", "PWD" => "iqcdbuserdev", "Database" => "MA_Receiving");
$conn1 = sqlsrv_connect($serverName, $connectionInfo1);

$connectionInfo2 = array( "UID" => "iqc_db_user_dev", "PWD" => "iqcdbuserdev", "Database" => "StockCard");
$conn2 = sqlsrv_connect($serverName, $connectionInfo2);

if( $conn1 === false )
{
echo "Could not connect.\n";
die( print_r( sqlsrv_errors(), true));
}
else {
//    echo "connection established 1";
}

if( $conn2 === false )
{
echo "Could not connect.\n";
die( print_r( sqlsrv_errors(), true));
}
else {
//    echo "connection established 2";
}



if (isset($_POST['codeResult'])) {
    $qrResult = $_POST['codeResult'];



    //QUERY FOR FETCHING RETURNED MATERIALS 
    $sql_total_ret = "SELECT SUM(QTY_S_RET) as total_qty_ret FROM returned_tbl WHERE GOODS_CODE = '$qrResult'";
                     
    $sql_total_ret_run = sqlsrv_query( $conn2, $sql_total_ret );
    while($row_total_ret = sqlsrv_fetch_array($sql_total_ret_run, SQLSRV_FETCH_ASSOC))
    {
       $total_qty_ret = $row_total_ret['total_qty_ret'];

    }



    $sql_select1 = "SELECT * From Total_Stock
    WHERE GOODS_CODE = '$qrResult'or PART_NUMBER = '$qrResult' or ITEM_CODE = '$qrResult' ";
    $sql_select1_run = sqlsrv_query( $conn1, $sql_select1 );

    if( $sql_select1_run === false) {
        die( print_r( sqlsrv_errors(), true) );
    }


    //QUERY to get 
    $sql_part_number = "SELECT PART_NUMBER From [Receive]
    WHERE GOODS_CODE = '$qrResult'or PART_NUMBER = '$qrResult' or ITEM_CODE = '$qrResult' ";
    $sql_part_number_run = sqlsrv_query( $conn1, $sql_part_number );

    while($row_partNumber = sqlsrv_fetch_array($sql_part_number_run, SQLSRV_FETCH_ASSOC))
        {
            $partNumber = $row_partNumber['PART_NUMBER'];
        }
    
    

    if($sql_select1_run){
        while($row = sqlsrv_fetch_array($sql_select1_run, SQLSRV_FETCH_ASSOC))
        {
             
           ?>
           
           <div class="scan-result bg-dark">

            <?php
                //INCLUDE GOODSCODE, ITEMCODE, MATERIALS, PARTNUMBER, TOTALSTOCK, LOCATION FROM HTML FOLDER
                include 'html/materialsInfo.php';
            ?>
            

                <div class="result-container ">
                <label class="text-warning pr-2">Issued QTY</label>
                <input  type="number" min="1" required step="1" onkeypress="return event.keyCode === 8 || event.charCode >= 48 && event.charCode <= 57" id="issuedQty">
                </div>

                <!--hidden input for total returned QTY-->
                <input type="number" readonly class="txtbox bg-secondary text-warning" name="totalReturnedValue" id="totalReturnedValue" value="<?php echo $total_qty_ret?>">
                <!--hidden input for total returned QTY-->

                <div class="result-container ">
                <label class="text-warning pr-2">Order No.</label>
                <input type="text"  autocomplete="off"  class="txtbox" name="orderNum" id="orderNum" value="">
                </div>

                <div class="result-container ">
                <label class="text-warning pr-2">Remarks</label>
                <form action="" method="POST">
                    <select class="text-white bg-primary" name="SelectRemark" id="SelectRemark">
                    <option value="none" class="dropdown-item bg-dark text-white px-5" disabled selected>Select Remark</option>
                    <option value="ISSUED-TO-PRODUCTION" class="dropdown-item bg-primary text-white">ISSUED TO PRODUCTION</option>
                    <option value="SHIP-TO-CUSTOMER" class="dropdown-item text-white" >SHIP TO CUSTOMER</option>
                    <option value="ENGINEERING-EVALUATION" class="dropdown-item text-white" >ENGINEERING EVALUATION</option>
                    <option value="RETURN-TO-SUPPLIER" class="dropdown-item text-white" >RETURN TO SUPPLIER</option>
                    <option value="DISPOSE" class="dropdown-item text-white" >DISPOSE</option>
                    <option value="INCORRECT-INPUT" class="dropdown-item bg-primary text-white">EDIT</option>
                    </select>
                </form>
                </div>
                
                <!--  CODE FOR INVOICE -->
                
                <div class = "old_invoice_div">
                <?php 

                //CHECK ROW-COUNT of INVOICE

                $sql_get_rowcount = "SELECT GOODS_CODE, INVOICE, COUNT(*) as invoice_count
                                    FROM [Receive]
                                    WHERE GOODS_CODE = '$qrResult'
                                    GROUP BY GOODS_CODE, INVOICE HAVING COUNT (*) > 1;";
                

                $params_invoice_count = array();
                $options_invoice_count =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                
                $sql_get_rowcount_run = sqlsrv_query($conn1, $sql_get_rowcount, $params_invoice_count, $options_invoice_count);

                $count_result_invoice = sqlsrv_num_rows( $sql_get_rowcount_run );


                    date_default_timezone_set('Asia/Hong_Kong');  
                    $date = date('m-d-Y H:i:s');

                    $noInfo = "N/A";

                             echo '
                             <div class="c2" id=""><table class="rounded table table-bordered">
                             
                             <thead class="thead bg-secondary">
                                 <tr class="text-white ">
                                 <th scope="col">RECEIVED DATE</th>
                                 <th scope="col">QTY RECEIVED</th>
                                 <th scope="col">INVOICE NO.</th>  
                                     
                                 </tr>
                               </thead>
                             <tbody>';

                    //  //QUERY FOR FETCHING RETURNED MATERIALS FROM PRODUCTION
                    $sql_select_returned = "SELECT * FROM [returned_tbl]
                                            WHERE GOODS_CODE = '$qrResult'
                                            AND QTY_S_RET > 0
                                            ORDER BY id ASC";
                    $params = array();
                    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

                    $sql_select_returned_run = sqlsrv_query( $conn2, $sql_select_returned, $params, $options);
                    $row_count = sqlsrv_num_rows( $sql_select_returned_run );

                    if($sql_select_returned_run && $row_count){

                        while ($row_ret = sqlsrv_fetch_array($sql_select_returned_run , SQLSRV_FETCH_ASSOC)){
                            echo '<tr class="active bg-danger">
                                       <td class="text-white">'.$row_ret['DATE_RECEIVED']->format("m-d-Y").'</td>
                                       <td class="text-white">'.$row_ret['QTY_S_RET'].'</td>
                                       <td class="text-white">'."(RETURNED)".'</td>
                                       </tr>';
                        }
                    }

                     //QUERY FOR FETCHING RECEIVED MATERIALS FROM SUPPLIER
                     $sql_select1 = "SELECT DATE_RECEIVE, GOODS_CODE,INVOICE, SUM(QTY_S) as total_qty 
                     FROM [Receive] 
                     WHERE GOODS_CODE = '$qrResult' AND QTY_S > 0 AND [STATUS] = 'INSPECTED'
                     GROUP BY DATE_RECEIVE, [INVOICE], [GOODS_CODE]";
                     
                     $sql_select1_run = sqlsrv_query( $conn1, $sql_select1 );
                             if(!$sql_select1_run) {
                             die( print_r( sqlsrv_errors(), true) );
                             }else{

                                while($row = sqlsrv_fetch_array($sql_select1_run, SQLSRV_FETCH_ASSOC))
                                {
                                   $total_stock_qtys = $row['total_qty'];
                                 
                                   if ($count_result_invoice> 0){
                                        if ($total_stock_qtys > 0)
                                        {   
                                        
                                            echo '<tr class="active">
                                            <td class="text-white">'.$row['DATE_RECEIVE']->format("m-d-Y").'</td>
                                            <td class="text-white">'.$row['total_qty'].'</td>
                                            <td class="text-white">'.$row['INVOICE'].' '. '<a id="breakdown-btn" data-toggle="modal" data-target="#myModal">
                                            <i class="fa-regular fa-circle-up fa-xl text-white icon-modal"></i></a>' .'</td>
                                            </tr>';
                                            
                                        } 

                                   }else{

                                            echo '<tr class="active">
                                            <td class="text-white">'.$row['DATE_RECEIVE']->format("m-d-Y").'</td>
                                            <td class="text-white">'.$row['total_qty'].'</td>
                                            <td class="text-white">'.$row['INVOICE'].'</td>
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
                        <div class="modal-header">
                            Confirm Details
                        </div>
                        <div class="modal-body">
                            Are you sure you want to save the following details?

                            <!-- We display the details entered by the user here -->
                            <table class="table">
                                <tr>
                                    <th>Issued Quantity :</th>
                                    <td id="" class="text-dark"><input type="text" readonly class="txtbox text-primary" name="issuedQty2" id="issuedQty2" value=""></td>
                                    
                                </tr>
                                <tr>
                                    <th>Order Number :</th>
                                    <td id=""><input type="text" readonly class="txtbox text-primary" name="orderNum2" id="orderNum2" value=""></td>
                                </tr>
                                <tr>
                                    <th>Remarks</th>
                                    <td id=""><input type="text" readonly class="txtbox text-primary" name="remarks" id="remarks" value=""></td>
                                </tr>
                                
                            </table>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button href="#" id="submitIssued" class="btn btn-success success" data-dismiss="modal">Save</button>
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
</body>
</html>


              