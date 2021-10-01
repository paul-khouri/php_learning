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
    <h1>Blog Title </h1>
    <p>This paragraph summarises what the blog is about</p>
    <?php for ($postId = 1; $postId <= 3; $postId ++): ?>
    <h2>Article <?php echo $postId ?> title </h2>
    <p> A paragraph summarising article <?php echo $postId ?> </p>
    <p> <a href="#">Read More ...</a> </p>
    <?php endfor ?>


</body>
</html>