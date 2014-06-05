<?php

require_once("DotMailerException.php");

class NoEmailColumnException extends DotMailerException {
	public function __construct($message = "No 'Email' column specified.") {
		parent::__construct($message);
	}
}