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

function addPost(PDO $pdo , $title , $body , $userId){
    //prepare insert query
    $sql = "insert into post(title, body, user_id , created_at)
    values(:title, :body , :user_id , :created_at) ";
    $stmt = $pdo -> prepare($sql);
    if($stmt === false){
        throw new Exception(" Could not prepare post insert query");
    }
    $result = $stmt -> execute(
        array('title' => $title, 'body' => $body , 'user_id' => $userId, 'created_at' => getSqlDateForNow(),)
    );
    if($result === false){
        throw new Exception("Could not execute post query");
    }

    return $pdo -> lastInsertId();
}

function editPost(PDO $pdo , $title , $body , $postId){
    // prepare insert query
    $sql="update 
    post
    set 
    title =:title,
    body=:body
    where
    id = :post_id";

    $stmt = $pdo -> prepare($sql);
    if($stmt === false){
        throw new Exception(" Could not prepare post update query");
    }

    $result = $stmt -> execute(
        array('title' => $title, 'body' => $body , 'post_id' => $postId,)
    );
    if($result === false){
        throw new Exception("Could not execute post update query");
    }

    return true;

}
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
    </div>
</form> 


</body>
</html>