<?php
require_once 'lib/common.php';
require_once 'lib/edit-post.php';
require_once 'lib/view-post-common.php';
session_start();
// only authorised users can access
if(!isLoggedIn()){
    redirectAndExit('index.php');
}

$title = '';
$body = '';
$pdo = getPDO();


$postId = null;
if(isset($_GET['post_id'])){
    $post = getPostRow($pdo, $_GET['post_id']);
    if($post){
        $title = $post['title'];
        $body = $post['body'];
        $postId = $_GET['post_id'];

    }
}

// post operation handle
$errors = array();
if($_POST){
    $title = $_POST['post-title'];
    if(!$title){
        $errors[] = "The post must have a title";
    }
    $body = $_POST['post-body'];
    if(!$body){
        $errors[] = "The post must have a body";
    }

    if(!$errors){
        $pdo = getPDO();

        if($postId){

            editPost($pdo,$title, $body, $postId);

        }else{

            $userId = getAuthUserId($pdo);
            $postId = addPost($pdo, $title, $body, $userId);
            if($postId === false){
                $errors[] = "Post operation failed";
            }

        }
    }



    if(!$errors){
        redirectAndExit('edit-post.php?post_id='.$postId);
    }

}

$page_title = 'Edit Post Page';
require 'templates/boilerplate.php'
?>

<body>
<?php require 'templates/title.php' ?>

<?php if(isset($_GET['post_id'])): ?>
    <h1>Edit Post</h1>
<?php else: ?>
    <h1>New Post</h1>
<?php endif ?>


<?php if($errors): ?>
    <div class="error box">
    <ul>
        <?php foreach($errors as $error): ?>
            <li><?php echo $error ?> </li>
            <?php endforeach ?>
    </ul>
    </div>
    <?php endif ?>

<form method="post" class="post-form user-form" style="border: 1px solid green;">
    <div>
        <label for="post-title"> Title: </label>
        <input id="post-title" name="post-title" type="text" value="<?php echo htmlEscape($title) ?>" />        
    </div>
    <div>
        <label for="post-body">Body: </label>
        <textarea id="post-body" name="post-body" rows="12" cols="70"><?php echo htmlEscape($body) ?></textarea>
    </div>
    <div>
        <input type="submit" value="Save Post" />
        <a href="index.php"> Cancel </a>
    </div>
</form> 


</body>
</html>