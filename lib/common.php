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

?>