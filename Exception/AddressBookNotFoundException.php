<?php

require_once("DotMailerException.php");

class AddressBookNotFoundException extends DotMailerException {
	public function __construct($message = "Address book not found.") {
		parent::__construct($message);
	}
}