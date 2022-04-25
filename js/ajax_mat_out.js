
   
   //AJAX FOR MODAL BREAKDOWN
   $(document).ready(function () {
    $("#breakdown-btn").click(function (e) { 
        e.preventDefault();

        var goodsCode = $('input[id=goodsCode]').val();
        $.ajax({
            type: "post",
            url: "modal_breakdown.php",
            data: {goodsCode:goodsCode},
            dataType: "text",
            success: function (response) {
                
                $('#breakdownDiv').html(response);
            }
        });
    });
});


$(document).ready(function () {
    //type info to modal
    $("#issuedQty").keyup(function(e){
        var val = $(this).val();
        $("#issuedQty2").val(val);
      });
    
      $("#orderNum").keyup(function(e){
        var val = $(this).val();
        $("#orderNum2").val(val);
      });

      $("#SelectRemark").change(function(e){
        var selectedRemark = $("#SelectRemark").children("option:selected").val();
        $("#remarks").val(selectedRemark); 
      });

      

    $(document).ready(function() {
        $("#issuedQty, #orderNum").keyup(function () {
            if ($("#issuedQty").val() && $("#orderNum").val()) {
               $("#submitBtn").show();
            }
            else {
               $("#submitBtn").hide();
            }
         });
    });

      
 
    $('#submitIssued').click(function (e) { 
        e.preventDefault();

        var totalReturnedValue = $('input[id=totalReturnedValue]').val();
        var goodsCode = $('input[id=goodsCode]').val();
        var itemCode = $('input[id=itemCode]').val();
        var partNumber = $('input[id=partNumber]').val();
        var partName = $('input[id=partName]').val();
        var current_Qty = ($('input[id=qty]').val());
        var issued_Qty = $('input[id=issuedQty]').val();
        var orderNum = $('input[id=orderNum]').val();
        var selectedRemark = $("#SelectRemark").children("option:selected").val();
        

        //convert string to int 

        var totalReturnedValueQty = parseInt(totalReturnedValue);
        var currentQty = parseInt(current_Qty);
        var issuedQty = parseInt(issued_Qty);
        


        if(issuedQty == ""){

            alert ('Please input quantity');
            
        }else {

            if(orderNum == "")
        {
            alert ('Please input Order Number');

        }else if (issuedQty > currentQty){

            alert('Over Quantity');
            
        }else if (selectedRemark == "none"){

            alert('Please Select Remarks');

        }
        else if(issuedQty > totalReturnedValueQty){

            alert ('Unable to process request. \n Release' + " " + totalReturnedValueQty + " " +'returned materials first before releasing new invoices.');
        }

        else {

            $.ajax({
                type: "post",
                url: "material_out_submit.php",
                data: { 
                    issuedQty:issuedQty,
                    currentQty: currentQty,
                    goodsCode:goodsCode,
                    itemCode:itemCode,
                    partNumber:partNumber,
                    partName:partName,
                    orderNum:orderNum,
                    selectedRemark:selectedRemark
                },
                dataType: "text",
                success: function (response) {
                    $('#messageDisplay').text(response);
                    $('#submitBtn').hide();
                    
                }
            })
            
            $("#btn_showReport").show(); 
            $("#btn_showReport").click(function (e) { 
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "mat_out_report.php",
                    data: {
                        goodsCode:goodsCode,
                        itemCode:itemCode,
                    },
                    dataType: "text",
                    success: function (response) {
                        $('#report').html(response);
                    }
            })
                    
            });



        }

        }

       
  
    })
});










