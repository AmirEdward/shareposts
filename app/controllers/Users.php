<?php

class Users extends Controller {

    private $userModel;

	public function __construct()
	{
		$this->userModel = $this->model('User');
	}

	public function register()
	{
		// Check for POST
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Process the form

			// Sanitize POST data
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			// Init data
			$data = [
				'name' => trim($_POST['name']),
				'email' => trim($_POST['email']),
				'password' => trim($_POST['password']),
				'confirm_password' => trim($_POST['confirm_password']),
				'name_err' => '',
				'email_err' => '',
				'password_err' => '',
				'confirm_password_err' => '',
			];

			// Validate email
			if (empty($data['email'])) {
				$data['email_err'] = 'Please enter email';
			}
			if ($this->userModel->findUserByEmail($data['email'])) {
				$data['email_err'] = 'This eamil is already exist';
			}

			// Validate name
			if (empty($data['name'])) {
				$data['name_err'] = 'Please enter name';
			}

			// Validate password
			if (empty($data['password'])) {
				$data['password_err'] = 'Please enter password';
			}elseif (strlen($data['password']) < 6) {
				$data['password_err'] = 'Password must be at least 6 charachters';
			}

			// Validate Confirm Password
			if (empty($data['confirm_password'])) {
				$data['confirm_password_err'] = 'Please enter confirm password';
			}elseif ($data['password'] !== $data['confirm_password']) {
				$data['confirm_password_err'] = 'Passwords do not match';
			}

			// Make sure errors are empty
			if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
				// Validated

				// Hash password
				$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

				// Register user
				if($this->userModel->register($data)){
					flash('register_success', 'You have been registered');
					redirect('users/login');
				}else{
					die('something wrong');
				}
				
			}else {
				// Load View with errors
				$this->view('users/register', $data);
			}
		}else {
			// Init data
			$data = [
				'name' => '',
				'email' => '',
				'password' => '',
				'confirm_password' => '',
				'name_err' => '',
				'email_err' => '',
				'password_err' => '',
				'confirm_password_err' => '',
			];
			// Load the view
			$this->view('users/register', $data);
		}
	}

	public function login()
	{
		// Check for POST
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Process the form
			// Sanitize POST data
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			// Init data
			$data = [
				'email' => trim($_POST['email']),
				'password' => trim($_POST['password']),
				'email_err' => '',
				'password_err' => '',
			];

			// Validate email
			if (empty($data['email'])) {
				$data['email_err'] = 'Please enter email';
			}

			// Validate password
			if (empty($data['password'])) {
				$data['password_err'] = 'Please enter password';
			}

			// Check for user/email
			if ($this->userModel->findUserByEmail($data['email'])) {
				// User found
			}else {
				$data['email_err'] = 'No user found';
			}

			// Make sure errors are empty
			if (empty($data['email_err']) && empty($data['password_err'])) {
				// Validated
				// Check and set logged in user
				$loggedInUser = $this->userModel->login($data['email'], $data['password']);

				if ($loggedInUser) {
					// Create Session
					$this->createUserSession($loggedInUser);
				}else {
					$data['password_err'] = 'Password is incorrect';
					$this->view('users/login', $data);
				}
			}else {
				// Load View with errors
				$this->view('users/login', $data);
			}

		}else {
			// Init data
			$data = [
				'email' => '',
				'password' => '',
				'emai_err' => '',
				'password_err' => '',
			];
			// Load the view
			$this->view('users/login', $data);
		}
	}

	public function createUserSession($user)
	{
		$_SESSION['user_id'] = $user->id;
		$_SESSION['user_email'] = $user->email;
		$_SESSION['user_name'] = $user->name;
		redirect('posts');
	}

	public function logout()
	{
		unset($_SESSION['user_id']);
		unset($_SESSION['user_email']);
		unset($_SESSION['user_name']);
		session_destroy();

		redirect();
	}
}