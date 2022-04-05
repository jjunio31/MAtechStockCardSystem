//type info to modal
  $("#returnedqty").keyup(function(e){
    var val = $(this).val();
    $("#returnedqty2").val(val);
  });

  $("#invoice").keyup(function(e){
    var val = $(this).val();
    $("#invoice2").val(val);
  });

  $("#reason").keyup(function(e){
    var val = $(this).val();
    $("#reason2").val(val);
  });


$("#returnedqty, #invoice").keyup(function () {
   if ($("#returnedqty").val() && $("#invoice").val()) {
      $("#submitBtn").show();
   }
   else {
      $("#submitBtn").hide();
   }
});




$(document).ready(function () {
    $('#saveBTN').click(function (e) { 
        e.preventDefault();
        
        var goodsCode = $('input[id=goodsCode]').val();
        var itemCode = $('input[id=itemCode]').val();
        var partNumber = $('input[id=partNumber]').val();
        var partName = $('input[id=partName]').val();
        var returnedqty = $('input[id=returnedqty]').val();
        var reason = $('input[id=reason]').val();
        var invoice = $('input[id=invoice]').val();
        var currentQty = $('input[id=currentQty]').val();
        

            $.ajax({
                type: "post",
                url: "material_in_submit.php",
                data: { 
                    goodsCode:goodsCode,
                    itemCode:itemCode,
                    partName:partName,
                    partNumber:partNumber,
                    returnedqty:returnedqty,
                    reason:reason,
                    invoice:invoice,
                    currentQty:currentQty
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
    })
});





