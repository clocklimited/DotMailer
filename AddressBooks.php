<?php
require_once("DotMailer.php");
require_once("DotMailerEntity.php");

/**
* Description
*
* @version 1.0
* @author Clock Ltd
* @copyright Clock Limited 2012
* @license http://opensource.org/licenses/bsd-license.php New BSD License
*/
class AddressBooks extends DotMailer {
	const DATA_TYPE_CSV = "CSV";
	const DATA_TYPE_XLS = "XLS";

	const OPT_IN_TYPE_UNKNOWN = "Unknown";
	const OPT_IN_TYPE_SINGLE = "Single";
	const OPT_IN_TYPE_DOUBLE = "Double";
	const OPT_IN_TYPE_VERIFIED_DOUBLE = "VerifiedDouble";

	/**
	 * add a single contact into an address book.
	 * @link http://www.dotmailer.co.uk/api/address_books/add_contact_to_address_book.aspx
	 * @param string $contact
	 * @param int $addressbookID
	 * @return string $contact
	 * @throws AddressbookNotFoundException
	 * @throws AddressbookNotWritableException
	 * @throws ApiUsageExceededException
	 * @throws ContactInvalidException
	 * @throws ContactSuppressedException
	 * @throws ContactTooManyException
	 * @throws DatafieldNotFoundException
	 * @throws InvalidEmailException
	 * @throws InvalidLoginException
	 * @throws SystemServiceTemporarilyUnavailableException
	 * @throws UnknownException
	 */
	public function addContactToAddressBook(
		$email,
		$addressbookId,
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
		$params["addressbookId"] = $addressbookId;
		return $this->send("addContactToAddressBook", $params);
	}

	/**
	 * Description
	 * @link
	 * @param int $addressbookID
	 * @param base64Binary $data
	 * @param string $dataType. N.B see class constants
   * @throws AddressbookNotFoundException
   * @throws AddressbookNotWritableException
   * @throws ApiUsageExceededException
   * @throws ContactInvalidException
   * @throws ContactSuppressedException
   * @throws ContactTooManyException
   * @throws DatafieldNotFoundException
   * @throws InvalidEmailException
   * @throws InvalidLoginException
   * @throws SystemServiceTemporarilyUnavailableException
   * @throws UnknownException
   * @throws ImportTooManyActiveImportsException
   * @throws NoEmailColumnException
   * @throws ParameterInvalidException
	 * @return String $progressId
	 *
	 */
	public function addContactsToAddressBookWithProgress($addressbookID, $data, $dataType) {
		$params = array();
		$params["addressbookID"] = $addressbookID;
		$params["data"] = $data;
		$params["dataType"] = $dataType;

		return $this->send("AddContactsToAddressBookWithProgress", $params);
	}

	/**
	 * Creates an address book in your dotMailer account.
	 * @link http://www.dotmailer.co.uk/api/address_books/create_address_book.aspx
	 * @param string $book
	 * @return string $book
	 * @throws AddressBookDuplicateException
	 * @throws AddressBookInvalidException
	 * @throws AddressBookLimitExceededException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailableException
	 * @throws UnknownException
	 *
	 */
	public function createAddressBook($name) {
		$book = new DotMailerEntity();
		$book->Name = $name;
		$book->ID = -1;
		$params["book"] = $book;

		$result = $this->send("createAddressBook", $params);

		return $result->CreateAddressBookResult;
	}

	/**
	 * Delete an address book in your dotMailer account.
	 * @link http://www.dotmailer.co.uk/api/address_books/delete_address_book.aspx
	 * @param int $addressbookID
   * @throws AddressbookNotFoundException
   * @throws ApiUsageExceededException
   * @throws InvalidLoginException
   * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailableException
	 * @throws UnknownException
	 *
	 */
	public function deleteAddressBook($addressbookID) {
		$params = array();
		$params["addressbookid"] = $addressbookID;

		$this->send("deleteAddressBook", $params);
	}

	/**
	 * Get the number of contacts in a specified address book.
	 * @link http://www.dotmailer.co.uk/api/address_books/get_address_book_contact_count.aspx
	 * @param int $addressbookID
	 * @return int result The count of contacts
   * @throws AddressbookNotFoundException
   * @throws ApiUsageExceededException
   * @throws InvalidLoginException
   * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailableException
	 * @throws UnknownException
	 *
	 */
	public function getAddressBookContactCount($addressbookId) {
		$params = array();
		$params["addressbookid"] = $addressbookId;
		$response = $this->send("getAddressBookContactCount", $params);

		return $response->GetAddressBookContactCountResult;
	}

	/**
	 * Lists all the address books that a particular contact exists in.
	 * @link http://www.dotmailer.co.uk/api/address_books/list_address_books_for_contact.aspx
	 * @param string $contact
	 * @return array $addressBook
	 * @throws ContactNotFoundExeception
	 * @throws ContactSuppressedExeception
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailableException
	 * @throws UnknownException
	 *
	 */
	public function listAddressBooksForContact($contact) {
		$params = array();
		$params["contact"] = $contact;

		return $this->send("listAddressBooksForContact", $contact);
	}

	/**
	 * retrieves a list of all the contacts within a specified address book.
	 * @link http://www.dotmailer.co.uk/api/address_books/list_contacts_in_address_book.aspx
	 * @param int $addressbookID
	 * @param int $select
	 * @param int $skip
   * @throws AddressbookNotFoundException
   * @throws ApiUsageExceededException
   * @throws InvalidLoginException
   * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailableException
	 * @throws UnknownException
	 * @return array $contacts
	 *
	 */
	public function listContactsInAddressBook($addressbookID, $select, $skip) {
		$params = array();
		$params["addressBookId"] = $addressbookID;
		$params["select"] = $select;
		$params["skip"] = $skip;

		return $this->send("listContactsInAddressBook", $params);
	}

	/**
	 * Retrieves a list of all the contacts within a specified address book including their data.
	 * @link http://www.dotmailer.co.uk/api/address_books/list_contacts_in_address_book_with_full_data.aspx
	 * @param int $addressbookID
	 * @param int $select
	 * @param int $skip
   * @throws AddressbookNotFoundException
   * @throws ApiUsageExceededException
   * @throws InvalidLoginException
   * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailableException
	 * @throws UnknownException
	 * @return array $contacts
	 *
	 */
	public function listContactsInAddressBookWithFullData($addressbookID, $select, $skip) {
		$params = array();
		$params["addressBookId"] = $addressbookID;
		$params["select"] = $select;
		$params["skip"] = $skip;

		return $this->send("listContactsInAddressBookWithFullData", $params);
	}

	/**
	 * retrieves a list of contacts that were created on or after a given dateTime.
	 * @link http://www.dotmailer.co.uk/api/address_books/list_unsubscribers_address_book.aspx
	 * @param dateTime $startDate
	 * @param int $addressbookID
	 * @param int $select
	 * @param int $skip
   * @throws ApiUsageExceededException
   * @throws InvalidLoginException
   * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailableException
	 * @throws UnknownException
	 * @return array $contacts
	 *
	 */
	public function listUnsubscribersAddressBook($addressbookID, $select, $skip) {
		$params = array();
		$params["addressbookID"] = $addressbookID;
		$params["select"] = $select;
		$params["skip"] = $skip;

		return $this->send("listUnsubscribersAddressBook", $params);
	}

	/**
	 * Removes all contacts in a specified address book.
	 * @link http://www.dotmailer.co.uk/api/address_books/remove_all_contacts_from_address_book.aspx
	 * @param int $addressbookID
	 * @param bool $preventAddressbookResubscribe
	 * @param bool $totalUnsubscribe
   * @throws AddressbookNotFoundException
   * @throws ApiUsageExceededException
   * @throws InvalidLoginException
   * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailableException
	 * @throws UnknownException
	 *
	 */
	public function removeAllContactsFromAddressBook($addressbookID, $preventAddressbookResubscribe, $totalUnsubscribe) {
		$params = array();
		$params["addressbookID"] = $addressbookID;
		$params["preventAddressbookResubscribe"] = $preventAddressbookResubscribe;
		$params["totalUnsubscribe"] = $totalUnsubscribe;

		$this->send("removeAllContactsFromAddressBook", $params);
	}

	/**
	 * remove or suppress a contact from a specific address book. It can also be used to unsubscribe a contact completely
	 * from the whole dotMailer account.
	 * @link http://www.dotmailer.co.uk/api/address_books/remove_contact_from_address_book.aspx
	 * @param int $addressbookID
	 * @param bool $preventAddressbookResubscribe
	 * @param bool $totalUnsubscribe
   * @throws AddressbookNotFoundException
   * @throws ApiUsageExceededException
   * @throws InvalidLoginException
   * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailableException
	 * @throws UnknownException
	 *
	 */
	public function removeContactFromAddressBook($email, $addressbookID, $preventAddressbookResubscribe, $totalUnsubscribe) {
		$contact = new DotMailerEntity();
		$contact->Email = $email;

		$params = array();
		$params["contact"] = $contact->toArrayWithSoapVars();
		$params["addressbookID"] = $addressbookID;
		$params["preventAddressbookResubscribe"] = $preventAddressbookResubscribe;
		$params["totalUnsubscribe"] = $totalUnsubscribe;

		$this->send("removeContactFromAddressBook", $params);
	}

	/**
	 * remove or suppress a contact from a specific address book. It can also be used to unsubscribe a contact completely
	 * from the whole dotMailer account.
	 * @link http://www.dotmailer.co.uk/api/address_books/remove_contact_from_address_book.aspx
	 * @param int $addressbookID
	 * @param bool $preventAddressbookResubscribe
	 * @param bool $totalUnsubscribe
   * @throws AddressbookNotFoundException
   * @throws ApiUsageExceededException
   * @throws InvalidLoginException
   * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailableException
	 * @throws UnknownException
	 *
	 */
	public function getContactImportProgress($progressID) {
		$params = array();
		$params["progressID"] = $progressID;

		return $this->send("getContactImportProgress", $params);
	}
}
