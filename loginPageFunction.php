<?php

include 'login_connection.php';

session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['pword'] ?? '';

#searches for email and password in the database
$query = "SELECT * FROM [dbo].[tblEnrolled_List] 
        WHERE empNum='$username' 
        AND [password]='$password' 
        AND isActive ='True' 
        AND Software_Name='STOCK_CARD'";

$result = sqlsrv_query($conn, $query);  

#checks if the search was made
if($result === false){
 die( print_r( sqlsrv_errors(), true));
}

if(!isset($username) || trim($password) == '')
{
   //echo "You did not fill out the required fields.";
}
else{

    if(sqlsrv_has_rows($result) != 1){
        // echo "Username and Password not found!";
        // header("Location: loginPage.php");
        // echo '<script>alert("Username and Password not found!")</script>';
        echo '<script type="text/javascript">alert("Wrong Username or Password");window.location=\'index.php\';</script>';
         
         
     }else{
         header("Location: reports.php");
         #creates sessions

         while($row = sqlsrv_fetch_array($result)){
             echo $_SESSION['id'] = $row['id'];
             $_SESSION['username'] = $row['empNum'];
             $_SESSION['password'] = $row['password'];

            

             
             
         }
     }
}



?>

 