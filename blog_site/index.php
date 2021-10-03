<?php

require_once 'lib/common.php';
session_start();

//connect to the database , run a query, handle errors
$pdo = getPDO();
$stmt = $pdo -> query(
  'select id, title, created_at, body
  from post
  order by created_at desc'
);
if($stmt === false){
  {
    throw new Exception("there was a problem running this query");
  }
}

$notFound = isset($_GET['not-found']);
if ($notFound){
  $notFoundVar = $notFound;
}
else{
  $notFoundVar = "not not-found";
}
?>



<?php require_once 'templates/boilerplate.php' ?>

<body>
    <?php require 'templates/title.php' ?>
    <p>Not found variable : <?php echo $notFoundVar ?></p>
    <?php if ($notFound): ?>
      <div class="box error"> Error: cannot find requested blog post </div>
      <?php endif ?>

      <div class="post-list">
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
          <div class="post-synopsis">
              <h2>
                <?php echo htmlEscape($row['title']) ?>
              </h2>
              <div class="meta">
                <?php echo convertSQliteDate($row['created_at']) ?>
                ( <?php  echo countCommentsForPost($pdo , $row['id'])  ?> comments )
              </div>
              <p>
                <?php echo htmlEscape($row['body'] )?>
              </p>
              <div class="read-more">
                <p><a href="view-post.php?post_id=<?php echo $row['id'] ?>">Read More ...</a></p>
              </div>
          </div>
      <?php endwhile ?>
    </div>
<hr/>
<p><a href="view-post.php?post_id=7">Test for request cannot be found</a></p>




</body>
</html>