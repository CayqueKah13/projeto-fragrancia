<?php
class controller {

	protected $db;
	protected $lang;
	public $sessLogin;

	public function __construct() {
		global $config;
		$this->lang = new Language();
	}
	
	public function loadView($viewName, $viewData = array()) {
		extract($viewData);
		include 'views/'.$viewName.'.php';
	}

	public function loadTemplate($viewName, $viewData = array()) {

		if(isset($_SESSION['ccUser']) && !empty($_SESSION['ccUser'])){
			$u = new Users();
			$this->sessLogin = $u->sessionLogin($_SESSION['ccUser']);
		}

		include 'views/template.php';
	}

	public function loadViewInTemplate($viewName, $viewData) {
		extract($viewData);
		include 'views/'.$viewName.'.php';
	}

}