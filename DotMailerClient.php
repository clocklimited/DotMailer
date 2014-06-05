<?php

class DotMailerClient {
	private $defaultParameters;
	private $moreOptions;
	private $mockException;

	static public function getInstance($parameters = array(), $moreOptions = array(), $mockException = "", $mock = false) {
		static $dotMailerClient;
		if ($mock || !empty($mockException)) {
			// They want a mock object
			return new DotMailerClient($parameters, $moreOptions, $mockException);
		}
		if (!$dotMailerClient) {
			$dotMailerClient = new DotMailerClient($parameters, $moreOptions);
		}
		return $dotMailerClient;
	}

	protected function __construct($defaultParameters, $moreOptions = array(), $mockException = "") {
		$this->defaultParameters = $defaultParameters;
		$this->moreOptions = $moreOptions;
		$this->mockException = $mockException;
	}

	public function getMockException() {
		return $this->mockException;
	}

	public function getMoreOptions() {
		return $this->moreOptions;
	}

	public function getUsername() {
		if (isset($this->defaultParameters["username"])) {
			return $this->defaultParameters["username"];
		}
		return "";
	}

	public function getPassword() {
		if (isset($this->defaultParameters["password"])) {
			return $this->defaultParameters["password"];
		}
		return "";
	}

	public function getWsdl() {
		if (isset($this->defaultParameters["wsdl"])) {
			return $this->defaultParameters["wsdl"];
		}
		return "";
	}

	public function setUsername($username) {
		$this->defaultParameters["username"] = $username;
	}

	public function setPassword($password) {
		$this->defaultParameters["password"] = $password;
	}
}