<?php
require('../connect_db.php');
print_r($db::version());
/*
$db->query('CREATE TABLE IF NOT EXISTS "visits" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "user_id" INTEGER,
    "url" VARCHAR,
    "time" DATETIME
)');
*/


$q = 'SELECT * from towels';

$r = $db->query($q);
if($r) {
    echo "Query executed";
} else{
    echo "Query did not execute";
}

?>