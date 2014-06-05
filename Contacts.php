<?php
require_once("DotMailer.php");
/**
* Contacts Class is a DotMailer wrapper that contains all the method that are
* related to the DotMailer contact object.
*
* @version 1.0
* @author Clock Ltd
* @copyright Clock Limited 2012
* @license http://opensource.org/licenses/bsd-license.php New BSD License
*/
class Contacts extends DotMailer {

	const AUDIENCE_TYPE_UNKNOW = "Unknown";
	const AUDIENCE_TYPE_B2C = "B2C";
	const AUDIENCE_TYPE_B2B = "B2B";
	const AUDIENCE_TYPE_B2M = "B2M";

	const CONTACT_EMAIL_TYPE_PLAIN = "PlainText";
	const CONTACT_EMAIL_TYPE_HTML = "Html";

	/**
	 * Creates a contact
	 * @param  Object Contact object
	 * @return Object Contact object
	 * @throws ContactInvalidException If the object passed is invalid
	 * @throws ContactSuppressedException If the contact is suppressed
	 * @throws ContactTooManyException Contact limit reached
	 * @throws DataFieldNotFoundException One or more of the data fields you are
	 * 																		trying to set for the contact does not exist
	 * @throws ApiUsageExceededException API usage reached
	 * @throws InvalidLoginException Invalid login credentials
	 * @throws ParameterInvalidException One of the method parameters sent is invalid
	 * @throws SystemServiceTemporarilyUnavailableException API is down
	 * @throws UnknownErrorException Unknown error
	 * @link http://www.dotmailer.co.uk/api/contacts/create_contact.aspx
	 */
	public function createContact(
		$email,
		$dataFields = null,
		$audienceType = "B2C",
		$optInType = "Single",
		$emailType = "Html",
		$notes = null
		) {

		$contact = new DotMailerEntity();
		$contact->ID = -1;
		$contact->Email = $email;
		$contact->AudienceType = $audienceType;
		$contact->DataFields = $dataFields;
		$contact->OptInType = $optInType;
		$contact->EmailType = $emailType;
		$contact->Notes = $notes;

		$params = array();
		$params["contact"] = $contact->toArrayWithSoapVars();

		$response = $this->send("createContact", $params);
		return $response->CreateContactResult;
	}

	/**
	 * Returns a contact by an email address
	 * @param  String $emailAddress Email address of contact
	 * @return Object Contact object
	 * @throws ContactNotFoundException Contact not found
	 * @throws ApiUsageExceededException API usage reached
	 * @throws InvalidLoginException Invalid login credentials
	 * @throws ParameterInvalidException One of the method parameters sent is invalid
	 * @throws SystemServiceTemporarilyUnavailableException API is down
	 * @throws UnknownErrorException Unknown error
	 * @link http://www.dotmailer.co.uk/api/contacts/get_contact_by_email.aspx
	 */
	public function getContactByEmail($emailAddress) {
		$params = array();
		$params["email"] = $emailAddress;
		$response = $this->send("getContactByEmail", $params);
		return $response->GetContactByEmailResult;
	}

	/**
	 * Returns a contact by an id
	 * @param  Integer $id Id
	 * @return Object Contact object
	 * @throws ContactNotFoundException Contact not found
	 * @throws ApiUsageExceededException API usage reached
	 * @throws InvalidLoginException Invalid login credentials
	 * @throws ParameterInvalidException One of the method parameters sent is invalid
	 * @throws SystemServiceTemporarilyUnavailableException API is down
	 * @throws UnknownErrorException Unknown error
	 * @link http://www.dotmailer.co.uk/api/contacts/get_contact_by_id.aspx
	 */
	public function getContactById($id) {
		$params = array();
		$params["id"] = $id;
		return $this->send("getContactById", $params);
	}

	/**
	 * Returns the current progress of an import
	 * @param  guid   $progressId Progress GUID returned by AddContactsToAddressBookWithProgress
	 * @return String Finished or NotFinished or RejectedByWatchdog or InvalidFileFormat or Unknown
	 * @throws ImportNotFoundException GUID was not found
	 * @throws ImportTooManyActiveImportsException Reached limit of imports
	 * @throws ApiUsageExceededException API usage reached
	 * @throws InvalidLoginException Invalid login credentials
	 * @throws ParameterInvalidException One of the method parameters sent is invalid
	 * @throws SystemServiceTemporarilyUnavailableException API is down
	 * @throws UnknownErrorException Unknown error
	 * @link http://www.dotmailer.co.uk/api/contacts/get_contact_import_progress.aspx
	 */
	public function getContactImportProgress($progressId) {
		$params = array();
		$params["progressId"] = $progressId;
		return $this->send("getContactImportProgress", $params);
	}

	/**
	 * Returns a report with statistics about what was successfully imported
	 * and what was unable to be imported in a specific report
	 * @param  guid $progressId Progress GUID returned by AddContactsToAddressBookWithProgress
	 * @return Array
	 * @throws ImportNotFoundException GUID was not found
	 * @throws ApiUsageExceededException API usage reached
	 * @throws InvalidLoginException Invalid login credentials
	 * @throws ParameterInvalidException One of the method parameters sent is invalid
	 * @throws SystemServiceTemporarilyUnavailableException API is down
	 * @throws UnknownErrorException Unknown error
	 * @link http://www.dotmailer.co.uk/api/contacts/get_contact_import_report.aspx
	 */
	public function getContactImportReport($progressId) {
		$params = array();
		$params["progressId"] = $progressId;
		return $this->send("getContactImportReport", $params);
	}

	/**
	 * Returns all records that were not successfully imported in your contact report
	 * @param  guid $progressId This is a GUID which is returned to you when you call AddContactsToAddressBookWithProgress
	 * @return base64Binary A base64 encoded CSV file, which is UTF-8 encoded containing all records not successfully imported
	 * @throws ImportNotFoundException GUID was not found
	 * @throws ApiUsageExceededException API usage reached
	 * @throws InvalidLoginException Invalid login credentials
	 * @throws ParameterInvalidException One of the method parameters sent is invalid
	 * @throws SystemServiceTemporarilyUnavailableException API is down
	 * @throws UnknownErrorException Unknown error
	 * @link http://www.dotmailer.co.uk/api/contacts/get_contact_import_report_faults.aspx
	 */
	public function getContactImportReportFaults($progressId) {
		$params = array();
		$params["id"] = $id;
		return $this->send("getContactImportReportFaults", $params);
	}

	/**
	 * Returns the current status (subscribed, deleted and so on - see below for a full list) of a contact.
	 * @param  String $emailAddress Email address of contact
	 * @return String Status of contact
	 * @throws ApiUsageExceededException API usage reached
	 * @throws InvalidEmailException Email address is invalid
	 * @throws InvalidLoginException Invalid login credentials
	 * @throws SystemServiceTemporarilyUnavailableException API is down
	 * @throws UnknownErrorException Unknown error
	 * @link http://www.dotmailer.co.uk/api/contacts/get_contact_status_by_email.aspx
	 */
	public function getContactStatusByEmail($emailAddress) {
		$params = array();
		$params["emailAddress"] = $emailAddress;
		return $this->send("getContactStatusByEmail", $params);
	}

	/**
	 * Returns a list of all the contacts who hard bounced when sent a specified campaign
	 * @param  Integer $campaignId Campaign Id
	 * @param  Integer $select     Number of records to select
	 * @param  Integer $skip       Number of records to skip before selecting
	 * @return Array                Array of contact objects
	 * @throws CampaignInvalidException
	 * @throws CampaignNotFoundException
	 * @throws ApiUsageExceededException API usage reached
	 * @throws InvalidLoginException Invalid login credentials
	 * @throws ParameterInvalidException One of the method parameters sent is invalid
	 * @throws SystemServiceTemporarilyUnavailableException API is down
	 * @throws UnknownErrorException Unknown error
	 * @link http://www.dotmailer.co.uk/api/contacts/list_hard_bounces_contacts_2.aspx
	 */
	public function listHardBouncesContacts2($campaignId, $select, $skip) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$params["select"] = $select;
		$params["skip"] = $skip;
		return $this->send("listHardBouncesContacts2", $params);
	}

	/**
	 * Returns a list of all the contacts who hard bounced when sent a specified campaign along with any specified data labels
	 * @param  Integer $campaignId Campaign Id
	 * @param  Integer $labels     The names of the data fields you want to get the data for
	 * @param  Array   $select     Number of records to select
	 * @param  Integer $skip       Number of records to skip before selecting
	 * @return Integer             Array of contact objects
	 * @throws CampaignInvalidException
	 * @throws CampaignNotFoundException
	 * @throws ApiUsageExceededException API usage reached
	 * @throws InvalidLoginException Invalid login credentials
	 * @throws ParameterInvalidException One of the method parameters sent is invalid
	 * @throws SystemServiceTemporarilyUnavailableException API is down
	 * @throws UnknownErrorException Unknown error
	 * @link http://www.dotmailer.co.uk/api/contacts/list_hard_bouncing_contacts_with_labels_2.aspx
	 */
	public function listHardBouncingContactsWithLabels2($campaignId, $labels, $select, $skip) {
		$params = array();
		$params["campaignId"] = $campaignId;
		$params["labels"] = $labels;
		$params["select"] = $select;
		$params["skip"] = $skip;
		return $this->send("listHardBouncingContactsWithLabels2", $params);
	}

	/**
	 * Returns a list of contacts who were modified on or after a given date
	 * @param  dateTime $startDate The date from which you wish to query
	 * @param  Integer $select     Number of records to select
	 * @param  Integer $skip       Number of records to skip before selecting
	 * @return Array               Array of contact objects
	 * @throws ApiUsageExceededException API usage reached
	 * @throws InvalidLoginException Invalid login credentials
	 * @throws ParameterInvalidException One of the method parameters sent is invalid
	 * @throws SystemServiceTemporarilyUnavailableException API is down
	 * @throws UnknownErrorException Unknown error
	 * @link http://www.dotmailer.co.uk/api/contacts/list_modified_contacts_2.aspx
	 */
	public function lastModifiedContacts2($startDate, $select, $skip) {
		$params = array();
		$params["startDate"] = $startDate;
		$params["select"] = $select;
		$params["skip"] = $skip;
		return $this->send("lastModifiedContacts2", $params);
	}

	/**
	 * Returns a list of contacts that were suppressed on or after a given dateTime
	 * @param  dateTime $startDate The date from which you wish to query
	 * @param  Integer $select     Number of records to select
	 * @param  Integer $skip       Number of records to skip before selecting
	 * @return Array               Array of contact objects
	 * @throws ApiUsageExceededException API usage reached
	 * @throws InvalidLoginException Invalid login credentials
	 * @throws ParameterInvalidException One of the method parameters sent is invalid
	 * @throws SystemServiceTemporarilyUnavailableException API is down
	 * @throws UnknownErrorException Unknown error
	 * @link http://www.dotmailer.co.uk/api/contacts/list_suppressed_contacts.aspx
	 */
	public function listSuppressedContacts($startDate, $select, $skip) {
		$params = array();
		$params["startDate"] = $startDate;
		$params["select"] = $select;
		$params["skip"] = $skip;
		$response = $this->send("listSuppressedContacts", $params);

		if (isset($response->ListSuppressedContactsResult->APIContactSuppressionSummary)) {
			if (is_array($response->ListSuppressedContactsResult->APIContactSuppressionSummary)) {
				return $response->ListSuppressedContactsResult->APIContactSuppressionSummary;
			} else {
				return array($response->ListSuppressedContactsResult->APIContactSuppressionSummary);
			}
		}
		return false;
	}

	/**
	 * Returns a list of contacts that unsubscribed after a given dateTime
	 * @param  dateTime $startDate The date from which you wish to query
	 * @return Array               Array of contact objects
	 * @throws ApiUsageExceededException API usage reached
	 * @throws InvalidLoginException Invalid login credentials
	 * @throws ParameterInvalidException One of the method parameters sent is invalid
	 * @throws SystemServiceTemporarilyUnavailableException API is down
	 * @throws UnknownErrorException Unknown error
	 * @link http://www.dotmailer.co.uk/api/contacts/list_unsubscribers.aspx
	 */
	public function listUnsubscribers($startDate) {
		$params = array();
		$params["startDate"] = $startDate;
		return $this->send("listUnsubscribers", $params);
	}

	/**
	 * Resubscribes a previously unsubscribed contact.
	 * @param  Contact  $ApiContact                 The contact object you want to resubscribe
	 * @param  Interger $addressbookID              The book to add the contact to
	 * @param  String   $preferredLocale            The locale of the contact
	 * @param  String   $returnUrlToUseIfChallenged End point URL if contact is challenged before resubscribe
	 * @return String                               ContactAdded, ContactChallenged or ContactCannotBeUnsuppressed
	 * @throws AddressBookNotFoundException
	 * @throws AddressBookNotWritableException
	 * @throws ApiUsageExceededException API usage reached
	 * @throws ContactInvalidException
	 * @throws ContactTooManyException Contact limit reached
	 * @throws DataFieldNotFoundException One or more of the data fields you are
	 * 																		trying to set for the contact does not exist
	 * @throws InvalidEmailException Email address is invalid
	 * @throws InvalidLoginException Invalid login credentials
	 * @throws SystemServiceTemporarilyUnavailableException API is down
	 * @throws UnknownErrorException Unknown error
	 * @link http://www.dotmailer.co.uk/api/contacts/resubscribe_contact.aspx
	 */
	public function resubscribeContact($apiContact, $addressbookID) {
		$params = array();
		if (is_array($apiContact)) {
			$apiContact = (object)$apiContact;
		}
		$params["contact"] = $apiContact;
		$params["addressBookId"] = $addressbookID;
		// $params["preferredLocale"] = $preferredLocale;
		// $params["returnUrlToUseIfChallenged"] = $returnUrlToUseIfChallenged;
		return $this->send("resubscribeContact", $params);
	}

	/**
	 * Updates a contact
	 * @param  Contact $contact The contact object you want to update
	 * @throws ContactInvalidException If the contact doesn't exist
	 * @throws ContactNotFoundException Contact not found
	 * @throws ContactSuppressedException If the contact is suppressed
	 * @throws ApiUsageExceededException API usage reached
	 * @throws InvalidLoginException Invalid login credentials
	 * @throws ParameterInvalidException One of the method parameters sent is invalid
	 * @throws SystemServiceTemporarilyUnavailableException API is down
	 * @throws UnknownErrorException Unknown error
	 * @link http://www.dotmailer.co.uk/api/contacts/update_contact.aspx
	 */
	public function updateContact($contact) {
		$params = array();
		$params["contact"] = $contact;
		return $this->send("updateContact", $params);
	}
}
