<?php
// compute the path to the database
require_once 'lib/common.php';

$pdo = getPDO();
$stmt = $pdo->query(
    'SELECT id, title, created_at, body
    FROM post
    ORDER BY created_at DESC
    ');
if($stmt == false)
{
    throw new Exception("There was a problem running this query.");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>A blog application</title>
</head>
<body>

    <?php require 'templates/title.php'; ?>

    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <h2>
            <?php echo HTMLEscape($row['title']) ?>
        </h2>
        <div>
            <?php echo convertSqlDate($row['created_at']) ?>
        </div>
        <p>
            <?php echo HTMLEscape($row['body']) ?>
        </p>
        <p>
            <a href="view-post.php?post_id=<?php echo $row['id'] ?>">Read more....</a>
        </p>
    <?php endwhile ?>

</body>
</html>