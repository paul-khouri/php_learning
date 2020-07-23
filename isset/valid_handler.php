<!DOCTYPE html>
<html>
<head>
<title>Valid Handler Page</title>
<style>
    body{
        font-family: sans-serif;
        font-size:100%;
    }
    .error-style{
        background-color: red;
        color: white;
    }

    .correct-style{
        background-color: green;
        color: white;

    }
    .error-style , .correct-style{
        padding: 10px;
        font-size: 2em;
        width:80%;
    }

    </style>
</head>
<body>
<h1>Valid Handler Page </h1>


<?php
if( !empty( $_POST['quantity'] )  ){
$quantity = $_POST['quantity'];
echo "<div class='correct-style'> Quantity is not null </div>";
}
else{
    $quantity = NULL;
    echo "<div class='error-style'> You must enter quantity </div>";
}

if( !is_numeric( $quantity )){
    $quantity = NULL;
    echo "<div class='error-style'> Quantity must be numeric </div>";
}else{
    echo "<div class='correct-style'> Quantity is a number </div>";
}

if( !empty( $_POST['email'] )  ){
    $email = $_POST['email'];
    echo "<div class='correct-style'> Email is not null </div>";
    }
    else{
        $email = NULL;
        echo "<div class='error-style'> You must enter email </div>";
    }

$pattern = '/\b[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}\b/';
if (!preg_match($pattern, $email)){
    $email= NULL;
    echo "<div class='error-style'> Email is not correctly formatted </div>";
}else{

    echo  "<div class='correct-style'> Email is okay. </div>";
}

if( ($quantity != NULL) && ($email != NULL)){
echo "<div class='correct-style'> Quantity is $quantity and Email is $email. </div>";

}





?>

</body>
</html>