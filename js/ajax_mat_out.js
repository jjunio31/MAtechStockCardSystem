$(document).ready(function () {
    $('#submitIssued').click(function (e) { 
        e.preventDefault();

        var goodsCode = $('input[id=goodsCode]').val();
        var itemCode = $('input[id=itemCode]').val();
        var partNumber = $('input[id=partNumber]').val();
        var partName = $('input[id=partName]').val();
        var currentQty = $('input[id=qty]').val();
        var issuedQty = $('input[id=issuedQty]').val();
        var orderNum = $('input[id=orderNum]').val();

        
       

        if(currentQty < issuedQty){
            alert("Not enough stock");
        }else if(issuedQty == 0){
            alert("Please input quantity");
        }else if(orderNum == ""){
            alert("Please input order number");
        }else{

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
                    orderNum:orderNum
                },
                dataType: "text",
                success: function (response) {
                    $('#messageDisplay').text(response);
                    $('#submitIssued').prop('disabled', true);
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
  
    })
});










