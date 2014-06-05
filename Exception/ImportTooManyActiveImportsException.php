<?php

require_once("DotMailerException.php");

class ImportTooManyActiveImportsException extends DotMailerException {
	public function __construct($message = "There are currently too many imports, please try again later.") {
		parent::__construct($message);
	}
}