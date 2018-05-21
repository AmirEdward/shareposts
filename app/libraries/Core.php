<?php 
/* 
 * App Core Class
 * Creates URL & loads core controller
 * URL Format - /controller/method/params
 */

 class Core {
 	protected $currentController = 'Pages';
 	protected $currrentMethod = 'index';
 	protected $params = [];

 	public function __construct()
 	{
 		$url = $this->getUrl();

 		// Look in controller for first value

 		if (file_exists('../app/controllers/' . $url[0] . '.php')) {
 			// If exist, set as controller
 			$this->currentController = $url[0];

 			// Unset 0 index
 			unset($url[0]);
 		}

 		// Require the controller
 		require_once '../app/controllers/' . $this->currentController . '.php';

 		// Instantiate it
 		$this->currentController = new $this->currentController;

 		// Check for second part of url
 		if (isset($url[1])) {
 			if (method_exists($this->currentController, $url[1])) {
 				$this->currrentMethod = $url[1];
 				unset($url[1]);
 			}
 		}
 		// Get params
 		$this->params = $url ? array_values($url) : [];

 		// Call a callback with array of params
 		if (method_exists($this->currentController, $this->currrentMethod)) {
 			call_user_func_array([$this->currentController, $this->currrentMethod], $this->params);
 		}
 	}

 	public function getUrl()
 	{
		if (isset($_GET['url'])) {
			$url = rtrim($_GET['url'], '/');
			$url = filter_var($url, FILTER_SANITIZE_URL);
			$url = explode('/', $url);
			return $url;
			// return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL))
		}
 	}
 }