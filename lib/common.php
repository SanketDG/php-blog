<?php
/*
* Gets the root path of project
* @return string
*/
function getRootPath()
{
    return realpath(__DIR__ . '/..');
}

/*
 * Gets database of the path
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
 * Gets the PDO object for database acccess
 *
 * @return PDO
 */
function getPDO()
{
    return new PDO(getDsn());
}

/**
 * Escapes HTML so it is safe to output
 *
 * @param string $html
 * @return string
 */
function HTMLEscape($html)
{
    return htmlspecialchars($html, ENT_HTML5 , 'UTF-8');
}

/**
 * Converts date to readable format
 *
 * @param string $sqlDate
 * @return string
 */
function convertSqlDate($sqlDate)
{
    /* @var $date DateTime */
    $date = DateTime::createFromFormat('Y-m-d', $sqlDate);

    return $date->format('d M Y');
}
?>