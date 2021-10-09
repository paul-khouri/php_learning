<?php require_once 'lib/common.php';
session_start();
function logout(){
    unset($_SESSION['logged-in_username']);
    session_unset();
    redirectAndExit('index.php');
}
logout();
?>