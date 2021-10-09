<?php require_once 'lib/common.php';
// test for minimum version of php
if(version_compare(PHP_VERSION, '5.3.7') < 0){
    throw new Exception(
        'This system needs php 5.3.7 or later'
    );
}

function tryLogin(PDO $pdo, $username, $password){
$sql = "
select password 
from user 
where username = :username
";
$stmt = $pdo -> prepare($sql);
$stmt -> execute(
    array('username' => $username,)
);
$hash = $stmt -> fetchColumn();
$success = password_verify($password, $hash);

return $success;

}

function login($username){
    session_regenerate_id();
    $_SESSION['logged-in_username'] = $username;
}

// Handing form posting
$username = '';
session_start();
if($_POST){
   
    $pdo=getPDO();
    // redirect only if password and name is correct 
    
    $username = $_POST['username'];
    $ok = tryLogin($pdo , $username, $_POST['password']);
    if($ok){
        login($username);
        redirectAndExit('index.php');
    }
}

?>


<?php 
$title = 'Log-in Page';
require 'templates/boilerplate.php' ?>
<body>
<?php require 'templates/title.php' ?>

<?php // If we have a username and have not redirected , then something went wrong ?>
<?php if ($username): ?>
    <div class="box error">
    The username or password is incorrect , please try again
</div>
    <?php endif ?>

<p> Log in here </p>
<form method="post">
    <p>Username: <input type="text" name="username" value='<?php echo htmlEscape($username) ?>' /></p>
    <p>Password: <input type="password" name="password" /></p>
    <p><input type="submit" name="submit" value="Log-in" /></p>
</form>


</body>
</html>