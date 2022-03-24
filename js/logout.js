// $('#logout').click(function(){
//     var reallyLogout=confirm("Do you really want to log out?");
//     if(reallyLogout){
//         location.href="logOut.php";
//     }
// });

$(function(){
    $('#logout').click(function(){
        if(confirm('Are you sure you want to log out?')) {
            return true;
        }

        return false;
    });
});