<!DOCTYPE html>
<html>
<head>
<title>Action Page</title>
</head>
<body>
<h1>Action Page </h1>
<form action="action_handler.php" method="POST">
    <dl>
        <dt> Name: </dt>
        <dd> <input type="text" name="name"> </dd>
        <dt> Email: </dt>
        <dd> <input type="text" name="mail"> </dd>
        <dt> Comments: </dt>
        <dd> <textarea rows="5" cols="20" name="comment"> </textarea> </dd>
</dl>
<p> <input type="submit"></p>
</form>

</body>
</html>