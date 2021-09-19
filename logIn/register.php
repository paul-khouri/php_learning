<?php
require('connect_db.php');
$page_title = "Register";
include('includes/header.html');

$errors= array();
$entries = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
echo "Post";
// validation
if(empty($_POST['first_name'])){ $errors[]= "First Name is blank"; }else{ 
    $fn =trim($_POST['first_name']); }
if(empty($_POST['second_name'])){ $errors[]= "Second Name is blank";}else{ 
    $ln =trim($_POST['second_name']); }
if(empty($_POST['email'])){ $errors[]= "Email is blank";}else{ 
    $e =trim($_POST['email']); }
if(empty($_POST['pass_1'])){ $errors[]= "Password is blank"; }else{ 
    $p1 =trim($_POST['pass_1']); }
if(empty($_POST['pass_2'])){ $errors[]= "Password confirmation is blank";}else{ 
    $p2 =trim($_POST['pass_2']); 
}

if(!empty($errors)){

    echo '<h1> There are errors in your form entry </h1>';
    echo '<p style="color:red;">';
    foreach($errors as $msg){
        echo $msg.'<br>';
    }
    echo '</p>';
}

} else{
    echo "Get";
}




?>

<h1>Register</h1>
<form action="register.php" method="POST">
<p>First Name: <input type="text" name="first_name" value=""></p>
<p>Second Name: <input type="text" name="second_name" value=""></p>
<p>Email: <input type="text" name="email" value=""></p>
<p>Password: <input type="password" name="pass_1" value=""></p>
<p>Confrim Password: <input type="password" name="pass_2" value=""></p>
<p><input type="submit" value="Register"></p>
</form>

<?php
include('includes/footer.html');
?>
