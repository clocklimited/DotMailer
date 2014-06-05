<?php

require_once("DotMailerException.php");

class ImageDataEmptyException extends DotMailerException {
	public function __construct($message = "TODO - handle image data not found exception.") {
		parent::__construct($message);
	}
}