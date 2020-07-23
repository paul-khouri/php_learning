<!DOCTYPE html>
<html>
<head>
<title>Action Handler Page</title>
</head>
<body>
<h1>Action Handler Page </h1>

<?php
// the message
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("paul.khouri@marsden.school.nz","My subject",$msg);
?>
<?php
$name = $_POST['name'];
$mail = $_POST['mail'];
$comment = $_POST['comment'];
echo "<p> Thanks for this, $name </p>";
echo "<p> <i>$comment </i> </p>";
echo "<p> We will reply to $mail </p>"

?>

</body>
</html>