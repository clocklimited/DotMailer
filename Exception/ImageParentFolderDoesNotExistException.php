<?php

require_once("DotMailerException.php");

class ImageParentFolderDoesNotExistException extends DotMailerException {
	public function __construct($message = "Parent folder does not exist, please create the folder or select a different directory.") {
		parent::__construct($message);
	}
}