<?php require_once 'lib/common.php';
session_start();
function logout(){
    unset($_SESSION['logged-in_username']);
    redirectAndExit('index.php');
}
logout();
?>