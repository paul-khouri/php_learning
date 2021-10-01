<?php
/**
 * Retrieves a single post
 * 
 * @param PDO $pdo
 * @param integer $postId
 * @throws Exception
 * @return array $row
 */
function getPostRow(PDO $pdo, $postId){

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

    return $row;


}