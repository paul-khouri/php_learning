<!DOCTYPE html>
<html>
<head>
<title> Appending Link Data  </title>
<link rel="stylesheet" href="../include/includes/styles.css">
</head>
<?php
if(isset($_GET['id'])){
$id = $_GET['id'];

switch($id){
    case 1: echo 'Cow selected <hr>' ; break;
    case 2: echo 'Dog selected <hr>' ; break;
    case 3: echo 'Goat selected <hr>'; break;
}

}

echo '
<header><h1>Select a buddy</h1></header>
<p> <a href="link.php?id=1"> Cow </a> |
 <a href="link.php?id=2"> Dog </a> |
 <a href="link.php?id=3"> Goat </a> </p>
';

?>
<body>