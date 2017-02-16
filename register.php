<?php
	require ('core/init.php');

	$topic = new Topic;

	$user = new User;

	$validate = new Validator;

	if (isset($_POST['register'])) {
		$data = array();
		$data['name'] 			= $_POST['name'];
		$data['email'] 			= $_POST['email'];
		$data['username'] 		= $_POST['username'];
		$data['password'] 		= md5($_POST['password']);
		$data['password2'] 		= md5($_POST['password2']);
		$data['about'] 			= $_POST['about'];
		$data['last_activity'] 	= date("Y-m-d H:i:s");

$field_array = array('name', 'email', 'username', 'password', 'password2');
	
	if ($validate->isRequired($field_array)) {
		if ($validate->isValidEmail($data['email'])) {
			if ($validate->passwordsMatch($data['password'], $data['password2'])) {
				// validation successful
				//check if image submitted
				if ($_FILES['avatar']['size'] > 0) {
					// Upload Avatar image
					if ($user->uploadAvatar()){
						$data['avatar'] = $_FILES['avatar']['name'];
					}
				} else {
					$data['avatar'] = 'noimage.png';
				}
				
				// Register User
				if($user->register($data)){
					// DB insert successful
					redirect('index.php', 'Welcome to TalkingSpace, '.$data['name'].'!'.' Log in to continue.', 'success');
				} else {
					redirect('index.php', 'Something went wrong with registration', 'error');
				}
			} else {
				redirect('register.php', 'Your passwords did not match', 'error');
			}
		} else {
			redirect('register.php', 'Please use a valid email address', 'error');
		}
	} else {
		redirect('register.php', 'Please fill in all the required fields', 'error');
	}

	}

	$template = new Template('templates/register.php');

	$template->totalTopics = $topic->getTotalTopics();

	echo $template;
?>