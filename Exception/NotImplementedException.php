<?php

require_once("DotMailerException.php");

class NotImplementedException extends DotMailerException {
	public function __construct($message = "Not implemented.") {
		parent::__construct($message);
	}
}