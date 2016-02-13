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

$notFound = isset($_GET['not-found']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>A blog application</title>
</head>
<body>

    <?php require 'templates/title.php'; ?>

    <?php if ($notFound): ?>
        <div style="border: 1px solid #ff6666; padding: 6px;">
            Error: cannot find the requested blog post
        </div>
    <?php endif ?>

    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <h2>
            <?php echo HTMLEscape($row['title']) ?>
        </h2>
        <div>
            <?php echo convertSqlDate($row['created_at']) ?>

            <?php echo "<br>" . countCommentsForPost($row['id']) . " comments." ?>
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
