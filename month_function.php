<?php

$serverName = "192.168.2.15,40001";
$connectionInfo = array( "UID" => "iqc_db_user_dev", "PWD" => "iqcdbuserdev", "Database" => "StockCard");
$conn = sqlsrv_connect($serverName, $connectionInfo);
     
    if( $conn === false )
    {
    echo "Could not connect.\n";
    die( print_r( sqlsrv_errors(), true));
    }

    
function january(){
    echo "January";
    
}


?>