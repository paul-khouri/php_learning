<!DOCTYPE html>
<html>
<head>
<title>Sticky Form </title>
</head>
<body>
    <h1>Sticky Form </h1>
<?php
$errors = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    if( empty($_POST['name'])){ $errors[]= 'name'; }else{ $name = trim($_POST['name']);  }
    if( empty($_POST['email'])){ $errors[]= 'email'; }else{ $email = trim($_POST['email']); }

    if(!empty($errors)){
        echo "We have some errors<br/>";
        foreach ($errors as $msg){ echo "$msg <br/>";}


    }else{
        echo "Thanks for submitting this form";
    }

}else{
    echo "This should be the first arrival at the form";
}
?>

<form action="sticky.php" method="POST">
    <p> Name: <input type="text" name="name" value="<?php if(isset($_POST['name'])) echo $_POST['name'];?>"> </p>
    <p> Email: <input type="text" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>"> </p>
<p><input type="submit" value="Submit"> </p>
<p><input type="reset" value="Reset"> </p>
<p> <a href="sticky.php"> <input type="button" value="Start Again"> </a> </p>
</form>




</body>
</html>