<?php 
require_once 'lib/common.php';
session_start();
$_SESSION['initial'] = "Initial variable";
$_SESSION['second'] = "Second variable";

$page_title = 'Study Page';
require 'templates/boilerplate.php' ?>
<style>
table{
            width:50%;
            margin:auto;
        }

table, th, td {
  border: 1px solid #eeeeee;
  border-collapse: collapse;
}
th , td{
    padding:0.25em;
    border-bottom: 1px solid black;
}
</style>

<body>
<?php 

require 'templates/title.php' ?>

<?php 
$password = 'A';
$hash = password_hash($password , PASSWORD_DEFAULT);
echo '<p> Password \'' . $password . '\' hashes to ' .$hash; 
?>


<?php
$alphabet = range(ord('A'),ord('Z'));
echo '<p>' . $alphabet . '</p>';

echo '<p>' ;
foreach($alphabet as $a){
    echo $a . ' , ';
}
echo 'Length is ' . count($alphabet). '</p>';
?>


<hr/>
<?php
echo "<p> Study Page </p>" ;

function printDates(){
    echo "<p>" . date('Y-m-d H:i:s') . "</p>";
    echo "<p>" . date('H:i:s Y-m-d') . "</p>";
    echo "<p>" . date('l') . "</p>";
    $dateBirth = date_create('1967-07-20');

    echo '<p> I was born on a ' . date_format($dateBirth, " l ") . '</p>'; 


    $dateNow = date_create(date('Y-m-d'));

    $diff = date_diff( $dateNow, $dateBirth) ;

    echo '<p> I am  ' . $diff -> format("%Y years %m months and %d  days old") . '</p>'; 

}
printDates();



function testForTrue(string $name, array $array){
    if($array){
        echo '<p>' . $name . ' array is seen as existing </p>' ;
    }else{
        echo '<p>' . $name . ' array does not "exist" because it is empty (it has been declared) </p>';
    }

}

function printValueGivenKey(string $key, array $array){

    if($array[$key]){
    echo '<p>' . $key . ' is a ' . $array[$key] . ' cat </p>';
    }
    else{
        echo '<p>' . $key . ' is not listed </p>';
    }
}

// investigate associative arrays
// create
// count
// add
// delete
// sort
// loop through
$people = array();
testForTrue('people' , $people);
$people['paul']=35;
testForTrue('people' , $people);
$cats = array( 'tinkerbell' => 'tabby', 'jessica' => 'siamese' , 'bobby' => 'black with white socks');
testForTrue('cats' , $cats);
$cats['julius'] = 'persian';
printValueGivenKey('jones', $cats);

echo '<p>';
foreach($cats as $x => $x_value){
    echo 'Key is: ' . $x . ', Value is: ' . $x_value . '<br/>';
}

unset($cats['tinkerbell']);
echo '<p> tinkerbell has been removed </p>';
echo '</p>';
echo '<table>';
foreach($cats as $x => $x_value){
    echo '<tr> <td> Key is: </td><td>' . $x . '</td><td> Value is: </td><td>' . $x_value . '</td> </tr>';
}
echo '</table>';

?>

<!-- printing out in html evironment , somewhere in a web page -->
<p> Printing out in the HTML environment <br/>
<?php foreach($cats as $x => $x_value): ?>
    <?php echo 'Key is: ' . $x . ', Value is: ' . $x_value . '<br/>'; ?>
<?php endforeach ?> 
</p>

</body>
</html>