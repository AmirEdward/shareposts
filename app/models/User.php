<?php 

class User {
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	// Register user
	public function register($data)
	{
		$this->db->query("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
		$this->db->bind('name' , $data['name']);
		$this->db->bind('email' , $data['email']);
		$this->db->bind('password' , $data['password']);

		if ($this->db->execute()) {
			return true;
		}else{
			return false;
		}
	}

	// Login User

	public function login($email, $password)
	{
		$row = $this->db->query('SELECT * FROM users WHERE email = :email')->bind(':email', $email)->single();

		$hashed_password = $row->password;

		if (password_verify($password, $hashed_password)) {
			return $row;
		}else {
			return False;
		}
	}

	// Find user by email
	public function findUserByEmail($email)
	{

		if ($this->db->query('SELECT * FROM users WHERE email = :email')->bind('email' , $email)->rowCount())
		{
			return true;
		}else {
			return false;
		}
	}

	// Get user by id
	public function getUserById($id)
	{
        $row = $this->db->query('SELECT * FROM users WHERE id = :id')->bind('id', $id)->single();

        return $row;
	}
}