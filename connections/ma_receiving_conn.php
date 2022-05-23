<?php

// Conn for MA_Receiving
// $serverName = "192.168.2.15,40001";
// $connectionInfo1 = array( "UID" => "iqc_db_user_dev", "PWD" => "iqcdbuserdev", "Database" => "MA_Receiving");
// $conn1 = sqlsrv_connect($serverName, $connectionInfo1);

// if( $conn1 === false )
// {
// echo "Could not connect.\n";
// die( print_r( sqlsrv_errors(), true));
// }
// // else{
// //     echo "Connection Established";
// // }

$serverName = "192.168.2.14";
$connectionInfo1 = array("UID" => "software", "PWD" => "specialist", "Database" => "MA_Receiving");
$conn1 = sqlsrv_connect($serverName, $connectionInfo1);

if( $conn1 === false )
{
echo "Could not connect.\n";
die( print_r( sqlsrv_errors(), true));
}
// else{
//     echo "Connection Established";
// }

?>