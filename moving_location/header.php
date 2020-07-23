<?php
if (isset($_POST['id'])){
$id = $_POST['id'];
if($id==123){
session_start();
$_SESSION['id'] = $id;
header('Location: location.php');
exit();
echo "In Session part";
echo $_SESSION['id'];
}else{
echo "<p> $id is an incorrect ID </p>";
}
}else{
echo "This is a GET";
echo '
<form action="header.php" method="POST">
    <fieldset>
        <legend> Enter Your User ID </legend>
        <p> ID: <input type="text" name="id"> </p>
</fieldset> <input type="submit"> </form>
';
}
?>
