<?php

require_once("DotMailerException.php");

class ContactInvalidException extends DotMailerException {
	public function __construct($message = "TODO - handle contact invalid exception.") {
		parent::__construct($message);
	}
}