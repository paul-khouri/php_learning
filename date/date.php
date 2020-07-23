<!DOCTYPE html>
<html>
<head>
<title>Test Title</title>
</head>
<body>

<?php
date_default_timezone_set("UTC");
$time = date('H:i , F j');
$user = "Paul";
echo $time


?>



<form action="date_handler.php" method="POST">
<fieldset>
    <legend> Send us your comments </legend>
<textarea rows="5" cols="20" name="comment">
</textarea>
<?php
echo '
<input type="hidden" name="user" value="'.$user.'">
<input type="hidden" name="time" value="'.$time.'">
';
?>
</fieldset>
<p><input type="submit"> </p>

</form>

<?php
echo $user;
?>

</body>
</html>