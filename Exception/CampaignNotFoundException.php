<?php

require_once("DotMailerException.php");

class CampaignNotFoundException extends DotMailerException {
	public function __construct($message = "Campaign not found.") {
		parent::__construct($message);
	}
}