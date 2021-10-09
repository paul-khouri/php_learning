<?php
//Get the PDO DSN string
//Find the database
require_once 'lib/common.php';
require_once 'lib/view-post-common.php';
session_start();
// Get the post id
if ( isset( $_GET['post_id'] ) )
{
  $postId = $_GET['post_id'];
}
else{
  $postId = 0;
}

//connect to the database , run a query, handle errors
$pdo = getPDO();
$row = getPostRow($pdo, $postId);

if(!$row){
  // if no row is found redirect back to index with post information
  // error will be displayed at index.php
  redirectAndExit('index.php?not-found=1');
}
//-----------------------------------------------------------------------


$errors = null;
  if($_POST){
    $postData = $_POST;
    switch($_GET['action']){

      case 'add-comment': 

        $commentData = array(
          'name' => $_POST['comment-name'],
          'website' => $_POST['comment-website'],
          'text' => $_POST['comment-text'],
        );
        $errors = addCommentToPost($pdo, $postId, $commentData);
          //if no validation errors
        if(!$errors){
          redirectAndExit('view-post.php?post_id=' . $postId);
        }

        break;
      case 'delete-comment':
        if(isLoggedIn()){
          $deleteResponse = $_POST['delete-comment'];
          $keys = array_keys($deleteResponse);
          $deleteCommentId = $keys[0];
          deleteComment($pdo,$postId , $deleteCommentId);
          redirectAndExit('view-post.php?post_id=' . $postId);
        }

        break;


    }

    }else{
      $commentData = array(
          'name' => '',
          'website' => '',
          'text' => '',
      );
  }

?>

<?php 
$page_title = 'View Post Page';
require_once 'templates/boilerplate.php';
?>

<body>
  <?php require 'templates/title.php' ?>
  <?php
  if($postId !== 0){
    echo "<h1>" . $_GET['action'] . "</h1>";
  }
  ?>

      <!-- print out blog entry -->
    <div class="post">
      <h2>
        <?php echo htmlEscape($row['title']) ?>
      </h2>
      <div class="date">
        <?php echo $row['created_at'] ?>
      </div>
      <p>
        <?php echo  convertNewLinesToParagraphs($row['body']) ?>
      </p>
    </div>
     <!-- print out comments -->
    <form 
    action="view-post.php?action=delete-comment&amp;post_id=<?php echo $postId ?>&amp;"
    method="post"
    class="comment-list">
      <h3> <?php echo countCommentsForPost($pdo , $postId) ?> comments</h3>
      <?php foreach (getCommentsForPost($pdo, $postId) as $comment): ?>
        <div class="comment">
          <div class="comment-meta">
            Comment from
            <?php echo htmlEscape($comment['name']) ?> on 
            <?php echo convertSQliteDate($comment['created_at']) ?>
            <?php if(isLoggedIn()): ?>
              <input type="submit" name="delete-comment[<?php echo $comment['id'] ?>]" value="Delete" />
              <?php endif ?>
          </div>
          <div class="comment-body">
            <?php echo convertNewLinesToParagraphs($comment['text']) ?>
          </div>
        </div>
      <?php endforeach ?>
            </form>

    <!-- begin form -->

    <?php // rule off and separate page sections ?>
    <hr/>
    <?php // report any errors in a list ?>
    <?php if ($errors): ?>
      <div class="box error comment-margin">Errors
      <ul>
        <?php foreach ($errors as $error): ?>
        <li><?php echo $error ?></li>
        <?php endforeach ?>
      </ul>
      </div>
    <?php endif ?>
    <h3> Add your comment </h3>
 

    <form 
    action="view-post.php?action=add-comment&amp;post_id=<?php echo $postId ?>"
    method="post" 
    class="comment-form user-form">
    <p>
      <label for="comment-name"> Name </label>
      <input type="text" id="comment-name" name="comment-name" value="<?php echo htmlEscape($commentData['name']) ?>"  />
      <p> error statement </p>
    </p>
    <p>
      <label for="comment-website"> Website </label>
      <input type="text" id="comment-website" name="comment-website" value="<?php echo htmlEscape($commentData['website']) ?>" />
      </p>
    <p>
      <label for="comment-text"> Comment: </label>
      <textarea id="comment-text" name="comment-text" rows="8" columns="70" ><?php echo htmlEscape($commentData['text']) ?></textarea>
    </p>
      <input type="submit" value="Submit Comment"/>
    </form>

</body>
</html>