<?php
require_once 'lib/common.php';
require_once 'lib/install.php';

// store in session to survive redirect to self
session_start();


//only run installer if responding to the form
if($_POST){
    // run the install
    $pdo =getPDO();
    list($rowCounts, $error)=installBlog($pdo);
 
    $password = '';
    if(!$error){
        $username = 'admin';
        list($password, $error) = createUser($pdo, $username);
    }

    $_SESSION['count'] = $rowCounts;
    $_SESSION['error'] = $error;
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    $_SESSION['try-install'] = true;
 

    // redirect from POST to GET
    redirectAndExit('install.php');
    
}


// see if just installed
$attempted = false;
if( isset( $_SESSION['try-install'] ) ){
    $attempted = true;
    $count = $_SESSION['count'];
    $error = $_SESSION['error'];
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
  

    //unset variables so only reported once
    unset( $_SESSION['count']);
    unset( $_SESSION['error']);
    unset( $_SESSION['username']);
    unset( $_SESSION['password']);
    unset( $_SESSION['try-install']);


}

//---------

?>

<?php require_once 'templates/boilerplate.php' ?>
  
<body>
<?php if ($attempted): ?>

    <?php if ($error): ?>
        <div class="error box">
            <?php echo $error ?>
        </div>
    <?php else: ?>
        <div class="success box">
            The database and demo data was succefully created.
            <?php //Report the counts for each table ?>
            <?php foreach (array('post', 'comment') as $tableName): ?>
                <?php if (isset($count[$tableName])): ?>
                    <?php // prints the count ?>
                    <?php echo $count[$tableName] ?> new
                    <?php // prints the name of the thing ?>
                    <?php echo $tableName ?>s were created
                <?php endif ?>
            <?php endforeach ?>
            <?php // Report new password ?>
            The new ' <?php echo htmlEscape($username) ?> ' password 
            is  <span class="install-password"> <?php echo htmlEscape($password) ?> </span> (copy to clipboard)
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
