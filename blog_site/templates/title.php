<div style="float:right; border: 1px solid gray; padding:0.5em;">
<?php if(isLoggedIn()): ?>
    Hello <?php echo htmlEscape(getAuthUser()) ?>.
    <a href="log-out.php">Log Out</a>
    <?php else: ?>
    <a href="log-in.php">Log in</a>
    <?php endif ?>

</div>
<a href='index.php'><h1>Paul's Blog </h1></a>
    <p>An collection of entries about different topics</p>
    <ul>
        <li><a href="pathways.php">Pathways</a>
        <li><a href="comments_print.php?tablename=comment">Comments Print</a>
        <li><a href="comments_print.php?tablename=post">Posts Print</a>
        <li><a href="comments_print.php?tablename=user">User Print</a>
        <li><a href="study_page.php">Study Page</a>
    </ul>
    <hr>
    <?php 
if(session_status() === 2){
$sessionVars = print_r($_SESSION, true);
echo '<p> Session Variables: ' . $sessionVars . '</p>';
echo '<p> Session Satus (2 is active): ' . session_status() . '</p>';
}
 ?>
    <hr/>
