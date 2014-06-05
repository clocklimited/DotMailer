<?php

require_once("DotMailerException.php");

class AddressBookNotWriteableException extends DotMailerException {
	public function __construct($message = "This address book is not editable.") {
		parent::__construct($message);
	}
}