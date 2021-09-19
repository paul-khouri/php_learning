<?php
require('../connect_db.php');
//print_r($db::version());
/*
$db->query('CREATE TABLE IF NOT EXISTS "visits" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "user_id" INTEGER,
    "url" VARCHAR,
    "time" DATETIME
)');
*/

function show_records($db){

$q = 'SELECT * from towels';
$statement = $db->prepare($q);
$r = $statement->execute();

if($r) {
    echo '<hr>';
    echo "Query executed";
    echo "<h1> Records in Towels Table</h1>";
    //$result=$r->fetchArray(SQLITE3_ASSOC);
    while( $result=$r->fetchArray(SQLITE3_ASSOC) ){
        echo '<div style="padding: 10px;">'.$result['id'].'|'.$result['name'].'|'.$result['color'].'|'.$result['price'].'</div>';

    }
    $r->finalize();
} else{
    echo "Query did not execute";
}


}




show_records($db);


$q = 'INSERT INTO towels (name, color, price) VALUES ("Highlands", "Green", 29.99)';
$statement = $db->prepare($q);
$r = $statement->execute();


show_records($db);



?>