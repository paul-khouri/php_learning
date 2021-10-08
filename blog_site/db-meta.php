<?php 
require_once 'lib/common.php';
session_start();
$pdo = getPDO();
$stmt = $pdo->query('pragma foreign_keys');
if($stmt === false){
    {
      throw new Exception("problem getting pragma");
    }
  }
$result = $stmt -> fetchColumn();
$stmt = $pdo->query('select * from sqlite_master;');
if($stmt === false){
    {
      throw new Exception("probelm getting sqlite master");
    }
  }


$page_title = 'Table metadata';
require 'templates/boilerplate.php';
?>

<body>
<?php require 'templates/title.php' ?>

<style>
table{
            width:80%;
            margin:auto;
        }

table, th, td {
  border: 1px solid #eeeeee;
  border-collapse: collapse;
}
th , td{
    padding:0.25em;
    border-bottom: 1px solid black;
}
</style>

<? echo 'Pragma foreign key setting (<span style="font-size: 0.5em;"> 0 off , 1 on </span>): <b>' . $result . '</b>' ?>
<table>
    <tr><th>type </th><th> name </th><th>tbl_name </th><th>rootpage </th><th> sql </th></tr>

<? 
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    echo '<tr>';
    foreach($row as $r){
        echo '<td>' . $r .'</td>';
    }
    echo '</tr>';
}
?>
</table>
</body>
</html>