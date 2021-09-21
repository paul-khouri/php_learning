<?php

/**
 * Gets the root path of the project
 * 
 * @return string
 */
function getRootPath()
{
    return realpath(__DIR__ . '/..');
}

/**
 * Gets the full path for the database file
 * 
 * @return string
 */
function getDatabasePath()
{
    return getRootPath() . '/data/data.sqlite';
}

/**
 * Gets the DSN for the SQLite connection
 * 
 * @return string
 */
function getDsn()
{
    return 'sqlite:' . getDatabasePath();
}

/**
 * Gets the PDO object for database access
 * 
 * @return \PDO
 */
function getPDO()
{
    return new PDO(getDsn());
}
/**
 * Escapes so text is safe to output
 * 
 * @param string $html
 * @return string
 */
function htmlEscape($html){
    return htmlspecialchars($html, ENT_HTML5, 'UTF-8');
}

/**
 * Change date format
 * 
 * @param date $sqlDate
 * @return date
 */
function convertSQliteDate($sqlDate){
    /* @var $date DateTime */
    $date = DateTime::createFromFormat("Y-m-d H:i:s",$sqlDate);

    return $date -> format('d M Y, H:i');

}

/**
 * Returns specified number of comments for each post
 * 
 * @param integer $postId
 * @return integer
 */
function countCommentsForPost($postId){
    $pdo = getPDO();
    $sql = "
    select count(*) c from comment
    where post_id = :post_id
    ";
    $stmt = $pdo -> prepare($sql);
    $stmt ->execute(
        array('post_id' => $postId, )
    );

    return (int) $stmt -> fetchColumn();

}

function getCommentsForPost($postId){

    $pdo = getPDO();
    $sql = "
    select id, name, text, created_at, website
    from comment 
    where post_id = :post_id
    ";
    $stmt = $pdo -> prepare($sql);
    $stmt ->execute(
        array('post_id' => $postId, )
    );

    return $stmt -> fetchAll(PDO::FETCH_ASSOC);

}

// no closing tag