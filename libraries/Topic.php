<?php
	class Topic{

		private $db;

		public function __construct()
		{
			$this->db = new Database;
		}
		public function getAllTopics()
		{
			$this->db->query("select topics.*,users.username,users.avatar,categories.name from topics
				inner join users 
				on topics.user_id = users.id
				inner join categories 
				on topics.category_id = categories.id
				order by create_date desc
				");
			$results = $this->db->resultset();

			return $results;
		}

		public function getByCategory($category_id){
		$this->db->query("SELECT topics.*, categories.name, categories.description, users.username, users.avatar FROM topics
						INNER JOIN categories
						ON topics.category_id = categories.id
						INNER JOIN users
						ON topics.user_id = users.id
						WHERE topics.category_id = :category_id
						");
		$this->db->bind(':category_id', $category_id);
		$results = $this->db->resultset();
		return $results;
		}

		public function getByUser($user_id){
		$this->db->query("SELECT topics.*, categories.*, users.username, users.avatar FROM topics
						INNER JOIN categories
						ON topics.category_id = categories.id
						INNER JOIN users
						ON topics.user_id = users.id
						WHERE users.id = :user_id
						");
		$this->db->bind(':user_id', $user_id);
		$results = $this->db->resultset();
		return $results;
		}

		public function getTotalTopics()
		{
			$this->db->query("select * from topics");
			$rows = $this->db->resultset();
			return $this->db->rowCount();
		}


		public function getTotalCategories()
		{
			$this->db->query("select * from categories");
			$rows = $this->db->resultset();
			return $this->db->rowCount();
		}

		public function getCategory($category_id)
		{
			$this->db->query("select * from categories where id = :category_id ");
			$this->db->bind(':category_id',$category_id);
			$row = $this->db->single();
			return $row;
		}

	

		public function getTotalReplies($topic_id)
		{
			$this->$db->query("select * from replies where topic_id = '$topic_id' ");
			$rows = $this->db->resultset();
			return $this->db->rowCount();
		}

		public function getTopic($topic_id){
			$this->db->query("SELECT topics.*, users.username, users.name, users.avatar FROM `topics`
							INNER JOIN users
							ON topics.user_id = users.id
							WHERE topics.id = :topic_id
							");
			$this->db->bind(':topic_id', $topic_id);
			$row = $this->db->single();
			return $row;
		}
		
		/*
		 * Get Replies
		 */
		public function getReplies($topic_id){
			$this->db->query("SELECT replies.*, users.* FROM replies
							INNER JOIN users
							ON replies.user_id = users.id
							WHERE replies.topic_id = :topic_id
							ORDER BY create_date ASC
							");
			$this->db->bind(':topic_id', $topic_id);
			
			$results = $this->db->resultset();
			return $results;
		}

		public function create($data){
		// Insert Query
		$this->db->query("INSERT INTO topics
				(category_id, user_id, title, body, last_activity)
				VALUES (:category_id, :user_id, :title, :body, :last_activity)");
		$this->db->bind(':category_id', $data['category']);
		$this->db->bind(':user_id', $data['user_id']);
		$this->db->bind(':title', $data['title']);
		$this->db->bind(':body', $data['body']);
		$this->db->bind(':last_activity', $data['last_activity']);
		//Execute
		if ($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}
	
	/*
	 * Create Reply
	 */
		public function reply($data){
		// Insert Query
		$this->db->query("INSERT INTO replies
				(topic_id, user_id, body)
				VALUES (:topic_id, :user_id, :body)");
		$this->db->bind(':topic_id', $data['topic_id']);
		$this->db->bind(':user_id', $data['user_id']);
		$this->db->bind(':body', $data['body']);
		//Execute
		if ($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}

	}
?>