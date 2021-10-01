<?php
require_once "lib/common.php";
//-------------------------------------------------------------

if ( isset( $_GET['tablename'] ) )
{
  $tablename = $_GET['tablename'];
}
else{
  $tablename = null;
}

//-------------------------------------------------------------

$pdo = getPDO();


//-------------------------------------------------------------

function deleteRow(PDO $pdo, $ID, $tablename){
    $errors = null;
    switch($tablename)
        {
            case 'comment':
                $tbl = 'comment';
                break;
            case 'post':
                $tbl = 'post';
                break;
            default:
                throw new Exception('table name ' . $tablename . ' not in database');
        }
    $sql = "delete from comment where id= :Id";
    $stmt = $pdo -> prepare($sql);
    if($stmt === false){
        throw new Exception('Cannot prepare statement for deletion');
      };
    $stmt -> execute(array('Id' => $ID,));
    if($stmt === false){
        throw new Exception('Cannot execute deletion');
      };
    return $errors;

}


$postId = null;
$deletionResponse = null;
if($_POST){
    $postData = $_POST;
    $postId = $postData['id_delete'];
    $errors = deleteRow($pdo, $postId, $tablename);
    if(!$errors){
        $deletionResponse = 'The row with id ' . $postId . ' has been deleted';
    }

}

//-------------------------------------------------------------

function selectAllFromTable(PDO $pdo , string $tablename){
    //Table and Column names CANNOT be replaced by parameters in PDO.
            switch($tablename)
            {
                case 'comment':
                    $tbl = 'comment';
                    break;
                case 'post':
                    $tbl = 'post';
                    break;
                default:
                    throw new Exception('table name ' . $tablename . ' not in database');
            }
    
    
        $sql="select *
        from $tbl
        order by created_at desc";
    
      
      
        $stmt = $pdo -> prepare($sql);
        if($stmt === false){
            throw new Exception('Cannot prepare statement to insert comment');
          };
        $stmt -> execute();
        if($stmt === false){
            throw new Exception('Cannot run query');
          };
        $result = $stmt;
        return $result;
    
    }
    $result = selectAllFromTable($pdo , $tablename);
    

//-------------------------------------------------------------

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
form, .feedback div{
    width:80%;
    margin: 10px auto;
    border: 1px solid blue;
    text-align: center;
}
    </style>
    <h2>Comments</h2>
    <div class="feedback">
    <?php 
    if($postId){
        echo '<div> Post Data: ' . $postId . '</div>'; 
    }
    if($deletionResponse){
        echo '<div> ' . $deletionResponse . '</div>'; 
    }
    if($errors){
        echo '<div> ' . $errors . '</div>'; 
    }
    ?>
    </div>

    <form method="post">
    <label for="id_delete"> Enter Id to delete that entry </label>
  <input type="number" min="0" step="1" id="id_delete" name="id_delete"/>
    <input type="submit" value="Submit"/>
    </form>
    <?php 

    $count = 0;
    echo '<table>';
    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
       
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