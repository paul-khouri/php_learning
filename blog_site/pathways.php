<?php
$host = $_SERVER['HTTP_HOST'];
$script = $_SERVER['REQUEST_URI'];
$relativeUrl = $_SERVER['PHP_SELF'];
$urlFolder = substr($relativeUrl, 0,strrpos($relativeUrl, '/') + 1);
$fullURL = 'Location: http://' . $host . $urlFolder . $script ;

$fullURLHost = $host;
$redirect = 'Location: http://' . $fullURLHost . '/';
//header('Location: http://localhost:9000' );
//header($redirect );
//exit();
?>

<?php 
$title = 'Pathways Page';
require 'templates/boilerplate.php' ?>


<body>
    <?php
    echo 'Host: ' . $host . '<br/>';
    echo 'URI: ' . $script . '<br/>';
    echo 'Self URL: ' . $relativeUrl . '<br/>';
    echo 'Redirect location: ' . $redirect . '<br/>';
    echo 'URL folder: ' . $urlFolder . '<br/>';
    echo 'Full URL: ' . $fullURL . '<br/>';
    ?>

</body>
</html>