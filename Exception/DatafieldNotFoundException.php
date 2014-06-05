<?php

require_once("DotMailerException.php");

class DatafieldNotFoundException extends DotMailerException {
	public function __construct($message = "TODO - handle data field not found exception.") {
		parent::__construct($message);
	}
}