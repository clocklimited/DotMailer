<?php

require_once("DotMailerException.php");

class ApiUsageExceededException extends DotMailerException {
	public function __construct($message = "API usage exceeded, please try again later or contact your administrator.") {
		parent::__construct($message);
	}
}