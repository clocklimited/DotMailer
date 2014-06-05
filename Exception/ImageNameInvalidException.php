<?php

require_once("DotMailerException.php");

class ImageNameInvalidException extends DotMailerException {
	public function __construct($message = "'Name' field must be a valid name.") {
		parent::__construct($message);
	}
}