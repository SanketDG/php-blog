<?php
// Get the PDO DSN string
require_once 'lib/common.php';
$database = getDatabasePath();
$root = getRootPath();

$error = '';
// A security measure, to avoid anyone resetting the database if it already exists
// is_readable() - tells whether a file exists and is readable
// then we check if database filesize is greater than 0
if (is_readable($database) && filesize($database) > 0)
{
    $error = 'Please delete the existing database manually before installing it afresh';
}
// Create an empty file for the database
// $error is ''
if (!$error)
{
    // call touch by supressing errors
    // touch returns false if it fails
    $createdOk = @touch($database);
    // createdOk is false
    if (!$createdOk)
    {
        $error = sprintf(
            'Could not create the database, please allow the server to create new files in \'%s\'',
            dirname($database)
        );
    }
}
// Grab the SQL commands we want to run on the database
// check if error is still ''
if (!$error)
{
    // read file contents
    // returns false on failure
    $sql = file_get_contents($root . '/data/init.sql');
    if ($sql === false)
    {
        $error = 'Cannot find SQL file';
    }
}
// Connect to the new database and try to run the SQL commands
// check if error is still ''
if (!$error)
{
    // load PDO with destination
    $pdo = getPDO();
    // execute the sql read from the file
    $result = $pdo->exec($sql);
    if ($result === false)
    {
        $error = 'Could not run SQL: ' . print_r($pdo->errorInfo(), true);
    }
}
// See how many rows we created, if any
$count = null;
if (!$error)
{
    // to count the number of rows
    $sql = "SELECT COUNT(*) FROM post";
    // execute the above statement
    $stmt = $pdo->query($sql);
    if ($stmt)
    {
        // fetch the column that contains the total no of values
        $count = $stmt->fetchColumn();
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Blog installer</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <style type="text/css">
            .box {
                border: 1px dotted silver;
                border-radius: 5px;
                padding: 4px;
            }
            .error {
                background-color: #ff6666;
            }
            .success {
                background-color: #88ff88;
            }
        </style>
    </head>
    <body>
        <?php if ($error): ?>
            <div class="error box">
                <?php echo $error ?>
            </div>
        <?php else: ?>
            <div class="success box">
                The database and demo data was created OK.
                <?php if ($count): ?>
                    <?php echo $count ?> new rows were created.
                <?php endif ?>
            </div>
        <?php endif ?>
    </body>
</html>