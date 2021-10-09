<?php
require_once 'lib/common.php';

session_start();
if(!isLoggedIn()){
    redirectAndExit('index.php');
}
?>
<?php 
$page_title = "List of all posts";
require_once 'templates/boilerplate.php' ?>
<body>
    <?php require 'templates/title.php' ?>
    <h1>Post List </h1>
    <form method="post">
        <table id="post-list">
            <tbody>
                <tr>
                    <td> Title of First Post </td>
                    <td><a href="edit-post.php?post_id=1">Edit</a></td>
                    <td><input type="submit" name="post[1]" value="Delete" /></td>
                </tr>


            </tbody>



        </table>



    </form>




</body>
</html>