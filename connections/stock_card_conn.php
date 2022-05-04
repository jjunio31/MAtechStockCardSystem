<?php

// Conn for StockCard
// $serverName = "192.168.2.15,40001";
// $connectionInfo2 = array( "UID" => "iqc_db_user_dev", "PWD" => "iqcdbuserdev", "Database" => "StockCard");
// $conn2 = sqlsrv_connect($serverName, $connectionInfo2);

// if( $conn2 === false )
// {
// echo "Could not connect.\n";
// die( print_r( sqlsrv_errors(), true));
// }
// // else{
// //     echo "Connection Established";
// // }

$serverName = "192.168.2.14";
$connectionInfo2 = array("UID" => "software", "PWD" => "specialist", "Database" => "StockCard");
$conn2 = sqlsrv_connect($serverName, $connectionInfo2);

if( $conn2 === false )
{
echo "Could not connect.\n";
die( print_r( sqlsrv_errors(), true));
}
// else{
//     echo "Connection Established";
// }


?>

