<?php
// absolutely must be outputted before the sesson start
session_start();
if ( isset(  $_SESSION['id']  )   ){
    $id = $_SESSION['id'];
    echo "<!DOCTYPE html>
    <html>
    <head>
    <title>Location </title>
    </head>
    <body>
    <h1>You have got here </h1>";
    echo "Welcome user ID # $id";


}else{
    echo "No session set";
}
session_destroy();
?>

</body>
</html>