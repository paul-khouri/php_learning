<?php
//Get the PDO DSN string
//Find the database
require_once 'lib/common.php';
require_once 'lib/view-post-common.php';
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
//swap carriage returns for paragraph breaks
$bodyText =  htmlEscape($row['body'] ) ;
$paraText = str_replace("\n", "</p><p>", $bodyText);
$error = "Row found";
if(!$row){
  $error= "No row found";
  redirectAndExit('index.php?not-found=1');
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Blog Application : <?php echo htmlspecialchars($row['title'],ENT_HTML5,'UTF-8') ?></title>
  <meta name="description" content="A simple HTML5 Template for new projects.">
  <meta name="author" content="SitePoint">
</head>

<body>
  <?php require 'templates/title.php' ?>
  <h2><?php echo $error ?></h2>
      <h2><?php echo $postId ?></h2>
      <h2>
        <?php echo htmlEscape($row['title']) ?>
      </h2>
    <div>
      <?php echo $row['created_at'] ?>
    </div>
      <p>
        <?php echo  $paraText ?>
      </p>
    <h3> <?php echo countCommentsForPost($postId) ?> comments</h3>
    <?php foreach (getCommentsForPost($postId) as $comment): ?>
      <?php // split up with horizontal rule ?>
      <hr/>
      <div class="comment">
        <div class="comment-meta">
          Comment from
          <?php echo htmlEscape($comment['name']) ?> on 
          <?php echo convertSQliteDate($comment['created_at']) ?>
        </div>
        <div class="comment-body">
          <?php echo htmlEscape($comment['text']) ?>
        </div>
      </div>
    <?php endforeach ?>

</body>
</html>