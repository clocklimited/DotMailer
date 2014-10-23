<?php
require_once("DotMailer.php");
require_once("DotMailerEntity.php");

/**
* Description
*
* @version 2.0
* @author Clock Ltd
* @copyright Clock Limited 2014
* @license http://opensource.org/licenses/bsd-license.php New BSD License
*/
class AddressBooks extends DotMailer {

	/**
	 * add a single contact into an address book.
	 * @link http://www.dotmailer.co.uk/api/address_books/add_contact_to_address_book.aspx
	 * @param $email
	 * @param $addressbookId
	 * @param null $dataFields
	 * @param string $audienceType
	 * @param string $optInType
	 * @param string $emailType
	 * @return string $contact
	 */
	public function addContactToAddressBook(
		$email,
		$addressbookId,
		$dataFields = null,
		$audienceType = "B2C",
		$optInType = "Single",
		$emailType = "Html"
	) {

		$contact = new DotMailerEntity();

		$contact->Email = $email;
		$contact->AudienceType = $audienceType;
		$contact->DataFields = $dataFields;
		$contact->OptInType = $optInType;
		$contact->EmailType = $emailType;

		$params = array();
		$params["apiContact"] = $contact->toArrayWithSoapVars();
		$params["addressBookId"] = $addressbookId;
		return $this->send("addContactToAddressBook", $params);
	}

	public function contactAlreadySubscribed($emailAddress) {
		$params["email"] = $emailAddress;
		$response = $this->send("getContactByEmail", $params);

		return is_object($response) && isset($response->GetContactByEmailResult)
			&& isset($response->GetContactByEmailResult->Email);
	}
}
