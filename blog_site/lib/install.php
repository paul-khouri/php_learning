<?php
//---------
function installBlog(PDO $pdo){

//Get a couple of useful project paths
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
   
    //taking passed pdo
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


/**
 * Creates new user in the database
 * 
 * @param PDO $pdo
 * @param string $username
 * @param integer $length
 * @return array Duple of (password, error) 
 */
function createUser(PDO $pdo ,$username, $length =10){

    // create a random password
    $alphabet=range(ord('A'), ord('Z'));
    $alphabetLength = count($alphabet);

    $password = '';
    for($i = 0 ; $i < $length ; $i++){
        $letterCode = $alphabet[rand(0, $alphabetLength - 1)];
        $password .= chr($letterCode);
    }

    $error = '';

    // insert credentials into database
    $sql = "
    update user 
    set password = :password, created_at = :created_at , is_enabled = 1
    where username = :username
    ";
    $stmt = $pdo -> prepare($sql);
    if($stmt === false){
        $error = "could not prepare user update";
    }
    if(!$error){
//GIMBCBDLDM
        $hash = password_hash($password , PASSWORD_DEFAULT);
        if($hash === false){
            $error = 'Password hashing failed';
        }
        $result = $stmt -> execute(
            
            array( 'username' => $username,
            'password' => $hash,
            'created_at' => getSqlDateForNow(),
             )
        );
        if($result === false){
            $error = 'Could not run user update';
        }
    }
    if($error){
        $password = '';
    }

    return array($password, $error);

}