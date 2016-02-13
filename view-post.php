<?php

require_once 'lib/common.php';
require_once 'lib/view-post.php';

// get the post id
if(isset($_GET['post_id']))
{
    $postId = $_GET['post_id'];
}
else
{
    $postId = 0;
}

$pdo = getPDO();
$row = getPostRow($pdo, $postId);

$bodyText = HTMLEscape($row['body']);
$paraText = str_replace("\n", "</p><p>", $bodyText)
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
        <?php echo convertSqlDate($row['created_at']) ?>
    </div>
    <p>
        <?php echo $paraText ?>
    </p>


    <h3><?php echo countCommentsForPost($postId) ?> comments</h3>
    <?php foreach (getCommentsForPost($postId) as $comment): ?>
        <?php // For now, we'll use a horizontal rule-off to split it up a bit ?>
        <hr />
        <div class="comment">
            <div class="comment-meta">
                Comment from
                <?php echo htmlEscape($comment['name']) ?>
                on
                <?php echo convertSqlDate($comment['created_at']) ?>
            </div>
            <div class="comment-body">
                <?php echo htmlEscape($comment['text']) ?>
            </div>
        </div>
    <?php endforeach ?>
</body>
</html>
