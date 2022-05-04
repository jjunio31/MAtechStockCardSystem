





    function printData()
    {

        var style = "<style>";
        style = style + "table {width: 100%; font: 17px Calibri;}";
        style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
        style = style + "padding: 2px 3px; text-align: center;}";
        style = style + "</style>";
        
        var divToPrint=document.getElementById("reportsTable");
        var matInfo=document.getElementById("formDiv");
        newWin= window.open("");
        newWin.document.write(matInfo.outerHTML);
        // newWin.document.write(divToPrint.outerHTML);
        newWin.document.write(style);
       
        newWin.print();
        newWin.close();
    }

    $('#btnPrint').on('click',function(){
    printData();
    })

//     function PrintElem(elem)
// {
//     var mywindow = window.open('', 'PRINT');

//     mywindow.document.write('<html><head><title>' + document.title  + '</title>');
//     mywindow.document.write('</head><body >');
//     mywindow.document.write('<h1>' + document.title  + '</h1>');
//     mywindow.document.write(document.getElementById(reportsTable).innerHTML);
//     mywindow.document.write('</body></html>');

//     mywindow.document.close(); // necessary for IE >= 10
//     mywindow.focus(); // necessary for IE >= 10*/

//     mywindow.print();
//     mywindow.close();

//     return true;
// }

//  $('#btnPrint').on('click',function(){
//     printData();
//     })