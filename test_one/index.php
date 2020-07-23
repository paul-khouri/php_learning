<!DOCTYPE html>
<html>
<head>
<title>Test Title</title>
</head>
<body>
<h1>This is a php page</h1>
<?php
$database = new SQLite3('myDatabase.sqlite');

// Check connection
if ($database->connect_error) {
    die("Connection failed: " . $database->connect_error);
  }
  echo "Connected successfully<br/>";


  // sql to create table
$sql = "CREATE TABLE if not exists MyGuests (
    id Integer PRIMARY KEY,
    firstname  NOT NULL,
    lastname  NOT NULL,
    email NOT NULL
    )";

if ($database->query($sql) === TRUE) {
    echo "Table MyGuests created successfully";
  } else {
    echo "Error creating table: " . $conn->error;
  }


?>
<?php
$x = 567;
var_dump($x);
?>
<hr>
<?php
echo "<h3>Hello World!</h3>";
phpinfo();
?>

</body>
</html>