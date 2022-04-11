<?php 

$serverName = "192.168.2.15,40001";
        $connectionInfo = array( "UID" => "iqc_db_user_dev", "PWD" => "iqcdbuserdev", "Database" => "StockCard");
        $conn = sqlsrv_connect($serverName, $connectionInfo);
         
        if( $conn === false )
        {
        echo "Could not connect.\n";
        die( print_r( sqlsrv_errors(), true));
        }
        
        $sql_select2 = "SELECT * From [transaction_record_tbl]
        WHERE GOODS_CODE = '$qrResult'or PART_NUMBER = '$qrResult' or ITEM_CODE = '$qrResult' ORDER BY id ASC";
        $sql_select_run2 = sqlsrv_query( $conn, $sql_select2 );

        if( $sql_select_run2 === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        
        echo '<div class="table_reports bg-light">';
        $date = date('M d, Y');

            echo '<div class="c2" id=""><table class="table table-bordered">
            <thead class="thead bg-primary py-1">
                <tr class="text-white">
                <th scope="col" class="w-25 text-center">DATE</th>
                <th scope="col" class="w-25">RECEIVED</th>
                <th scope="col" class="w-25">ISSUED</th>
                <th scope="col" class="w-25">STOCK</th>
                <th scope="col" class="w-25">INVOICE#</th>
                <th scope="col" class="w-25">ORDER#</th>
                </tr>
              </thead>

            <tbody>';
            if($sql_select_run2)
            {
                
                $count = 0;
                while($row = sqlsrv_fetch_array($sql_select_run2, SQLSRV_FETCH_ASSOC))
                {

                  if($row['TRANSACTION_DATE']->format("m") == '01'){

                        echo '<tr class="active bg-primary text-white">
                                          <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                          <td class="">'.$row['QTY_RECEIVED'].'</td>
                                          <td class="">'.$row['QTY_ISSUED'].'</td>
                                          <td class="">'.$row['TOTAL_STOCK'].'</td>
                                          <td class="">'.$row['INVOICE_KIT'].'</td>
                                          <td class="">'.$row['ORDER_NO'].'</td>
                                    </tr>';
                        }

                    else if($row['TRANSACTION_DATE']->format("m") == '02'){

                        echo '<tr class="active text-white" style = "background-color: #8a2be2;">
                                          <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                          <td class="">'.$row['QTY_RECEIVED'].'</td>
                                          <td class="">'.$row['QTY_ISSUED'].'</td>
                                          <td class="">'.$row['TOTAL_STOCK'].'</td>
                                          <td class="">'.$row['INVOICE_KIT'].'</td>
                                          <td class="">'.$row['ORDER_NO'].'</td>
                                    </tr>';
                        }

                   else if($row['TRANSACTION_DATE']->format("m") == '03'){

                    echo '<tr class="active text-white" style = "background-color:#FF6347;">
                                      <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                      <td class="">'.$row['QTY_RECEIVED'].'</td>
                                      <td class="">'.$row['QTY_ISSUED'].'</td>
                                      <td class="">'.$row['TOTAL_STOCK'].'</td>
                                      <td class="">'.$row['INVOICE_KIT'].'</td>
                                      <td class="">'.$row['ORDER_NO'].'</td>
                                </tr>';

                    }


                    else if($row['TRANSACTION_DATE']->format("m") == '04'){

                        echo '<tr class="active bg-secondary text-white">
                                          <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                          <td class="">'.$row['QTY_RECEIVED'].'</td>
                                          <td class="">'.$row['QTY_ISSUED'].'</td>
                                          <td class="">'.$row['TOTAL_STOCK'].'</td>
                                          <td class="">'.$row['INVOICE_KIT'].'</td>
                                          <td class="">'.$row['ORDER_NO'].'</td>
                                    </tr>';
                        }

                        else if($row['TRANSACTION_DATE']->format("m") == '05'){

                            echo '<tr class="active bg-success">
                                              <td class="active">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                              <td class="success">'.$row['QTY_RECEIVED'].'</td>
                                              <td class="warning">'.$row['QTY_ISSUED'].'</td>
                                              <td class="danger">'.$row['TOTAL_STOCK'].'</td>
                                              <td class="danger">'.$row['INVOICE_KIT'].'</td>
                                              <td class="">'.$row['ORDER_NO'].'</td>
                                        </tr>';
                            }

                        else if($row['TRANSACTION_DATE']->format("m") == '06'){

                            echo '<tr class="active bg-white text-black">
                                              <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                              <td class="">'.$row['QTY_RECEIVED'].'</td>
                                              <td class="">'.$row['QTY_ISSUED'].'</td>
                                              <td class="">'.$row['TOTAL_STOCK'].'</td>
                                              <td class="">'.$row['INVOICE_KIT'].'</td>
                                              <td class="">'.$row['ORDER_NO'].'</td>
                                        </tr>';
                            }

                        else if($row['TRANSACTION_DATE']->format("m") == '07'){

                            echo '<tr class="active text-white" style = "background-color:#FFC0CB;" >
                                              <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                              <td class="">'.$row['QTY_RECEIVED'].'</td>
                                              <td class="">'.$row['QTY_ISSUED'].'</td>
                                              <td class="">'.$row['TOTAL_STOCK'].'</td>
                                              <td class="">'.$row['INVOICE_KIT'].'</td>
                                              <td class="">'.$row['ORDER_NO'].'</td>
                                        </tr>';
                            }

                        else if($row['TRANSACTION_DATE']->format("m") == '08'){

                            echo '<tr class="active text-white" style = "background-color:#964B00;" >
                                              <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                              <td class="">'.$row['QTY_RECEIVED'].'</td>
                                              <td class="">'.$row['QTY_ISSUED'].'</td>
                                              <td class="">'.$row['TOTAL_STOCK'].'</td>
                                              <td class="">'.$row['INVOICE_KIT'].'</td>
                                              <td class="">'.$row['ORDER_NO'].'</td>
                                        </tr>';
                            }

                        else if($row['TRANSACTION_DATE']->format("m") == '09'){

                            echo '<tr class="active text-white bg-warning";" >
                                              <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                              <td class="">'.$row['QTY_RECEIVED'].'</td>
                                              <td class="">'.$row['QTY_ISSUED'].'</td>
                                              <td class="">'.$row['TOTAL_STOCK'].'</td>
                                              <td class="">'.$row['INVOICE_KIT'].'</td>
                                              <td class="">'.$row['ORDER_NO'].'</td>
                                        </tr>';
                            }

                        else if($row['TRANSACTION_DATE']->format("m") == '10'){

                            echo '<tr class="active text-white" style = "background-color:#ADD8E6;" >
                                              <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                              <td class="">'.$row['QTY_RECEIVED'].'</td>
                                              <td class="">'.$row['QTY_ISSUED'].'</td>
                                              <td class="">'.$row['TOTAL_STOCK'].'</td>
                                              <td class="">'.$row['INVOICE_KIT'].'</td>
                                              <td class="">'.$row['ORDER_NO'].'</td>
                                        </tr>';
                            }

                        else if($row['TRANSACTION_DATE']->format("m") == '11'){

                            echo '<tr class="active text-black bg-white">
                                              <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                              <td class="">'.$row['QTY_RECEIVED'].'</td>
                                              <td class="">'.$row['QTY_ISSUED'].'</td>
                                              <td class="">'.$row['TOTAL_STOCK'].'</td>
                                              <td class="">'.$row['INVOICE_KIT'].'</td>
                                              <td class="">'.$row['ORDER_NO'].'</td>
                                        </tr>';
                            }

                        else if($row['TRANSACTION_DATE']->format("m") == '12'){

                            echo '<tr class="active text-white bg-danger">
                                              <td class="">'.$row['TRANSACTION_DATE']->format("m-d-Y (h:i:sa)").'</td>
                                              <td class="">'.$row['QTY_RECEIVED'].'</td>
                                              <td class="">'.$row['QTY_ISSUED'].'</td>
                                              <td class="">'.$row['TOTAL_STOCK'].'</td>
                                              <td class="">'.$row['INVOICE_KIT'].'</td>
                                              <td class="">'.$row['ORDER_NO'].'</td>
                                        </tr>';
                            }

                            

                }

            }               
              
            echo '</tbody></table></div>';
        




            sqlsrv_free_stmt( $sql_select_run2);

            echo '</div>';



            //Trial

// $sql_select_count = "SELECT id, DATE_RECEIVE, GOODS_CODE, ITEM_CODE, INVOICE FROM [Receive] 
// WHERE GOODS_CODE = '$goodsCode' or ITEM_CODE = '$itemCode' 
// GROUP BY id, DATE_RECEIVE, GOODS_CODE, ITEM_CODE, INVOICE ORDER BY id ASC";
// $params = array();
// $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

// $sql_select_count_run = sqlsrv_query( $conn1, $sql_select_count, $params, $options );

// if( $sql_select_count_run === false) 
// {
// die( print_r( sqlsrv_errors(), true) );
// }
// $row_count = sqlsrv_num_rows( $sql_select_count_run );

// if( $row_count === false) 
// {
// die( print_r( sqlsrv_errors(), true) );
// }else{
//     echo "$row_count ";
// }


// if ($row_count > 1){

//     $sql_count_row = "SELECT INVOICE
//                      FROM [Receive] 
//                      WHERE GOODS_CODE = '$goodsCode' or ITEM_CODE = '$itemCode'
//                      GROUP BY INVOICE HAVING COUNT(*) > 1
//                      ORDER BY INVOICE DESC";

//     $params2 = array();
//     $options2 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

//     $sql_count_row_run = sqlsrv_query( $conn1, $sql_count_row, $params2, $options2);

//     if( $sql_count_row_run  === false) 
//     {
//     die( print_r( sqlsrv_errors(), true) );
//     }else {
//         $row_count2 = sqlsrv_num_rows( $sql_count_row_run );
//     }
//     echo $row_count2;

// }


//Trial

?>

$sql_count_invoice = "SELECT INVOICE, COUNT(*) as invoice_count
                                        FROM [Receive]
                                        WHERE GOODS_CODE = '$qrResult' or ITEM_CODE = '$qrResult'
                                        GROUP BY INVOICE";

                                        $sql_count_invoice_run = sqlsrv_query( $conn, $sql_count_invoice);

                                        while($row = sqlsrv_fetch_array($sql_count_invoice_run, SQLSRV_FETCH_ASSOC))
                                        {
                                            $total_invoice_c = $row['invoice_count'];
                                        }