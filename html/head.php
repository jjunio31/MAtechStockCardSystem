<?php 
  session_start();

  if(!isset($_SESSION['username']))
  {
    header("Location:index.php");
  }
?>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Instascan-->
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <!--font-awesome CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    

    <!-- bootstrap CDN and CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    

    <!-- Jquery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Stock Card System</title>
    <style>
     
     body{
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
      }
      label, .qrResult{
        width: 9rem;
        margin-bottom: 0;
        color: #FFFFFF;
        font-family: 'Poppins', sans-serif;
      }
      table{
        width: 100%;
      }

        th{
        width: 14%;
        }

        th, td{
          text-align: center;
          padding-top: 0 !important;
          padding-bottom: 0 !important;
          margin: 0;
        }

        .rowDate, .rowRemarks, .rowInvoice, .rowOrder{
          font-size: .8rem;
        }

        @media (max-width:810px){
    
        th{
            font-size: .7rem;
            padding: 0 !important;
          }

        table{
                overflow-x: scroll;
          }
          
        }

        #btn_showReport{
            margin: 0;
            display: none;
        }
        #btnDiv1, #btnDiv2{
            margin: 0;
            padding: 0;
        }
        #submitIssued{
            margin: 0;
        }
        #btnDiv2{
            margin-top: .3rem;
            
        }

        #SelectRemark{
            width: 50%;
            border-radius: 25px;
            border: 2px solid white;
            padding: .2rem; 
        }

        .old_invoice_div{
            max-width: 850px;
            margin: auto;
        }

       .icon-modal{
           font-weight: 300;
       }
       #totalReturnedValue{
           display: none;
       }

    </style>

  </head>