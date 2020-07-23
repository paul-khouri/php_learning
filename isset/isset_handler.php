<!DOCTYPE html>
<html>
<head>
<title>Isset Handler</title>
</head>
<body>
    <h1>Isset Handler </h1>
    <?php
    if ( isset( $_POST['definition'] ) ){
    $definition = $_POST['definition'];
    } 
    else
    {
        $definition = NULL; 
    }

    if($definition != NULL){

        if($definition != "Scripting"){
            echo "$definition is incorrect";
        }
        else{
            echo "$definition is the correct answer";
        }

    }else{
        echo 'You must select one answer';
    }
 
?>

    </body>
</html>