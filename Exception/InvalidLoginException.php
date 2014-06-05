<?php

require_once("DotMailerException.php");

class InvalidLoginException extends DotMailerException {
	public function __construct($message = "Invalid login credentials specified, please use the correct username and password.") {
		parent::__construct($message);
	}
}