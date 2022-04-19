$(document).ready(function () {

  //type info to modal
  $("#returnedqty").keyup(function(e){
    var val = $(this).val();
    $("#returnedqty2").val(val);
  });

  $("#SelectRemark").change(function(e){
    var selectedRemark = $('#SelectRemark').children("option:selected").val();
    $("#remarks").val(selectedRemark);
  });


$("#returnedqty").keyup(function () {
   if ($("#returnedqty").val()) {
      $("#submitBtn").show();
   }
   else {
      $("#submitBtn").hide();
   }
});


    $('#saveBTN').click(function (e) { 
        e.preventDefault();
        
        var goodsCode = $('input[id=goodsCode]').val();
        var itemCode = $('input[id=itemCode]').val();
        var partNumber = $('input[id=partNumber]').val();
        var partName = $('input[id=partName]').val();
        var returnedqty = $('input[id=returnedqty]').val();
        var currentQty = $('input[id=currentQty]').val();
        var selectedRemark = $('#SelectRemark').children("option:selected").val();
      
        if(selectedRemark == "none"){
          alert('Please select remark');
        }else{

           $.ajax({
                type: "post",
                url: "material_in_submit.php",
                data: { 
                    goodsCode:goodsCode,
                    itemCode:itemCode,
                    partName:partName,
                    partNumber:partNumber,
                    returnedqty:returnedqty,
                    currentQty:currentQty,
                    selectedRemark:selectedRemark
                },
                dataType: "text",
                success: function (response) {
                    $('#messageDisplay').text(response);
                    $('#submitBtn').hide();
                    console.log (selectedRemark);
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

        }
           
    })
});





