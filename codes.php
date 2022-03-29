 <!--select query for multiple location of goodscode-->
 <?php 
            $sql_select2 = "SELECT * From [Receive]
            WHERE GOODS_CODE = '$qrResult'or PART_NUMBER = '$qrResult' or ITEM_CODE = '$qrResult'";
            // ORDER BY DATE_RECEIVE ASC";
            $sql_select2_run = sqlsrv_query( $conn, $sql_select2); 

            if($sql_select2_run === false){
                die( print_r( sqlsrv_errors(), true) );
            }
            ?>

<?php 
                echo 
                '<div class="c2" id=""><table class="table table-bordered table-sm bg-light">
                <thead class="thead-light">
                    <tr>
                    <th scope="col">DATE RECEIVED</th>
                    <th scope="col">INVOICE</th>
                    <th scope="col">QUANTITY</th>
                    </tr>
                  </thead>
                <tbody>';
                
                if($sql_select2_run){
            
                while($row = sqlsrv_fetch_array($sql_select2_run, SQLSRV_FETCH_ASSOC))
                {

            echo '<tr class="active">
                                      <td class="active ">'.$row['DATE_RECEIVE']->format("m-d-Y").'</td>
                                      <td class="success">'.$row['INVOICE'].'</td>
                                      <td class="warning">'.$row['QTY'].'</td>
                  </tr>';
                }
            }               
              
            echo '</tbody></table></div>';
        

            sqlsrv_free_stmt( $sql_select2_run);
                
                ?>

<?php
//Query for Insert
                $sql_select_reports = "SELECT * FROM transaction_record_tbl";
                $params = array();
                $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                $stmt = sqlsrv_query( $conn2, $sql_select_reports, $params, $options);
                $row_count = sqlsrv_num_rows( $stmt );
                $currentRow = $row_count + 1;

                date_default_timezone_set('Asia/Hong_Kong');  
                $date = date('m-d-Y H:i:s');

                $sql_insert = "INSERT INTO transaction_record_tbl (id, TRANSACTION_DATE, GOODS_CODE, ITEM_CODE, QTY_ISSUED, TOTAL_STOCK, PART_NUMBER, PART_NAME, INVOICE_KIT) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ";
                $params1 = array($currentRow, $date, $goodsCode, $itemCode, $issuedQty, $updatedStock, $partNumber, $partName, $invoiceKit );
                $sql_insert_run = sqlsrv_query($conn2, $sql_insert, $params1);
                
                if( $sql_insert_run === false) {
                    die( print_r( sqlsrv_errors(), true) );
                }
?>