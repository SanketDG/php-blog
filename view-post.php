<?php

require_once 'lib/common.php';

$pdo = getPDO();
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

$bodytext = HTMLEscape($row['body']);
$paratext = str_replace("\n", "</p><p>", $bodytext)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>A Blog Application |
        <?php echo HTMLEscape($row['title']) ?></title>
</head>
<body>
    <?php require 'templates/title.php'; ?>

    <h2>
        <?php
            echo HTMLEscape($row['title']);
        ?>
    </h2>
    <div>
        <?php echo $row['created_at'] ?>
    </div>
    <p>
        <?php echo $paratext ?>
    </p>
</body>
</html>