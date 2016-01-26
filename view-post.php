<?php

$ROOT = __DIR__;
$database = __DIR__ . '/data/data.sqlite';
$dsn = 'sqlite:' . $database;

$pdo = new PDO($dsn);
$stmt = $pdo->prepare(
    'SELECT title, created_at, body
    FROM POST
    WHERE id=:id
    '
);
if($stmt == FALSE)
{
    throw new Exception("There was a problem preparing this query");
}

$result= $stmt->execute(
    array('id' => 1, )
);
if($result == false)
{
    throw new Exception("There was a problem executing this query");
}

$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>A Blog Application |
        <?php echo htmlspecialchars($row['title'], ENT_HTML5, 'UTF-8') ?></title>
</head>
<body>
    <?php require 'templates/title.php'; ?>

    <h2>
        <?php
            echo htmlspecialchars($row['title'], ENT_HTML5, 'UTF-8');
        ?>
    </h2>
    <div>
        <?php echo $row['created_at'] ?>
    </div>
    <p>
        <?php echo htmlspecialchars($row['body'], ENT_HTML5, 'UTF-8') ?>
    </p>
</body>
</html>