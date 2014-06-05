<?php

require_once("DotMailerException.php");

class ContactNotFoundException extends DotMailerException {
	public function __construct($message = "Contact not found.") {
		parent::__construct($message);
	}
}