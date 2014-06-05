<?php

require_once("DotMailerException.php");

class ImageUnsupportedFormatException extends DotMailerException {
	public function __construct($message = "The image selected was an invalid format, please select another.") {
		parent::__construct($message);
	}
}