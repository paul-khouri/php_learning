<!DOCTYPE html>
<html>
<head>
<title>Test Two</title>
</head>
<body>
<h1>Test Two Page</h1>
<?php
$db = new SQLite3('test_two.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $database->connect_error);
  }else{
  echo "Connected successfully<br/>";
  }

?>
</body>
</html>