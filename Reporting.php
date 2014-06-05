<?php
require_once("DotMailer.php");
/**
* Reporting class provides access to DotMailer reporting methods
*
* @version 1.0
* @author Oliver Johnstone
* @copyright Clock Limited 2012
* @license http://opensource.org/licenses/bsd-license.php New BSD License
*/
class Reporting extends DotMailer {

	/**
	 * Get the number of forwards or estimated forwards relating to a specified campaign from a specified contact.
	 *
	 * @link http://www.dotmailer.co.uk/api/reporting/get_campaign_contact_forward_info.aspx
	 * @param campaignId Integer This is the ID of the campaign you wish to query against
	 * @param contactId Integer This is the ID of the contact you want to find the related forwards for.
	 * @param getEstimates Boolean If specified as true it will get the Estimated forwards for that particular contact
	 *		relating to that campaign.
	 * @return Integer The number of forwards (or estimated forwards).
	 * @throws CampaignNotFoundException
	 * @throws ContactInvalidException
	 * @throws ContactNotFoundException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function getCampaignContactForwardInfo($campaignId, $contactId, $getEstimates = false) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$params["contactId"] = $contactId;
		$params["getEstimates"] = $getEstimates;
		return $this->send("GetCampaignContactForwardInfo", $params);
	}

	/**
	 * Returns a list of contacts that were sent a specified campaign and their interaction with it.
	 *
	 * @link http://www.dotmailer.co.uk/api/reporting/list_campaign_activities.aspx
	 * @param campaignId Integer This is the ID of the campaign you wish to query against.
	 * @param select Integer This is a number which indicates the number of records you wish to select.
	 *		This argument must no greater than 1000.
	 * @param skip Integer This is a number which is the number of records you want to skip; to select
	 *		all records from 1001 to 2000: set this number to 1000.
	 * @return Array of APIContactSummary objects
	 * @throws CampaignNotFoundException
	 * @throws CampaignInvalidException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function listCampaignActivities($campaignId, $select, $skip) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$params["select"] = $select;
		$params["skip"] = $skip;
		return $this->send("ListCampaignActivities", $params);
	}

	/**
	 * Returns a list of contacts that were sent a specified campaign after a certain dateTime.
	 *
	 * @link http://www.dotmailer.co.uk/api/reporting/list_campaign_activities_since_date.aspx
	 * @param campaignId Integer This is the ID of the campaign you wish to query against.
	 * @param startDate DateTime This is the dateTime you wish to begin selecting data from
	 * @param select Integer This is a number which indicates the number of records you wish to select.
	 *		This argument must no greater than 1000
	 * @param skip Integer This is a number which is the number of records you want to skip;
	 *		to select all records from 1001 to 2000: set this number to 1000.
	 * @return Array of APIContactSummary objects.
	 * @throws CampaignNotFoundException
	 * @throws CampaignInvalidException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function listCampaignActivitiesSinceDate($campaignId, $startDate, $select, $skip) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$params["startDate"] = $startDate;
		$params["select"] = $select;
		$params["skip"] = $skip;
		return $this->send("ListCampaignActivitiesSinceDate", $params);
	}

	/**
	 * @deprecated Use listCampaignClickers2.
	 * @link http://www.dotmailer.co.uk/api/reporting/list_campaign_clickers.aspx
	 */
	public function listCampaignClickers() {
		throw new NotImplementedException();
	}

	/**
	 * Returns a list of contacts that clicked on at least one link in a specified campaign.
	 *
	 * @link http://www.dotmailer.co.uk/api/reporting/list_campaign_clickers_2.aspx
	 * @param campaignId Integer This is the ID of the campaign you wish to query against.
	 * @param select Integer This is a number which indicates the number of records you wish to select.
	 *		This argument must no greater than 1000.
	 * @param skip Integer This is a number which is the number of records you want to skip;
	 *		to select all records from 1001 to 2000: set this number to 1000.
	 * @return Array of APICampaignContactClick3 objects
	 * @throws CampaignNotFoundException
	 * @throws CampaignInvalidException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function listCampaignClickers2($campaignId, $select, $skip) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$params["select"] = $select;
		$params["skip"] = $skip;
		$response = $this->send("ListCampaignClickers2", $params);
		if (count((array) $response->ListCampaignClickers2Result) > 0) {
			if (!is_array($response->ListCampaignClickers2Result->APICampaignContactClick3)) {
				return array($response->ListCampaignClickers2Result->APICampaignContactClick3);
			}
			return $response->ListCampaignClickers2Result->APICampaignContactClick3;
		} else {
			return false;
		}
	}

	/**
	 * Returns data for a specific contact's interaction with a specific campaign.
	 *
	 * @link http://www.dotmailer.co.uk/api/reporting/list_campaign_contact_activity.aspx
	 * @param campaignId Integer This is the ID of the campaign you wish to query against.
	 * @param contactId Integer This is the ID of the contact you wish to query against.
	 * @return Array of values representing contact activity.
	 * @throws CampaignNotFoundException
	 * @throws CampaignInvalidException
	 * @throws ContactInvalidException
	 * @throws ContactNotFoundException
	 * @throws ContactSuppressedException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function listCampaignContactActivity($campaignId, $contactId) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$params["contactId"] = $contactId;
		return $this->send("ListCampaignContactActivity", $params);
	}

	/**
	 * Deprecated, Use listCampaignContactClicks2.
	 *
	 * @link http://www.dotmailer.co.uk/api/reporting/list_campaign_contact_clicks.aspx
	 */
	public function listCampaignContactClicks() {
		throw new Exception\NotImplementedException();
	}

	/**
	 * Returns a list of clicks that a contact has made within a specified campaign.
	 *
	 * @link http://www.dotmailer.co.uk/api/reporting/list_campaign_contact_clicks_2.aspx
	 * @param campaignId Integer This is the ID of the campaign you wish to query against.
	 * @param contactId Integer This is the ID of the contact you wish to query against.
	 * @param select Integer This is a number which indicates the number of records you wish to select.
	 *		This argument must no greater than 1000.
	 * @param skip Integer This is a number which is the number of records you want to skip;
	 *		to select all records from 1001 to 2000: set this number to 1000.
	 * @return Array of APICampaignContactClick3 objects
	 * @throws CampaignNotFoundException
	 * @throws CampaignInvalidException
	 * @throws ContactInvalidException
	 * @throws ContactNotFoundException
	 * @throws ContactSuppressedException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function listCampaignContactClicks2($campaignId, $contactId, $select, $skip) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$params["contactId"] = $contactId;
		$params["select"] = $select;
		$params["skip"] = $skip;
		return $this->send("ListCampaignContactClicks2", $params);
	}

	/**
	 * Retrieve a list of stats about a campaign opens for a contact.
	 *
	 * @link http://www.dotmailer.co.uk/api/reporting/list_campaign_contact_opens.aspx
	 * @param campaignId Integer This is the ID of the campaign you wish to query against.
	 * @param contactId Integer This is the ID of the contact you wish to query against.
	 * @param select Integer This is a number which indicates the number of records you wish to select.
	 *		This argument must no greater than 1000.
	 * @param skip Integer This is a number which is the number of records you want to skip;
	 *		to select all records from 1001 to 2000: set this number to 1000.
	 * @return Array of APICampaignContactOpen objects.
	 * @throws CampaignNotFoundException
	 * @throws CampaignInvalidException
	 * @throws ContactInvalidException
	 * @throws ContactNotFoundException
	 * @throws ContactSuppressedException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function listCampaignContactOpens($campaignId, $contactId, $select, $skip) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$params["contactId"] = $contactId;
		$params["select"] = $select;
		$params["skip"] = $skip;
		return $this->send("ListCampaignContactClicks2", $params);
	}

	/**
	 * Retrieve a list of stats about page views generated by a campaign for a contact.
	 *
	 * @link http://www.dotmailer.co.uk/api/reporting/list_campaign_contact_page_views.aspx
	 * @param campaignId Integer This is the ID of the campaign you wish to query against.
	 * @param contactId Integer This is the ID of the contact you wish to query against.
	 * @param select Integer This is a number which indicates the number of records you wish to select.
	 *		This argument must no greater than 1000.
	 * @param skip Integer This is a number which is the number of records you want to skip;
	 *		to select all records from 1001 to 2000: set this number to 1000.
	 * @return Array of APICampaignContactPageView objects
	 * @throws CampaignNotFoundException
	 * @throws CampaignInvalidException
	 * @throws ContactInvalidException
	 * @throws ContactNotFoundException
	 * @throws ContactSuppressedException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function listCampaignContactPageViews($campaignId, $contactId, $select, $skip) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$params["contactId"] = $contactId;
		$params["select"] = $select;
		$params["skip"] = $skip;
		return $this->send("ListCampaignContactPageViews", $params);
	}

	/**
	 * Retrieve a list of replies and contact has made to a campaign.
	 *
	 * @link http://www.dotmailer.co.uk/api/reporting/list_campaign_contact_replies.aspx
	 * @param campaignId Integer This is the ID of the campaign you wish to query against.
	 * @param contactId Integer This is the ID of the contact you wish to query against.
	 * @param select Integer This is a number which indicates the number of records you wish to select.
	 *		This argument must no greater than 1000.
	 * @param skip Integer This is a number which is the number of records you want to skip;
	 *		to select all records from 1001 to 2000: set this number to 1000.
	 * @return Array of APICampaignContactReply objects
	 * @throws CampaignNotFoundException
	 * @throws CampaignInvalidException
	 * @throws ContactInvalidException
	 * @throws ContactNotFoundException
	 * @throws ContactSuppressedException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function listCampaignContactReplies($campaignId, $contactId, $select, $skip) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$params["contactId"] = $contactId;
		$params["select"] = $select;
		$params["skip"] = $skip;
		return $this->send("ListCampaignContactReplies", $params);
	}

	/**
	 * Retrieve ROI information for a contact for a campaign.
	 *
	 * @link http://www.dotmailer.co.uk/api/reporting/list_campaign_contact_roi_detail.aspx
	 * @param campaignId Integer This is the ID of the campaign you wish to query against.
	 * @param contactId Integer This is the ID of the contact you wish to query against.
	 * @param select Integer This is a number which indicates the number of records you wish to select.
	 *		This argument must no greater than 1000.
	 * @param skip Integer This is a number which is the number of records you want to skip;
	 *		to select all records from 1001 to 2000: set this number to 1000.
	 * @return Array of APICampaignContactROI objects
	 * @throws CampaignNotFoundException
	 * @throws CampaignInvalidException
	 * @throws ContactInvalidException
	 * @throws ContactNotFoundException
	 * @throws ContactSuppressedException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function listCampaignContactRoiDetail($campaignId, $contactId, $select, $skip) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$params["contactId"] = $contactId;
		$params["select"] = $select;
		$params["skip"] = $skip;
		return $this->send("ListCampaignContactRoiDetail", $params);
	}

	/**
	 * Retrieves a list of social bookmark views for a specific contact.
	 *
	 * @link http://www.dotmailer.co.uk/api/reporting/list_campaign_contact_social_bookmark_views.aspx
	 * @param campaignId Integer This is the ID of the campaign you wish to query against.
	 * @param contactId Integer This is the ID of the contact you wish to query against.
	 * @param select Integer This is a number which indicates the number of records you wish to select.
	 *		This argument must no greater than 1000.
	 * @param skip Integer This is a number which is the number of records you want to skip;
	 *		to select all records from 1001 to 2000: set this number to 1000.
	 * @return Array of APICampaignContactSocialBookmark objects
	 * @throws CampaignNotFoundException
	 * @throws CampaignInvalidException
	 * @throws ContactInvalidException
	 * @throws ContactNotFoundException
	 * @throws ContactSuppressedException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function listCampaignContactSocialBookmarkViews($campaignId, $contactId, $select, $skip) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$params["contactId"] = $contactId;
		$params["select"] = $select;
		$params["skip"] = $skip;
		return $this->send("ListCampaignContactSocialBookmarkViews", $params);
	}

	/**
	 * Returns a list of openers for a specified campaign. It will provide information on the openers email address,
	 *		email client used to open the email and the version of that email client.
	 *
	 * @link http://www.dotmailer.co.uk/api/reporting/list_campaign_openers.aspx
	 * @param campaignId Integer This is the ID of the campaign you wish to query against.
	 * @param select Integer This is a number which indicates the number of records you wish to select.
	 *		This argument must no greater than 1000.
	 * @param skip Integer This is a number which is the number of records you want to skip;
	 *		to select all records from 1001 to 2000: set this number to 1000.
	 * @return Array of APICampaignContactOpen2 objects
	 * @throws CampaignNotFoundException
	 * @throws CampaignInvalidException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function listCampaignOpeners($campaignId, $select, $skip) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$params["contactId"] = $contactId;
		$params["select"] = $select;
		$params["skip"] = $skip;
		return $this->send("ListCampaignOpeners", $params);
	}

	/**
	 * Retrieve a list of stats about page views generated by a campaign.
	 *
	 * @link http://www.dotmailer.co.uk/api/reporting/list_campaign_page_views.aspx
	 * @param campaignId Integer This is the ID of the campaign you wish to query against.
	 * @param startDate DateTime The earliest date that you wish to retrieve data from.
	 * @param select Integer This is a number which indicates the number of records you wish to select.
	 *		This argument must no greater than 1000.
	 * @param skip Integer This is a number which is the number of records you want to skip;
	 *		to select all records from 1001 to 2000: set this number to 1000.
	 * @return Array of APICampaignPageView objects
	 * @throws CampaignNotFoundException
	 * @throws CampaignInvalidException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function listCampaignPageViews($campaignId, $startDate, $select, $skip) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$params["startDate"] = $startDate;
		$params["select"] = $select;
		$params["skip"] = $skip;
		return $this->send("ListCampaignPageViews", $params);
	}

	/**
	 * Retrieve ROI information for all contacts affected by a specific campaign.
	 *
	 * @link http://www.dotmailer.co.uk/api/reporting/list_campaign_roi_detail_since_date.aspx
	 * @param campaignId Integer This is the ID of the campaign you wish to query against.
	 * @param startDate DateTime This is the dateTime that you would like to begin selecting Campaigns from (server time).
	 * @param select Integer This is a number which indicates the number of records you wish to select.
	 *		This argument must no greater than 1000.
	 * @param skip Integer This is a number which is the number of records you want to skip;
	 *		to select all records from 1001 to 2000: set this number to 1000.
	 * @return Array of APICampaignRoiDetail objects
	 * @throws CampaignNotFoundException
	 * @throws CampaignInvalidException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function listCampaignRoiDetailSinceDate($campaignId, $startDate, $select, $skip) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$params["startDate"] = $startDate;
		$params["select"] = $select;
		$params["skip"] = $skip;
		return $this->send("ListCampaignRoiDetailSinceDate", $params);
	}

	/**
	 * Retrieves a list of social bookmark views generated by a campaign.
	 *
	 * @link http://www.dotmailer.co.uk/api/reporting/list_campaign_social_bookmark_views.aspx
	 * @param campaignId Integer This is the ID of the campaign you wish to query against.
	 * @param select Integer This is a number which indicates the number of records you wish to select.
	 *		This argument must no greater than 1000.
	 * @param skip Integer This is a number which is the number of records you want to skip;
	 *		to select all records from 1001 to 2000: set this number to 1000.
	 * @return Array of APICampaignSocialBookmark objects
	 * @throws CampaignNotFoundException
	 * @throws CampaignInvalidException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function listCampaignSocialBookmarkViews($campaignId, $select, $skip) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$params["select"] = $select;
		$params["skip"] = $skip;
		return $this->send("ListCampaignSocialBookmarkViews", $params);
	}
}