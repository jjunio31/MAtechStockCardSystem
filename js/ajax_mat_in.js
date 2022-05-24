

$('#submitBtn').click(function (e) { 
 
        var selectedRemark = $('#SelectRemark').children("option:selected").val();
        var returnedval = $('#returnedqty').val();
        $("#remarks").val(selectedRemark);
        $("#returnedqty2").val(returnedval);

});



$("#returnedqty").keyup(function () {
   if ($("#returnedqty").val()) {
      $("#submitBtn").show();
   }
   else {
      $("#submitBtn").hide();
   }
});

    var bilang = 0;

    $('#saveBTN').click(function (e) { 
        e.preventDefault();

        if(bilang == 0){

        var goodsCode = $('input[id=goodsCode]').val();
        var itemCode = $('input[id=itemCode]').val();
        var partNumber = $('input[id=partNumber]').val();
        var partName = $('input[id=partName]').val();
        var returnedqty = $('input[id=returnedqty]').val();
        var currentQty = $('input[id=currentQty]').val();
        var Assy = $('input[id=Assy]').val();
        var selectedRemark = $('#SelectRemark').children("option:selected").val();

        console.log(goodsCode);

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
                  selectedRemark:selectedRemark,
                  Assy:Assy
              },
              dataType: "text",
              success: function (response) {
                  $('#messageDisplay').text(response);
                  $('#submitBtn').hide();
                  console.log (selectedRemark);
                  console.log (returnedqty);
                  console.log (Assy);
                  
              }
          });
          
          $("#btn_showReport").show(); 
          $("#btn_showReport").click(function (e) { 
              e.preventDefault();
              $.ajax({
                  type: "post",
                  url: "mat_report.php",
                  data: {
                      goodsCode:goodsCode,
                      itemCode:itemCode,
                      Assy:Assy
                  },
                  dataType: "text",
                  success: function (response) {
                      $('#report').html(response);
                  }
          });
                  
          });

          bilang = 1;

          }

     
    });






