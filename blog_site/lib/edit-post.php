<?php

function addPost(PDO $pdo , $title , $body , $userId){
    //prepare insert query
    $sql = "insert into post(title, body, user_id , created_at)
    values(:title, :body , :user_id , :created_at) ";
    $stmt = $pdo -> prepare($sql);
    if($stmt === false){
        throw new Exception(" Could not prepare post insert query");
    }
    $result = $stmt -> execute(
        array('title' => $title, 'body' => $body , 'user_id' => $userId, 'created_at' => getSqlDateForNow(),)
    );
    if($result === false){
        throw new Exception("Could not execute post query");
    }

    return $pdo -> lastInsertId();
}

function editPost(PDO $pdo , $title , $body , $postId){
    // prepare insert query
    $sql="update 
    post
    set 
    title =:title,
    body=:body
    where
    id = :post_id";

    $stmt = $pdo -> prepare($sql);
    if($stmt === false){
        throw new Exception(" Could not prepare post update query");
    }

    $result = $stmt -> execute(
        array('title' => $title, 'body' => $body , 'post_id' => $postId,)
    );
    if($result === false){
        throw new Exception("Could not execute post update query");
    }

    return true;

}