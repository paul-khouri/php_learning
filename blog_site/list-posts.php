<?php
require_once 'lib/common.php';

session_start();
if(!isLoggedIn()){
    redirectAndExit('index.php');
}

//connect to the database , run a query, handle errors
$pdo = getPDO();
$posts = getAllPosts($pdo);
/**
 * Tries to delete the specified post
 * 
 * @param PDO $pdo
 * @param integer $postId
 * @return boolean true on successful deletion
 * @throws Exception
 */
function deletePost(PDO $pdo, $postId){
    $sql = "delete from post where id=:id";
    $stmt = $pdo -> prepare($sql);
    if($stmt === false){
        throw new Exception("Problem preparing delete query");
    }
    $result = $stmt -> execute(
        array('id' => $postId,)
    );

    return $result !== false; 

}
$deleteResponse ='';
if($_POST){
    $deleteResponse = $_POST['delete-post'];
    if($deleteResponse){
        
        $keys = array_keys($deleteResponse);
        $deletePostId = $keys[0];

        if($deletePostId){
            deletePost(getPDO(), $deletePostId);
            redirectAndExit('list-posts.php');
        }
    }
}

?>
<?php 
$page_title = "List of all posts";
require_once 'templates/boilerplate.php' ?>
<body>
    <?php require 'templates/title.php' ?>
    <h1><?php 

        if($deleteResponse){

            $keys = array_keys($deleteResponse);
            echo $keys[0];

            foreach($deleteResponse as $d){
                echo $d;
            }
        }
    ?></h1>
    <h1>Post List </h1>
    <p>You have  <?php echo count($posts) ?> posts.</p>
    <form method="post">
        <table id="post-list">
            <tbody>
                <?php foreach ($posts as $post): ?>
                    
                <tr>
                    <td> <?php echo htmlEscape($post['title']) ?> </td>
                    <td> <?php echo convertSQliteDate($post['created_at']) ?></td>
                    <td><a href="edit-post.php?post_id=<?php echo $post['id'] ?>">Edit</a></td>
                    <td><input type="submit" name="delete-post[ <?php echo $post['id'] ?> ]" value="Delete" /></td>
                </tr>
                <?php endforeach ?>

            </tbody>



        </table>



    </form>




</body>
</html>