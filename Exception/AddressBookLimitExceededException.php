<?php

require_once("DotMailerException.php");

class AddressBookLimitExceededException extends DotMailerException {
	public function __construct($message = "You have reached the maximum number of address books, please contact your administrator.") {
		parent::__construct($message);
	}
}