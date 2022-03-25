
  
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
        var location = $('input[id=location]').val();
        var itemNumber = $('input[id=itemNumber]').val();
        // var qtyStored = $('input[id=qtyStored]').val();
        // var pt_date = $('input[id=pt_date]').val();
       
        if(receivedQTY == 0){
            alert("Please input quantity");
        }else if(location == ""){
            alert("Material location is required");
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
                    location:location,
                    itemNumber:itemNumber
                    // qtyStored:qtyStored
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

$( function() {
    var availableTags = [
      "Rack 1-A",
      "Rack 2-A",
      "Rack 3-A",
      "Rack 4-A",
      "Rack 5-A",
      "Rack 6-A",
      "Rack 7-A",
      "Rack 8-A",
      "Rack 9-A",
      "Rack 10-A",
      "Rack 1-B",
      "Rack 1-C",
      "Rack 2-B",
      "Rack 3-B",
      "Rack 4-B",
      "Rack 5-B",
      "Rack 6-B",
      "Rack 7-B",
      "Rack 8-B",
      "Rack 9-B",
      "Rack 10-B"
      
    ];
    $( "#location" ).autocomplete({
      source: availableTags
    });
  } );

  $("#location").prop('required',true);

  $(".category").autocomplete({
    source: availableTags,
    change: function (event, ui) {
        if(!ui.item){
            $(event.target).val("");
        }
    }, 
    focus: function (event, ui) {
        return false;
    }
});


// $(document).ready(function(){
//     $("#receivedQTY").keyup(function(){
//         $("#qtyStored").val($("#receivedQTY").val());
//     });
    
// });

// $('#qtyStored').on('click focusin', function() {
//     this.value = '';
// });





