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

if(!$row){
 
  // if no row is found redirect back to index with post information
  // error will be displayed at index
  redirectAndExit('index.php?not-found=1');
}
//-------------------------------
// managing comment form arrival
function addCommentToPost(PDO $pdo , $postId , array $commentData){
  //validation
  $errors=array();
  if(empty($commentData['name'])){
    $errors['name'] = "A name is required";
  }
  if(empty($commentData['text'])){
    $errors['text'] = "A comment is required";
  }
if(!$errors){
  // insert statement with parameters
  $sql = "insert into comment(name, website, text, created_at,  post_id)
  values(:name, :website, :text, :created_at , :post_id)
  ";
  /*
  $sql = "insert into comment(name, website, text, created_at,  post_id)
  values('Paul', 'gog', 'hello' , datetime('now') , 2)
  ";
  */

  $test = array(
    'name' => 'paul',
    'website' => 'gogalong',
    'text' => 'hello its a new one',
    'post_id' => 2,
    'created_at' => date('Y-d-m H:m:s'),
  );


  $stmt = $pdo -> prepare($sql);
  if($stmt === false){
    throw new Exception('Cannot prepare statement to insert comment');
  };
  //$result = $stmt -> execute();
  $createdTimeStamp = date('Y-m-d H:m:s');
  //$result = $stmt -> execute($test);
  
  $result = $stmt -> execute(
    array_merge($commentData, array('post_id' => $postId, 'created_at' => $createdTimeStamp,) )
  );
  
  

  if($result === false){
    // @todo database level error for user
    //throw new Exception('Cannot prepare statement to insert comment');
    $errorInfo = $stmt -> errorInfo();
    if($errorInfo){
      $errors[] = $errorInfo[2];
    }
  }

}
 
  return $errors;

  //if no validation errors

}

$errors = null;
if($_POST){
  //$errors=["No name" , "No website" , "No comment" ];
  $postData = $_POST;
  $commentData = array(
    'name' => $_POST['comment-name'],
    'website' => $_POST['comment-website'],
    'text' => $_POST['comment-text'],
  );
  $errors = addCommentToPost($pdo, $postId, $commentData);
  if(!$errors){
    redirectAndExit('view-post.php?post_id=' . $postId);
  }
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
      <?php if($postData): ?>
      <h2><?php echo $postData["comment-name"] ?></h2>
      <?php foreach($postData as $x => $x_value): ?>
        <?php echo "Key: " . $x . ", Value: " . $x_value; ?>
        <?php echo "<br/>"; ?>
        <?php endforeach ?>
      <?php endif ?>

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
    <?php // rule off and separate page sections ?>
    <hr/>
    <?php // report any errors in a list ?>
    <?php if ($errors): ?>
      <div style="border: 1px solid #ff6666; padding: 1em;">Errors
      <ul>
        <?php foreach ($errors as $error): ?>
        <li><?php echo $error ?></li>
        <?php endforeach ?>
      </ul>
      </div>
    <?php endif ?>
    <h3> Add your comment </h3>
    <style> 
    label{
      width:5em;
      border: 1px solid red;
      display: inline-block;
      text-align: right;
    }
  </style>
  <?php
  $name = "Harold";
  $website = "http://google.com";
  $comment = "I totally agree with you";
  ?>
    <form method="post">
<p>
  <label for="comment-name"> Name </label>
  <input type="text" id="comment-name" name="comment-name" value="<?php echo $name ?>"  />
  <p> error statement </p>
</p>
<p>
  <label for="comment-website"> Website </label>
  <input type="text" id="comment-website" name="comment-website" value="<?php echo $website ?>" />
</p>
<p>
  <label for="comment-text"> Comment: </label>
  <textarea id="comment-text" name="comment-text" rows="8" columns="70" > <?php echo $comment ?> </textarea>
</p>
<input type="submit" value="Submit Comment"/>

    </form>

</body>
</html>