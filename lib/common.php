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
    $date = DateTime::createFromFormat('Y-m-d H:i:s', $sqlDate);

    return $date->format('d M Y, H:i');
}

/**
 * Returns the number of comments for the specified post.
 * @param integer $postId
 * @return integer
 */
function countCommentsForPost($postId)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare('
        SELECT COUNT(*) FROM comment WHERE post_id = :post_id
    ');
    $stmt->execute(array('post_id' => $postId, ));
    return (int) $stmt->fetchColumn();
}

/**
 * Returns the comments for the specified post.
 * @param integer $postId
 * @return array
 */
function getCommentsForPost($postId)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare('SELECT id, name, text, created_at, website FROM comment WHERE post_id = :post_id');
    $stmt->execute(array('post_id' => $postId, ));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function redirectAndExit($script)
{
    // Get the domain-relative URL (e.g. /blog/whatever.php or /whatever.php) and work
    // out the folder (e.g. /blog/ or /).
    $relativeUrl = $_SERVER['PHP_SELF'];
    $urlFolder = substr($relativeUrl, 0, strrpos($relativeUrl, '/') + 1);
    // Redirect to the full URL (http://myhost/blog/script.php)
    $host = $_SERVER['HTTP_HOST'];
    $fullUrl = 'http://' . $host . $urlFolder . $script;
    header('Location: ' . $fullUrl);
    exit();
}

?>
