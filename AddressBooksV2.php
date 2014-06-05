<?php
require_once("DotMailerV2.php");
require_once("DotMailerEntity.php");

/**
* Description
*
* @version 2.0
* @author Clock Ltd
* @copyright Clock Limited 2014
* @license http://opensource.org/licenses/bsd-license.php New BSD License
*/
class AddressBooksV2 extends DotMailerV2 {

	/**
	 * Update an address book
	 * @link http://api.dotmailer.com/v2/api.svc#op.ApiService.UpdateAddressBook
	 * @param int $addressbookID
	 * @param string $name
	 * @throws AddressbookNotFoundException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailableException
	 * @throws UnknownException
	 *
	 */
	public function updateAddressBook($addressbookID, $name) {
		$params = array();
		$params["apiAddressBook"]["Id"] = $addressbookID;
		$params["apiAddressBook"]["Name"] = $name;

		return $this->send("updateAddressBook", $params);
	}

	public function getAddressBook($addressbookID) {
		$params = array();
		$params["id"] = $addressbookID;

		return $this->send("GetAddressBookById", $params);
	}
}
