<!DOCTYPE html>
<html lang="en">
<?php
    include 'connections/ma_receiving_conn.php';
    include 'connections/stock_card_conn.php';
    include 'html/head.php';
?>
<body>

<?php
 if (isset($_POST['codeResult']))
 { 
 $codeResult = $_POST['codeResult'];
 }

 echo '<input type="text" style="display:none;" class="codeResult" id="codeResult" value="'.$codeResult.'">';

 
 $sql_select_assy = "SELECT GOODS_CODE, ASSY_LINE 
                     FROM [Total_Stock]
                     WHERE GOODS_CODE = '$codeResult' ";

 $sql_select_assy_run = sqlsrv_query( $conn1, $sql_select_assy);
 if( $sql_select_assy_run === false ) {
     die( print_r( sqlsrv_errors(), true));
 }
 

 //SHOW BUTTON FOR ASSY LINE
 while($row_assy = sqlsrv_fetch_array($sql_select_assy_run, SQLSRV_FETCH_ASSOC))
     {
         echo '
             <div class="text-center assyDiv">
             <button style="width: 6rem; margin: auto;" 
             class="btn btn-primary btn-sm assyBTN" 
             value="'.$row_assy["ASSY_LINE"].'"
             id="assyBTN">'.$row_assy["ASSY_LINE"].'
             </button>
             </div>
         ';
     }
?>

<script>
    $(document).ready(function () {
        $('.assyBTN').click(function (e) { 
            e.preventDefault();

            var AssybuttonVal = $(this).val();
            var codeResult = $('.codeResult').val();

            $.ajax({
                type: "POST",
                url: "reports_info.php",
                data: {
                    AssybuttonVal:AssybuttonVal,
                    codeResult:codeResult
                },
                dataType: "text",
                success: function (data) {
                    $("#formDiv").html(data)
                    // AJAX TO PASS CURRENT MONTH TO reports_month.php
                  var d = new Date(),
                  n = '0' + (d.getMonth()+1);
                  
                  $.ajax({
                      type: "post",
                      url: "reports_month.php",
                      data: {
                          n:n,
                          codeResult:codeResult,
                          AssybuttonVal:AssybuttonVal
                      },
                      dataType: "text",
                      success: function (data) {
                          $('.monthReportDiv').html(data);
                          // console.log(n);
                      }
                  });
                }
            });
        
            // console.log(AssybuttonVal);
            // console.log(codeResult);
        });
    });

</script>
    
</body>
</html>
