<?php

require_once("DotMailerException.php");

class CampaignSendNotPermittedException extends DotMailerException {
	public function __construct($message = "You are unable to send this campaign at the moment, please try again later.") {
		parent::__construct($message);
	}
}