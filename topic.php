<?php
	require ('core/init.php');

	$topic = new Topic;

	$topic_id = $_GET['id'];

	if (isset($_POST['do_reply'])) {
	// Assign vars
	$data = array();
	$data['topic_id'] = $topic_id;
	$data['body'] = $_POST['body'];
	$data['user_id'] = getUser()['user_id'];
	
	// Create Validator Object
	$validate = new Validator();
	
	// Required Fields
	$field_array = array('body');
	
	if ($validate->isRequired($field_array)) {
		//register user
		if ($topic->reply($data)){
			redirect('topic.php?id='.$topic_id, 'Reply posted', 'success');
		} else {
			redirect('topic.php?id='.$topic_id, 'Something went wrong', 'error');
		}
	} else {
		redirect('topic.php?id='.$topic_id, 'Your reply form is blank', 'error');
	}
	
	}


	$template = new Template('templates/topic.php');

	$template->topic = $topic->getTopic($topic_id);
	$template->replies = $topic->getReplies($topic_id);
	$template->title = $topic->getTopic($topic_id)->title;
	$template->totalTopics = $topic->getTotalTopics();



	echo $template;
?>