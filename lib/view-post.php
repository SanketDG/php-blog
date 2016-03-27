<?php

/**
 * Retrieves a single post
 *
 * @param PDO $pdo
 * @param integer $postId
 * @throws Exception
 */

function getPostRow(PDO $pdo, $postId)
{
	$stmt = $pdo->prepare(
		'SELECT
			title, created_at, body
		FROM
			post
		WHERE
			id = :id'
		);
	if($stmt == false)
	{
		throw new Exception('There was a problem preparing this query.');
	}
	$result = $stmt->execute(
		array('id' => $postId, )
	);

	if($result == false)
	{
		throw new Exception('There was a problem running this query.');
	}

	return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Writes a comment to a particular post and returns errors, if any.
 *
 * @param PDO $pdo
 * @param integer $postId
 * @param array $commentData
 * @return array
 */

function addCommentToPost(PDO $pdo, $postId, array $commentData)
{
	$errors = array();

	if(empty($commentData['name']))
	{
		$errors['name'] = 'A name is required.'
	}
	if(empty($commentData['text']))
	{
		$errors['text'] = 'A comment is required.'
	}

	// if we are error free
	if (!$errors)
	{
		$sql = "
			INSERT INTO
			comment
			(name, website, text, post_id)
			VALUES(:name, :website, :text, :post_id)
		";

		if($stmt === false)
		{
			throw new Exception("Cannot prepare statement to insert comment");
		}
		$result = $stmt->execute(
			array_merge($commentData, array('post_id' => $postId, ))
		);

		if($result === false)
		{
			// @todo This renders a database-level message to the user, fix this
			$errorInfo = $pdo->errorInfo();
			if($errorInfo)
			{
				$errors[] = $errorInfo[2];
			}
		}
	}

	return $errors;
}

?>
