<?php
require_once "lib/common.php";
session_start();
//-------------------------------------------------------------
$title = '';
if ( isset( $_GET['tablename'] ) )
{
  $tablename = $_GET['tablename'];
  $title = $tablename . ' table';
 
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
            case 'user':
                $tbl = 'user';
                break;
            default:
                throw new Exception('table name ' . $tablename . ' not in database');
        }
    if($tbl === 'post'){
        $sql = " delete from $tbl where id = :Id";
    }
    else{
    $sql = "delete from $tbl where id= :Id";
    }
    $stmt = $pdo -> prepare($sql);
    if($stmt === false){
        throw new Exception('Cannot prepare statement for deletion');
      };
    $result = $stmt -> execute(array('Id' => $ID,));
    if($result === false){
        //throw new Exception('Cannot execute deletion');
        $errors = "Deletion could not be executed (Pragma error ?)";
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
    }else{
        $deletionResponse = $errors;
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
                case 'user':
                    $tbl = 'user';
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
$page_title = "Print Table Data";
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
    <h2><?php echo $title ?></h2>
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