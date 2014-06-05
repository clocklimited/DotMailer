<?php

require_once("DotMailerException.php");

class AddressBookInvalidException extends DotMailerException {
	public function __construct($message = "There is an issue creating your address book, please try again later.") {
		parent::__construct($message);
	}
}