<?php

require_once 'lib/common.php';
session_start();

//connect to the database , run a query, handle errors
$pdo = getPDO();
$posts = getAllPosts($pdo);

$notFound = isset($_GET['not-found']);
if ($notFound){
  $notFoundVar = $notFound;
}
else{
  $notFoundVar = "not not-found";
}
?>



<?php 
$page_title = "Home Page";
require_once 'templates/boilerplate.php' ?>

<body>
    <?php require 'templates/title.php' ?>
    <p>Not found variable : <?php echo $notFoundVar ?></p>
    <?php if ($notFound): ?>
      <div class="box error"> Error: cannot find requested blog post </div>
      <?php endif ?>

      <div class="post-list">
        <?php foreach ($posts as $post): ?>
          <div class="post-synopsis">
              <h2>
                <?php echo htmlEscape($post['title']) ?>
              </h2>
              <div class="meta">
                <?php echo convertSQliteDate($post['created_at']) ?>
                ( <?php  echo countCommentsForPost($pdo , $post['id'])  ?> comments )
              </div>
              <p>
                <?php echo htmlEscape($post['body'] )?>
              </p>
              <div class="post-controls">
                <p><a href="view-post.php?post_id=<?php echo $post['id'] ?>">Read More ...</a>
                <?php if(isLoggedIn()): ?>
                  <p><a href="edit-post.php?post_id=<?php echo $post['id'] ?>">Edit Post ...</a>
                <?php endif ?>
              
              </p>
              </div>
          </div>
      <?php endforeach ?>
    </div>
<hr/>
<p><a href="view-post.php?post_id=7">Test for request cannot be found</a></p>




</body>
</html>