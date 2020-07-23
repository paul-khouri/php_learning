<?php
$page_title = "PHP Include";
include('includes/header.html');
?>
<form action="include.php" method="POST">
<p>Name: <input type="text" name="name"> </p>
<p>Email: <input type="text" name="email"> </p>
<p> <input type="submit"> </p>

</form>

<?php
include('includes/footer.html');
?>