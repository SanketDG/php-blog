<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>A blog application</title>
</head>
<body>

    <?php for ($postId = 1; $postId <= 3; $postId++): ?>
        <h2>Article <?php echo $postId ?> title</h2>
        <div>dd Mon YYYY</div>
        <p>A paragraph summarising article <?php echo $postId ?>.</p>
        <p><a href="#">Read more...</a></p>
    <?php endfor ?>

</body>
</html>