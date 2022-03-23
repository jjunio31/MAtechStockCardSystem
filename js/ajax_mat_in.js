
$(document).ready(function () {
    $('#saveBTN').click(function (e) { 
        e.preventDefault();

        var goodsCode = $('input[id=goodsCode]').val();
        var itemCode = $('input[id=itemCode]').val();
        var partNumber = $('input[id=partNumber]').val();
        var partName = $('input[id=partName]').val();
        var currentStock = $('input[id=currentStock]').val();
        var receivedQTY = $('input[id=receivedQTY]').val();
        var invoiceKit = $('input[id=invoiceKit]').val();
        // var pt_date = $('input[id=pt_date]').val();
       
        if(receivedQTY == 0){
            alert("Please input quantity");
        }else if(invoiceKit == ""){
            alert("Please input Invoice/Kit NO.");
        }else{
 
            $.ajax({
                type: "post",
                url: "material_in_submit.php",
                data: { 
                    receivedQTY:receivedQTY,
                    currentStock: currentStock,
                    goodsCode:goodsCode,
                    itemCode:itemCode,
                    partNumber:partNumber,
                    partName:partName,
                    invoiceKit:invoiceKit,
                    // pt_date:pt_date
                },
                dataType: "text",
                success: function (response) {
                    $('#messageDisplay').text(response);
                    $('#saveBTN').prop('disabled', true);
                }
            })
            
            $("#btn_showReport").show(); //show report div
            $("#btn_showReport").click(function (e) { 
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "mat_in_report.php",
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










