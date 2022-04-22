$(document).ready(function(){

    $("select#SelectMonth").change(function(){

        var selectedMonth = $(this).children("option:selected").val();
        var goodsCode = $('input[id=goodsCode]').val();
        var itemCode = $('input[id=itemCode]').val();
        var partNumber = $('input[id=partNumber]').val();

            
        $.ajax({
            type: "POST",
            url: "reports_month.php",
            data: {
                selectedMonth:selectedMonth,
                goodsCode:goodsCode,
                itemCode:itemCode,
                partNumber:partNumber
            },
            dataType: "text",
            success: function (data) {
                $('.monthReportDiv').html(data);
            }
        });
        

    });

});