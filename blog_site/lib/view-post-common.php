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

/**
 * Add a comment to a post.
 * 
 * @param PDO $pdo
 * @param integer $postId
 * @param array $commentData
 * @throws Exception
 * @return array $errors
 */
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
    
    $stmt = $pdo -> prepare($sql);
      if($stmt === false){
        throw new Exception('Cannot prepare statement to insert comment');
      };
      $createdTimeStamp = getSqlDateForNow();
  
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
}

/**
 * Delete specified commment on a specified post
 * 
 * @param PDO $pdo
 * @param integer $postId
 * @param integer $commentId
 * @return boolean true if completed succesfully
 * @throws Exception
 */
function deleteComment(PDO $pdo , $postId , $commentId){
  $sql="
  delete from comment 
  where post_id =:post_id and id=:comment_id";

  $stmt = $pdo -> prepare($sql);
  if($stmt === false){
    throw new Exception("Problem preparing delete query");
  }

  $result = $stmt -> execute(
      array('post_id' => $postId, 'comment_id' => $commentId,)
    );

  return $result !== false;

}