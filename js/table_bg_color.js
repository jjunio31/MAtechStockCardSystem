$(document).ready(function () {
    $("#reportsTable td.rowDate").each(function (index, child) {
      var completeDate = $(this).html();
      var numDate = completeDate.substring (0 , 2);
      console.log(typeof numDate );

     

      switch(numDate) {
        case "01":
          // code block
          $(this).parent("tr").css("background-color","#0080ff");
          break;

        case "02":
          // code block
          $(this).parent("tr").css("background-color","#ee82ee");
          break;

        case "03":
          // code block
          $(this).parent("tr").css("background-color","#ffa500");
          break;

        case "04":
          // code block
          $(this).parent("tr").css("background-color","#808080");
          break;

        case "05":
          // code block
          $(this).parent("tr").css("background-color","#008000");
        break;

        case "06":
          // code block
          $(this).parent("tr").css("background-color","#000000");
        break;

        case "07":
          // code block
          $(this).parent("tr").css("background-color","#ffc0cb");
          break;

        case "08":
          // code block
          $(this).parent("tr").css("background-color","#a64a2b");
          break;

        case "09":
          // code block
          $(".color").css("color","black");
          $(this).parent("tr").css("background-color","#ffff00");
          break;

        case "10":
          // code block
          $(this).parent("tr").css("background-color","#b3b3ff");
          break;

        case "11":
          // code block
          $(".color").css("color","black");
          $(this).parent("tr").css("background-color","#ffffff");
        break;

        case "12":
          // code block
          $(this).parent("tr").css("background-color","#b30000");
        break;
        
      }
      
    });
  });

