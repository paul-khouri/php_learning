<?php
require_once "lib/common.php";

$pdo = getPDO();
$sql='select *
  from comment
  order by created_at desc';

  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();
$postId = null;
if($_POST){
    $postData = $_POST;
    $postId = $postData['id_delete'];

}

?>
<?php
$title = 'Print all comments';
require 'templates/boilerplate.php'
?>
<body>
<?php require 'templates/title.php' ?>
    <style>
        table{
            width:80%;
            margin:auto;
        }

table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th , td{
    padding:0.25em;
}
form{
    width:80%;
    margin: 10px auto;
    border: 1px solid blue;
    text-align: center;
}
    </style>
    <h2>Comments</h2>
    <?php 
    if($postId){
        echo '<div> Post Data: ' . $postId . '</div>'; 
    }

    ?>

    <form method="post">
    <label for="id_delete"> Enter Id to delete that entry </label>
  <input type="number" min="0" step="1" id="id_delete" name="id_delete"/>
    <input type="submit" value="Submit"/>
    </form>
    <?php 

    $count = 0;
    
    echo '<table>';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
       
        if($count === 0){ 
            echo '<tr>'; 
        foreach($row as $x => $x_value){
            echo '<th>' . $x . '</th>';
        }
        echo '</tr>'; 
        }
        echo '<tr>'; 
        foreach($row as $x => $x_value){
            echo  '<td>' . $x_value . '</td>';
        }
        echo '</tr>'; 

    
        $count +=1;

        }
        echo '</table>';

        
    ?>
        
</body>
</html>