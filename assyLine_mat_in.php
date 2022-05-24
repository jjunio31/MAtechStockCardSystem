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
 echo '<ul class="assyButton" style="width: 100%; margin: 0; padding: 0; text-align: center;">';
 while($row_assy = sqlsrv_fetch_array($sql_select_assy_run, SQLSRV_FETCH_ASSOC))
     {
         echo '
             
             <button style="width: 6rem; margin: 3px" 
             class="btn btn-primary btn-sm assyBTN" 
             value="'.$row_assy["ASSY_LINE"].'"
             id="assyBTN1">'.$row_assy["ASSY_LINE"].'
             </button>
             
         ';
     }

echo '</ul>';

?>

<script>
    $(document).ready(function () {
        $('.assyBTN').click(function (e) { 
            e.preventDefault();

            var AssybuttonVal = $(this).val();
            var codeResult = $('.codeResult').val();

            $.ajax({
                type: "POST",
                url: "material_in_info.php",
                data: {
                    AssybuttonVal:AssybuttonVal,
                    codeResult:codeResult
                },
                dataType: "text",
                success: function (data) {
                    $("#formDiv").html(data)
                    console.log(AssybuttonVal);
    
                }
            });
        
            // console.log(AssybuttonVal);
            // console.log(codeResult);
        });
    });

</script>
    
</body>
</html>
