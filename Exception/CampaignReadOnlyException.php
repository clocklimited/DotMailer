<?php
require_once("DotMailerException.php");

class CampaignReadOnlyException extends DotMailerException {
	public function __construct($message = "This campaign cannot be updated as it has already been sent to an address book.") {
		parent::__construct($message);
	}
}