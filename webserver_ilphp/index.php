<!DOCTYPE html>
<html>
    <head>
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
    <?php
for($x=0 ; $x<3 ; $x ++){
    echo "
    <h1>Blog Title</h1>
    <p>What this is about</p>
    <h2>Article $x</h2>
    <div>dd/mm/yy</div>
    <p> Summary paragraph </p>
    <a href='https://www.w3schools.com/php/php_looping_for.asp'>Read More</a><p>
    </p>
    ";


}

    ?>
 
    </body>
</html>