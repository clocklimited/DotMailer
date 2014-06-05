<?php
require_once("DotMailer.php");
require_once("DotMailerEntity.php");
/**
* Campaigns class is a DotMailer wrapper that contains all the methods that can
* create, modify, delete and retrieve DotMailer campaign objects.
*
* @version 1.0
* @author Oliver Johnstone
* @copyright Clock Limited 2012
* @license http://opensource.org/licenses/bsd-license.php New BSD License
*/
class Campaigns extends DotMailer {

	const REPLY_ACTION_UNSET = "Unset";
	const REPLY_ACTION_WEBMAILFORWARD = "WebMailForward";
	const REPLY_ACTION_WEBMAIL = "Webmail";
	const REPLY_ACTION_DELETE = "Delete";

	const STATUS_NOT_SET = "NotSet";
	const STATUS_UNSENT = "Unsent";
	const STATUS_SENDING = "Sending";
	const STATUS_SENT = "Sent";
	const STATUS_PAUSED = "Paused";
	const STATUS_CANCELLED = "Cancelled";
	const STATUS_REQUIRES_APPROVAL = "RequiresApproval";
	const STATUS_REQUIRES_SMS_APPROVAL = "RequiresSMSApproval";
	const STATUS_TRIGGERED = "Triggered";

	/**
	 * Create a new campaign within your dotMailer account. You are able to create
	 * both HTML and plain text versions of the campaign.
	 *
	 * @link http://www.dotmailer.co.uk/api/campaigns/create_campaign.aspx
	 *
	 * @param name String The name of the campaign as it appears in your account; this is not directly
	 *		exposed to the end recipient and may be different to the subject line. (The name is used in Google Analytics
	 *		campaign tagging so should be kept recipient friendly.)
	 * @param subject String The subject line of the email.
	 * @param htmlContent String The contents of the HTML email; this will be validated before
	 * 		saving and must contain an unsubscribe link (http://$UNSUB$).
	 * @param plaintextContent String The contents of the Plain Text email; this will be validated before
	 *		saving and must contain an unsubscribe link (http://$UNSUB$).
	 * @param fromName String The name that the email campaign should appear to be from.
	 * @param replyAction String What should be done with replies received to the campaign. N.B See class constants
	 * @param replyToAddress String If the reply action is set to WebMailForward, what email address they should be
	 * 		forwarded to.
	 * @return Campaign This is the campaign object; it includes the generated ID and status.
	 * @throws CampaignInvalidException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function createCampaign(
		$id,
		$name,
		$subject,
		$htmlContent,
		$plaintextContent,
		$fromName,
		$replyAction = self::REPLY_ACTION_UNSET,
		$replyToAddress = "") {

		$campaign = new DotMailerEntity();
		$campaign->FromName = $fromName;
		$campaign->HTMLContent = $htmlContent;
		$campaign->Name = $name;
		$campaign->PlaintextContent = $plaintextContent;
		$campaign->ReplyAction = $replyAction;
		$campaign->ReplyToAddress = $replyToAddress;
		$campaign->Subject = $subject;
		$campaign->Id = $id;
		$campaign->Status = self::STATUS_NOT_SET;

		$params = array();
		$params["campaign"] = $campaign->toArray();
		$response = $this->send("createCampaign", $params);
		return $response->CreateCampaignResult;
	}

	/**
	 * Duplicate an existing campaign in your dotMailer account including dynamic content.
	 *
	 * @link http://www.dotmailer.co.uk/api/campaigns/copy_campaign.aspx
	 * @param campaignId This is the ID number of the campaign which you wish to duplicate.
	 * @return Integer This is the ID of the newly created campaign.
	 * @throws CampaignNotFoundException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function copyCampaign($campaignId) {
		$params = array();
		$params["campaignId"] = $campaignId;

		return $this->send("copyCampaign", $params);
	}

	/**
	 * Retrieve an existing campaign from your dotMailer account.
	 *
	 * @link http://www.dotmailer.co.uk/api/campaigns/get_campaign.aspx
	 * @param campaignId Integer This is the ID number of the campaign which you wish to retrieve.
	 * @return Campaign This is the campaign object; it includes the generated ID and status.
	 * @throws CampaignNotFoundException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function getCampaign($campaignId) {
		$params = array();
		$params["campaignId"] = $campaignId;

		return $this->send("getCampaign", $params);
	}

	/**
	 * Query the progress of a campaign being sent. It will return a status indicating where the campaign
	 * is in the sending process.
	 *
	 * @link http://www.dotmailer.co.uk/api/campaigns/get_campaign_send_progress.aspx
	 * @param progressId String This is the the GUID which is returned to you when
	 * 		you call any of our WithProgress methods.
	 * @return String NotSend or Scheduled or Sending or Sent or Cancelled
	 * @throws CampaignNotFoundException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServicelistTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function getCampaignSendProgress($progressId) {
		$params = array();
		$params["progressID"] = $progressId;
		$response = $this->send("getCampaignSendProgress", $params);
		return $response->GetCampaignSendProgressResult;
	}

	/**
	 * Get a summary of information about a campaigns performance statistics after it has been sent.
	 *
	 * @link http://www.dotmailer.co.uk/api/campaigns/get_campaign_summary.aspx
	 * @param campaignId Integer This is the ID of the campaign you wish to query against
	 * @return Array containing details about the requested campaign
	 * @throws CampaignNotFoundException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function getCampaignSummary($campaignId) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$response = $this->send("getCampaignSummary", $params);
		return $response->GetCampaignSummaryResult;
	}

	/**
	 * Tells you whether a campaign is a split test campaign or just a normal campaign.
	 *
	 * @link http://www.dotmailer.co.uk/api/campaigns/is_split_test_campaign.aspx
	 * @param campaignId Integer This is the ID of the campaign you wish to query against
	 * @return Boolean TRUE if the campaign is a split test campaign, FALSE if it is not.
	 * @throws CampaignNotFoundException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function isSplitTestCampaign($campaignId) {
		$params = array();
		$params["campaignId"] = $campaignId;

		return $this->send("isSplitTestCampaign", $params);
	}

	/**
	 * Lists any address books that a campaign has ever been sent to.
	 *
	 * @link http://www.dotmailer.co.uk/api/campaigns/list_address_books_for_campaign.aspx
	 * @param campaignId Integer This is the ID of the campaign you wish to query against
	 * @return Array An array of APIAddressBook objects; each consisting of an ID
	 * 		(Integer) and a name (String).
	 * @throws CampaignNotFoundException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function listAddressBooksForCampaign($campaignId) {
		$params = array();
		$params["campaignId"] = $campaignId;

		return $this->send("listAddressBooksForCampaign", $params);
	}

	/**
	 * Retrieves a filtered list of campaigns that have been sent to the specified address book. This can be
	 * useful in ensuring that you do not send the same campaign to the same contacts.
	 *
	 * @link http://www.dotmailer.co.uk/api/campaigns/list_campaigns_for_address_book.aspx
	 * @param addressbookID Integer This is the Id of the AddressBook in your dotMailer
	 * 		account that you wish to query against.
	 * @return Array of APICampaign objects.
	 * @throws AddressBookNotFoundException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function listCampaignsForAddressBook($addressbookID) {
		$params = array();
		$params["addressbookID"] = $addressbookID;

		return $this->send("listCampaignsForAddressBook", $params);
	}

	/**
	 * Retrieves a list of campaigns which have been sent after a specified date that have had a user
	 * interact with the campaign.
	 *
	 * @link http://www.dotmailer.co.uk/api/campaigns/list_sent_campaigns_with_activity_since_date.aspx
	 * @param startDate DateTime The date and time from which you would like to report on.
	 * @return Array of APICampaign objects
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function listSentCampaignsWithActivitySinceDate(\DateTime $startDate) {
		$params = array();
		$params["startDate"] = $this->formatDate($startDate);
		$response = $this->send("listSentCampaignsWithActivitySinceDate", $params);

		if (count((array)$response->ListSentCampaignsWithActivitySinceDateResult) > 0) {
			return $response->ListSentCampaignsWithActivitySinceDateResult->APICampaign;
		}
		return false;
	}

	/**
	 * Send a campaign from your dotMailer account to a specific address book or address books and also track
	 * the progress of the send, so you know when it has finished.
	 *
	 * @link http://www.dotmailer.co.uk/api/campaigns/send_campaign_to_address_books_with_progress.aspx
	 * @param campaignId Integer The ID number of the campaign you wish to send.
	 * @param addressbookIDs Array(Integer) An array of the address books you want
	 * 		to send the campaign to.
	 * @param sendDate DateTime The date and time you wish the campaign to be sent (server time).
	 * @return String The returned token (a GUID) can be used to query send progress
	 * 		by calling GetCampaignSendProgres.
	 * @throws AddressBookNotFoundException
	 * @throws CampaignInvalidException
	 * @throws CampaignNotFoundException
	 * @throws CampaignSendNotPermittedException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function sendCampaignToAddressBooksWithProgress($campaignId, array $addressbookIDs, \DateTime $sendDate) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$params["addressBookIds"] = $addressbookIDs;
		$params["sendDate"] = $this->formatDate($sendDate);

		$response = $this->send("sendCampaignToAddressBooksWithProgress", $params);
		return $response->SendCampaignToAddressBooksWithProgressResult;
	}

	/**
	 * Send a campaign from your dotMailer account to a specific contact.
	 *
	 * @link http://www.dotmailer.co.uk/api/campaigns/send_campaign_to_contact.aspx
	 * @param campaignId Integer The ID number of the campaign you wish to send.
	 * @param contactId Integer The ID of the contact you want to send the campaign to.
	 * @param sendDate DateTime The date and time you wish the campaign to be sent (server time).
	 * @throws ContactInvalidException
	 * @throws ContactNotFoundException
	 * @throws ContactSuppressedException
	 * @throws CampaignInvalidException
	 * @throws CampaignNotFoundException
	 * @throws CampaignSendNotPermittedException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function sendCampaignToContact($campaignId, $contactId, \DateTime $sendDate) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$params["contactid"] = $contactId;
		$params["sendDate"] = $this->formatDate($sendDate);

		$this->send("sendCampaignToContact", $params);
	}

	/**
	 * Sends a split test campaign to a specified address book or address books and allows you
	 * to track the progress of the send.
	 *
	 * @link http://www.dotmailer.co.uk/api/campaigns/send_split_test_campaign_to_address_book_with_progress.aspx
	 * @param campaignId Integer The ID number of the campaign you wish to send.
	 * @param addressbookIDs Array(Integer) An array of the address books you want
	 *		to send the campaign to.
	 * @param sendDate DateTime The date and time you wish the campaign to be sent (server time).
	 * @param testPercentage Integer This is the percentage of recipients you wish
	 *		to test the campaign against and must be an integer between 1 and 60 (inclusive).
	 * @param testPeriodHours Integer This is the time period (number of hours) that
	 *		you would like to split test the campaign over and must be an integer
	 *		between 1 and 24 (inclusive).
	 * @param testMetric This determines whether you want to gauge the test
	 *		based on opens or number of clicks in the campaign.
	 * @return String The returned token (a GUID) can be used to query send progress
	 *		by calling GetCampaignSendProgres.
	 * @throws AddressBookNotFoundException
	 * @throws CampaignInvalidException
	 * @throws CampaignNotFoundException
	 * @throws CampaignSendNotPermittedException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function sendSplitTestCampaignToAddressBookWithProgress(
		$campaignId,
		array $addressbookIDs,
		\DateTime $sendDate,
		$testPercentage,
		$testPeriodHours,
		$testMetric) {

		$params = array();
		$params["campaignId"] = $campaignId;
		$params["addressbookIDs"] = $addressbookIDs;
		$params["sendDate"] = $this->formatDate($sendDate);
		$params["testPercentage"] = $testPercentage;
		$params["testPeriodHours"] = $testPeriodHours;
		$params["testMetric"] = $testMetric;

		return $this->send("sendSplitTestCampaignToAddressBookWithProgress", $params);
	}

	/**
	 * Change the custom from address that a specified campaign will use when it is sent in your dotMailer account.
	 *
	 * @link http://www.dotmailer.co.uk/api/campaigns/set_campaign_custom_from_address.aspx
	 * @param campaignId Integer The ID of the campaign you wish to edit.
	 * @param fromAddressId Integer The ID of the custom from address you would like
	 *		the campaign to use when the campaign is sent; the ID is obtained using
	 *		the method ListAvailableCustomFromAddresses.
	 * @throws CampaignNotFoundException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailableException
	 * @throws UnknownException
	 */
	public function setCampaignCustomFromAddress($campaignId, $fromAddressId) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$params["fromaddressId"] = $fromAddressId;
		$this->send("setCampaignCustomFromAddress", $params);
	}

	/**
	 * Update a specified campaign and can be useful if you need to make changes to any settings or content to the
	 * campaign before it is sent.
	 *
	 * @link http://www.dotmailer.co.uk/api/campaigns/update_campaign.aspx
	 * @param campaign Campaign This is the campaign object; it can be used to set
	 * properties relating to the campaign you are creating.
	 * @throws CampaignInvalidException
	 * @throws CampaignNotFoundException
	 * @throws CampaignReadOnlyException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailableException
	 * @throws UnknownException
	 */
	public function updateCampaign(
		$id,
		$name,
		$subject,
		$htmlContent,
		$plaintextContent,
		$fromName,
		$replyAction = self::REPLY_ACTION_UNSET,
		$replyToAddress = "") {

		$campaign = new DotMailerEntity();
		$campaign->FromName = $fromName;
		$campaign->HTMLContent = $htmlContent;
		$campaign->Name = $name;
		$campaign->PlaintextContent = $plaintextContent;
		$campaign->ReplyAction = $replyAction;
		$campaign->ReplyToAddress = $replyToAddress;
		$campaign->Subject = $subject;
		$campaign->Id = $id;
		$campaign->Status = self::STATUS_NOT_SET;

		$params["campaign"] = $campaign;
		return $this->send("updateCampaign", $params);
	}
}