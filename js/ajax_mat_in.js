
  
$(document).ready(function () {
    $('#saveBTN').click(function (e) { 
        e.preventDefault();

        var goodsCode = $('input[id=goodsCode]').val();
        var itemCode = $('input[id=itemCode]').val();
        var partNumber = $('input[id=partNumber]').val();
        var partName = $('input[id=partName]').val();
        var returnedqty = $('input[id=returnedqty]').val();
        var reason = $('input[id=reason]').val();
       
        if(returnedqty == 0){
            alert("Please input quantity");   
        }else if(reason == ""){
            alert("Please provide reason");   
        }
        else{
            $.ajax({
                type: "post",
                url: "material_in_submit.php",
                data: { 
                    goodsCode:goodsCode,
                    itemCode:itemCode,
                    partName:partName,
                    partNumber:partNumber,
                    returnedqty:returnedqty,
                    reason:reason
                },
                dataType: "text",
                success: function (response) {
                    $('#messageDisplay').text(response);
                    $('#saveBTN').prop('disabled', true);
                }
            })
            
            // $("#btn_showReport").show(); //show report div
            // $("#btn_showReport").click(function (e) { 
            //     e.preventDefault();
            //     $.ajax({
            //         type: "post",
            //         url: "mat_in_report.php",
            //         data: {
            //             goodsCode:goodsCode,
            //             itemCode:itemCode,
            //         },
            //         dataType: "text",
            //         success: function (response) {
            //             $('#report').html(response);
            //         }
            // })
                    
            // });
            
            
        }
  
    })
});





