<div class="top-menu">
    <div class="menu-options">
        <?php if(isLoggedIn()): ?>
            <a href='edit-post.php'>Edit Post</a>
            Hello <?php echo htmlEscape(getAuthUser()) ?> , your user id is:  <?php echo htmlEscape( getAuthUserId( getPDO()) ) ?>.
            <a href="log-out.php">Log Out</a>
            <?php else: ?>
            <a href="log-in.php">Log in</a>
        <?php endif ?>
    </div>
</div>
<a href='index.php'><h1>Paul's Blog </h1></a>
    <p>An collection of entries about different topics</p>
    <ul>
        
        <li><a href="print_table.php?tablename=comment">Comments Print</a>
        <li><a href="print_table.php?tablename=post">Posts Print</a>
        <li><a href="print_table.php?tablename=user">User Print</a>
        <li><a href="pathways.php">Pathways</a>
        <li><a href="study_page.php">Study Page</a>
        <li><a href="db-meta.php">Database metadata</a>
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
