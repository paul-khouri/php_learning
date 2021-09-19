<?php
//Get the PDO DSN string
//Find the database
require_once 'lib/common.php';
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
$stmt = $pdo -> prepare(
    'select title, created_at , body
    from post
    where id=:id'
);
if($stmt === false){
    {
        throw new Exception("there was a problem preparing this query");
      }
}
$result = $stmt -> execute(
    array('id' => $postId, )
);

if($result === false){
    {
        throw new Exception("there was a problem running this query");
      }
}

$row = $stmt -> fetch(PDO::FETCH_ASSOC);
//swap carriage returns for paragraph breaks
$bodyText =  htmlEscape($row['body'] ) ;
$paraText = str_replace("\n", "</p><p>", $bodyText);
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

</body>
</html>