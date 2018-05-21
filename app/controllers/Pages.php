<?php 

class Pages extends Controller {

	public function __construct()
	{

	}

	public function index()
	{
	    if(isLoggedIn()){
	        redirect('posts');
        }

		$data = [
			'title' => 'Posts App',
			'description' => 'Basic MVC Posts Application',
		];
				
		$this->view('pages/index', $data);
	}

	public function edit()
	{
		$this->view('pages/edit');
	}

	public function about()
	{
		$data = [
			'title' => 'About Us',
			'description' => 'App to share posts with other users',
		];

		$this->view('pages/about', $data);
	}
}