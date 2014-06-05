<?php

require_once("DotMailerException.php");

class InvalidEmailException extends DotMailerException {
	public function __construct($message = "Please specify a valid email address.") {
		parent::__construct($message);
	}
}