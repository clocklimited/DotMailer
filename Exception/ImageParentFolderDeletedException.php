<?php

require_once("DotMailerException.php");

class ImageParentFolderDeletedException extends DotMailerException {
	public function __construct($message = "The image parent folder you selected has been deleted, please choose another.") {
		parent::__construct($message);
	}
}