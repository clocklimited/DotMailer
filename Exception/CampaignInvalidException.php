<?php

require_once("DotMailerException.php");

class CampaignInvalidException extends DotMailerException {
	public function __construct($message = "") {
		parent::__construct($message);
	}
}