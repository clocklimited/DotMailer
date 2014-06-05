<?php

require_once("DotMailerException.php");

class ContactSuppressedException extends DotMailerException {
	public function __construct($message = "TODO - handle contact suppressed exception.") {
		parent::__construct($message);
	}
}