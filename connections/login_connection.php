<?php
    $serverName = "192.168.2.14";
    $connectionInfo = array( "UID" => "software", "PWD" => "specialist", "Database" => "GlobalAccess");
    $conn = sqlsrv_connect($serverName, $connectionInfo);

    if( $conn === false )
     {
     echo "Could not connect.\n";
     die( print_r( sqlsrv_errors(), true));
     }
     else {
      //   echo "connection established";
     }
?>