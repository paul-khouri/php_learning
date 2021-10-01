<?php
require_once 'lib/common.php';
//---------
function installBlog(){

    //Get the PDO DSN string
$root = getRootPath();
$database = getDatabasePath() ;


$error = "";
//avoid inadvertant resetting of the database (manual deletion required)
if( is_readable($database) && filesize($database) >0)
{
    $error="A database is already present, please manually delete for fresh installation";
    
}



if(!$error){
    $createdOK = @touch($database);
    if(!$createdOK){

        $error = sprintf(
            'Could not create data base at location \'%s\' ',dirname($database)
        );

    }
}

// database created
// get instatantiation SQL commands
if(!$error){
    $sql = file_get_contents($root . '/data/init.sql');
    if($sql === false){
        $error = 'Cannot find SQL file';
    }
}

// connect to database and try to run SQL commands
if(!$error){
    $pdo = getPDO();
    $result = $pdo -> exec($sql);
    if($result === false){
        $error = "Could not not run SQL: " . print_r($pdo-> errorInfo(),true);
    }
}

// count rows created if any
$count = array();

foreach(array('post', 'comment') as $tableName){
    if(!$error){
        $sql = "select count(*) as c from " . $tableName;
        $stmt = $pdo -> query($sql);
            if($stmt){
                // store each count in an associative array
                $count[$tableName] = $stmt -> fetchColumn();
            }
    }
}



return array($count,$error);
}

// store in session to survive redirect to self
session_start();


//only run installer if responding to the form
if($_POST){
    // run the install
    list($_SESSION['count'],$_SESSION['error'])=installBlog();
    // redirect from POST to GET
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['REQUEST_URI'];
    header('Location: http://' . $host . $script);
    exit();
}


// see if just installed
$attempted = false;
if($_SESSION){
    $attempted = true;
    $count = $_SESSION['count'];
    $error = $_SESSION['error'];
  

    //unset variables so only reported once
    unset($_SESSION['count']);
    unset( $SESSION['error']);

}

session_destroy();
unset($_SESSION['count']);
unset( $SESSION['error']);



//---------


?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Database Install</title>
  <meta name="description" content="A simple HTML5 Template for new projects.">
  <meta name="author" content="SitePoint">
<style>
    .box{
        border: 1px dotted silver;
        border-radius: 5px;
        padding: 4px;
    }
    .success{
        background-color: #88ff88; 

    }
    .error{
        background-color:  #ff6666;
       
    }


</style>

</head>
<body>
<?php if ($attempted): ?>

    <?php if ($error): ?>
        <div class="error box">
            <?php echo $error ?>
        </div>
    <?php else: ?>
        <div class="success box">
            The database and demo data was succefully created.
            <?php foreach (array('post', 'comment') as $tableName): ?>
                <?php if (isset($count[$tableName])): ?>
                    <?php // prints the count ?>
                    <?php echo $count[$tableName] ?> new
                    <?php // prints the name of the thing ?>
                    <?php echo $tableName ?>s were created
      


                <?php endif ?>
            <?php endforeach ?>
            </div>
            <p>
            <a href="index.php">View the Blog</a>, or <a href="install.php">Install again</a>
        </p>
   
   
            <?php endif ?>

    <?php else: ?>
        <p> Click the install button to reset the database </p>
        <form method="post">
            <input name="install" type="submit" value="Install"/>
        </form>
    <?php endif ?>
</body>
</html>
