<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Result</title>
    <!-- bootstrap CDN and CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
    <!-- Font AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 
    <!-- Jquery CDN-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

  
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

        @media (max-width:767px){
    
            label{
            width: 7.5rem;
            }
        }

        #SelectRemark{
            width: 50%;
            border-radius: 25px;
            border: 2px solid white;
            padding: .2rem; 
        }
  
        
    </style>
<link rel="stylesheet" type="text/css" href="css/styles.css" />
</head>
<body>
    
<form  id="formInfo" method="post">
<?php
$serverName = "192.168.2.15,40001";
$connectionInfo = array( "UID" => "iqc_db_user_dev", "PWD" => "iqcdbuserdev", "Database" => "MA_Receiving");
$conn = sqlsrv_connect($serverName, $connectionInfo);

if( $conn === false )
{
echo "Could not connect.\n";
die( print_r( sqlsrv_errors(), true));
}

if (isset($_POST['codeResult'])) {
    $qrResult = $_POST['codeResult'];}
    
    $sql_select1 = "SELECT * From Total_Stock
    WHERE GOODS_CODE = '$qrResult'or PART_NUMBER = '$qrResult' or ITEM_CODE = '$qrResult'";
    $sql_select1_run = sqlsrv_query( $conn, $sql_select1 );
    

    if( $sql_select1_run === false) {
        die( print_r( sqlsrv_errors(), true) );
    }


    if($sql_select1_run){
        while($row = sqlsrv_fetch_array($sql_select1_run, SQLSRV_FETCH_ASSOC))
        {
            
           ?>
           
           <div class="scan-result bg-dark">

           <div class="result-container ">
                <label class="text-warning label">Goods Code</label>
                <input type="text" readonly class="txtbox bg-secondary text-warning" name="goodscode" id="goodsCode" value="<?php echo $row['GOODS_CODE']?>">
                </div>
               
                <div class="result-container ">
                <label class="text-warning label">Item Code</label>
                <input type="text" readonly class="txtbox bg-secondary text-warning" name="itemCode" id="itemCode" value="<?php echo $row['ITEM_CODE']?>">
                </div>

                <div class="result-container ">
                <label class="text-warning pr-2">Part Name</label>
                <input type="text" readonly class="txtbox bg-secondary text-warning" name="partName" id="partName" value="<?php echo $row['MATERIALS']?>">
                </div>

                <div class="result-container ">
                <label class="text-warning pr-2">Part Number</label>
                <input type="text" readonly class="txtbox bg-secondary text-warning" name="partNumber" id="partNumber" value="<?php echo $row['PART_NUMBER']?>">
                </div>

                <div class="result-container ">
                <label class="text-warning pr-2">Total Stock</label>
                <input type="number" readonly class="txtbox bg-secondary text-warning" name="currentQty" id="currentQty" value="<?php echo $row['TOTAL_STOCK']?>">
                </div>

                <!-- <div class="result-container ">
                <label class="text-warning pr-2">Location</label>
                <input type="text" readonly class="txtbox bg-secondary text-warning" name="location" id="location" value="<?php echo $row['LOC']?>">
                </div> -->

                <div class="result-container ">
                <label class="text-warning pr-2">Returned QTY</label>
                <input  type="number" min="1" required step="1" onkeypress="return event.keyCode === 8 || event.charCode >= 48 && event.charCode <= 57" name = "returnedqty" id="returnedqty">
                </div>

                <!-- <div class="result-container ">
                <label class="text-warning pr-2">Invoice No.</label>
                <input type="text"  autocomplete="off" class="txtbox" name="invoice" id="invoice" value="">
                </div> -->

                <div class="result-container ">
                <label class="text-warning pr-2">Remarks</label>
                <form action="" method="POST">
                    <select class="text-white bg-primary" name="SelectRemark" id="SelectRemark">
                    <option value="none" class="dropdown-item bg-primary text-white px-5" disabled selected>Select Remark</option>
                    <option value="NON-MOVING" class="dropdown-item text-white" >NON-MOVING</option>
                    <option value="RETURN-TO-SUPPLIER" class="dropdown-item bg-primary text-white">RETURN TO SUPPLIER</option>
                    </select>
                </form>
                </div>
                
                <div class="result-container d-flex justify-content-center"> 
                <h6 id="messageDisplay" class="text-warning"></h6>
                </div>

                <!-- <div class="result-container d-flex justify-content-center" id="btnDiv1">
                <button type="submit" class="btn btn-primary btn-block control" id="saveBTN">Save Data</button>
                </div> -->

                <div class="result-container d-flex justify-content-center" id="modalbtn">
                <input type="button" name="submit" value="SAVE DATA" id="submitBtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-primary btn-block control" />
                </div>

                <div class="result-container d-flex justify-content-center" id="btnDiv2">
                <button type="submit" class="btn btn-primary btn-block control" id="btn_showReport">Show Transactions</button>
                </div>

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
                                    <th>Returned Quantity :</th>
                                    <td id="" class="text-dark"><input type="text" readonly class="txtbox text-primary" name="returnedqty2" id="returnedqty2" value=""></td>
                                    
                                </tr>
                                <tr>
                                    <th>Remarks :</th>
                                    <td id=""><input type="text" readonly class="txtbox text-primary" name="remarks" id="remarks" value=""></td>
                                </tr>
                            </table>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button href="#" id="saveBTN" class="btn btn-success success" data-dismiss="modal">Save</button>
                        </div>
                    </div>
                </div>
                </div>
            
            </div>
            
           <?php
        }
    }
    else
    {
        echo $qrResult . " Not Found";
    }


?>
</form>
<script src="js/ajax_mat_in.js"></script>
<script src="js/materialIn.js"></script>
</body>
</html>


               