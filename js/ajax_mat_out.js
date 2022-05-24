$('#submitBtn').click(function (e) { 
    var selectedRemark = $('#SelectRemark').children("option:selected").val();
    var issuedQty = $('#issuedQty').val();
    var orderNum = $('#orderNum').val();
    $("#remarks").val(selectedRemark);
    $("#issuedQty2").val(issuedQty);
    $("#orderNum2").val(orderNum);    
});

$("#issuedQty, #orderNum").keyup(function () {
    if ($("#issuedQty").val() && $("#orderNum").val()) {
        $("#submitBtn").show();
    }
    else {
        $("#submitBtn").hide();
    }
});
 
      

    var bilang = 0;
 
    $('#submitIssued').click(function (e) { 
        e.preventDefault();

        
        if (bilang == 0){

        var totalReturnedValue = $('input[id=totalReturnedValue]').val();
        var goodsCode = $('input[id=goodsCode]').val();
        var itemCode = $('input[id=itemCode]').val();
        var partNumber = $('input[id=partNumber]').val();
        var partName = $('input[id=partName]').val();
        var current_Qty = ($('input[id=qty]').val());
        var issued_Qty = $('input[id=issuedQty]').val();
        var orderNum = $('input[id=orderNum]').val();
        var Assy = $('input[id=Assy]').val();
        var selectedRemark = $("#SelectRemark").children("option:selected").val();
        var totalReturnedValue = $('input[id=totalReturnedValue]').val();
        
        

        //convert string to int 
        var totalReturnedValueQty = parseInt(totalReturnedValue);
        var currentQty = parseInt(current_Qty);
        var issuedQty = parseInt(issued_Qty);

        if(issuedQty == ""){

            alert ('Please input quantity');
            
        }else if(orderNum == ""){
        
            alert ('Please input Order Number');

        }else if (issuedQty > currentQty){

            alert('Over Quantity');
            
        }else if(totalReturnedValueQty > 0 && issuedQty > totalReturnedValueQty){

            alert ('Unable to process request. \n Release' + " " + totalReturnedValueQty + " " +'returned materials first before releasing new invoices.');
        }

        else {

            
            $.ajax({
                type: "POST",
                url: "material_out_submit.php",
                data: { 
                    issuedQty:issuedQty,
                    currentQty: currentQty,
                    goodsCode:goodsCode,
                    itemCode:itemCode,
                    partNumber:partNumber,
                    partName:partName,
                    orderNum:orderNum,
                    selectedRemark:selectedRemark,
                    Assy:Assy
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
                    url: "mat_report.php",
                    data: {
                        goodsCode:goodsCode,
                        itemCode:itemCode,
                    },
                    dataType: "text",
                    success: function (response) {
                        $('#report').html(response);
                    }
            });
                    
            });

            bilang = 1;

        } 
        }
              
  
    });

    












