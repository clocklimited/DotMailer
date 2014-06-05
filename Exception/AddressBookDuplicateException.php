<?php

require_once("DotMailerException.php");

class AddressBookDuplicateException extends DotMailerException {
	public function __construct($message = "'Name' must be unique.") {
		parent::__construct($message);
	}
}