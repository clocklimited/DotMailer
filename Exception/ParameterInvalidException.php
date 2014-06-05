<?php

require_once("DotMailerException.php");

class ParameterInvalidException extends DotMailerException {
	public function __construct($message = "Invalid parameter specified, please contact your administrator.") {
		parent::__construct($message);
	}
}