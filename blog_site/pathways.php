<?php
$host = $_SERVER['HTTP_HOST'];
$script = $_SERVER['REQUEST_URI'];
$relativeUrl = $_SERVER['PHP_SELF'];
$fullURL = $host;
$redirect = 'Location: http://' . $fullURL . '/';
//header('Location: http://localhost:9000' );
header($redirect );
//exit();
?>

<?php 
$title = 'Pathways Page';
require 'templates/boilerplate.php' ?>


<body>
    <?php
    echo $host . '<br/>';
    echo $script . '<br/>';
    echo $relativeUrl . '<br/>';
    echo $redirect . '<br/>';
    ?>

</body>
</html>