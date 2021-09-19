<?php
require('../connect_db.php');


$result = $db->query("SELECT * FROM towels");
$number_of_rows = 0;
while($row = $result->fetchArray()) {
    $number_of_rows += 1;
}
echo "There are $number_of_rows rows in the table";




?>