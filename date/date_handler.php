<!DOCTYPE html>
<html>
<head>
<title>Date Handler</title>
</head>
<body>
    <h1> Date Handler </h1>

<?php
# $_POST['comment']
# $_POST['user']
# $_POST['time'] 
if(!empty($_POST['comment'] ) ){
    $comment = $_POST['comment'];
}else{
    $comment = NULL;
    echo 'No comment found';
}

$time = (!isset( $_POST['time']  ))? NULL: $_POST['time'];
$user = (!isset( $_POST['user']  ))? NULL: $_POST['user'];

if ( ($comment != NULL) && ($time != NULL) && ($user != NULL) ){
     
    echo "<p> Comment Received : \" $comment  \"  <br>
    From $user at $time </p>
    ";
}



?>

</body>
</html>