<?php

require_once("DotMailerException.php");

class SystemServiceTemporarilyUnavailableException extends DotMailerException {
	public function __construct($message = "The API is currently unavailable, please contact your administrator.") {
		parent::__construct($message);
	}
}