<?php
	require ('core/init.php');

	$topic = new Topic;

	$category = isset($_GET['category']) ? $_GET['category'] : null;
	

	$user = isset($_GET['user']) ? $_GET['user'] : null;

	$template = new Template('templates/topics.php');
	if (isset($category)) {
		$template->topics= $topic->getByCategory($category);
		$template->title = 'Posts in "'.$topic->getCategory($category)->name.'"';
	}else{
		$template->topics = $topic->getAllTopics();
	}

	if (isset($user)) {
		$template->topics= $topic->getByUser($user);
		//$template->title = 'Posts by "'.$user->getUser($user)->username.'"';
	}else{
		$template->topics = $topic->getAllTopics();
	}


	$template->totalTopics = $topic->getTotalTopics();
	$template->totalCategories = $topic->getTotalCategories();


	echo $template;
?>