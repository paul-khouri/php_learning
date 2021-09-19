<?php
# connect file should be in the parent directory of the web servers htdocs
$db = new SQLite3('log_in_db.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
print_r($db::version());
print("<br/>");

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $database->connect_error);
  }else{
  echo "Connected successfully<br/>";
  }

?>