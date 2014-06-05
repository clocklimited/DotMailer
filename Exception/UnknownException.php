<?php

require_once("DotMailerException.php");

class UnknownException extends DotMailerException {
	public function __construct($message = "Unknown exception.") {
		parent::__construct($message);
	}
}