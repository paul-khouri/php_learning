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
    $date = DateTime::createFromFormat("Y-m-d",$sqlDate);

    return $date -> format('d M Y');

}


// no closing tag