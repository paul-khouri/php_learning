<?php
//Get the PDO DSN string
//Find the database
require_once 'lib/common.php';

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
?>



<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Blog Application</title>
  <meta name="description" content="A simple HTML5 Template for new projects.">
  <meta name="author" content="SitePoint">
</head>

<body>
    <?php require 'templates/title.php' ?>
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
      <h2>
        <?php echo htmlEscape($row['title']) ?>
      </h2>
      <div>
        <?php echo convertSQliteDate($row['created_at']) ?>
      </div>
      <p>
        <?php echo htmlEscape($row['body'] )?>
      </p>
      <p><a href="view-post.php?post_id=<?php echo $row['id'] ?>">Read More ...</a></p>
    <?php endwhile ?>


</body>
</html>