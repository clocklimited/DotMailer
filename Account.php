<?php

require_once("DotMailer.php");

/**
* Account is a wrapper for the DotMailer API which provides CRUD operations on
* DotMailer accounts.
*
* @version 1.0
* @author Clock Ltd
* @copyright Clock Limited 2012
* @license http://opensource.org/licenses/bsd-license.php New BSD License
* @link http://www.dotmailer.co.uk/api/more_about_api/list_of_api_methods.aspx#account
*/
class Account extends DotMailer {

	/**
	 *  Can be used to get a summary of information about the current status of the account.
	 *
	 *	@link http://www.dotmailer.co.uk/api/account/get_current_account_info.aspx
	 *
	 *  @return array of APIAccountProperty objects, each consisting of.
	 *  @throws ApiUsageExceededException
	 *  @throws InvalidLoginException
	 *  @throws ParameterInvalidException
	 *  @throws SystemServiceTemporarilyUnavailableException
	 *  @throws UnknownException
	 */
	public function getCurrentAccountInfo() {
		return $this->send("GetCurrentAccountInfo", array());
	}

	/**
	 *	Returns the UTC time as set on the server
	 *	@link http://www.dotmailer.co.uk/api/account/get_server_time.aspx
	 *	@return dateTime
	 *	@throws SystemServiceTemporarilyUnavailableException
	 *	@throws UnknownException
	 */
	public function getServerTime() {
		return $this->send("GetServerTime", array());
	}

	/**
	 *	Will return the ID numbers of the address books which you will need for other API methods
	 *
	 *	@link http://www.dotmailer.co.uk/api/account/list_public_address_books.aspx
	 *
	 *	@return array
	 *	@throws ApiUsageExceededException
	 *	@throws InvalidLoginException
	 *	@throws ParameterInvalidException
	 *	@throws SystemServiceTemporarilyUnavailableException
	 *	@throws UnknownException
	 */
	public function listPublicAddressBooks() {
		return $this->send("ListPublicAddressBooks", array());
	}

	/**
	 *	Will return the ID numbers of the address books which you will need for other API methods
	 *
	 *	@link http://www.dotmailer.co.uk/api/account/list_private_address_books.aspx
	 *
	 *	@return array
	 *	@throws ApiUsageExceededException
	 *	@throws InvalidLoginException
	 *	@throws ParameterInvalidException
	 *	@throws SystemServiceTemporarilyUnavailableException
	 *	@throws UnknownException
	 */
	public function listPrivateAddressBooks() {
		return $this->send("ListPrivateAddressBooks", array());
	}

	/**
	 *	lists all the available address books within the your dotMailer account.
	 *
	 *	@link http://www.dotmailer.co.uk/api/account/list_address_books.aspx
	 *
	 *	@return array
	 *	@throws ApiUsageExceededException
	 *	@throws InvalidLoginException
	 *	@throws ParameterInvalidException
	 *	@throws SystemServiceTemporarilyUnavailableException
	 *	@throws UnknownException
	 */
	public function listAddressBooks() {
		return $this->send("ListAddressBooks", array());
	}

	/**
	 *	returns a list of the available custom from addresses in the dotMailer account you are connected to.
	 *
	 *	@link http://www.dotmailer.co.uk/api/account/list_available_custom_from_addresses.aspx
	 *
	 *	@return array
	 *	@throws ApiUsageExceededException
	 *	@throws InvalidLoginException
	 *	@throws ParameterInvalidException
	 *	@throws SystemServiceTemporarilyUnavailableException
	 *	@throws UnknownException
	 */
	public function listAvailableCustomFromAddresses() {
		$response = $this->send("ListAvailableCustomFromAddresses", array());
		if (count((array) $response->ListAvailableCustomFromAddressesResult) > 0) {
			return $response->ListAvailableCustomFromAddressesResult->APICustomFromAddress;
		}
		return false;
	}

	/**
	 *	lists all the campaigns within the your dotMailer account.
	 *
	 *	@link http://www.dotmailer.co.uk/api/account/list_campaigns_2.aspx
	 *
	 *	@param $select int number of records to select, must be less than 1000
	 *	@param $skip int number of records to skip
	 *	@return array
	 *	@throws ApiUsageExceededException
	 *	@throws InvalidLoginException
	 *	@throws ParameterInvalidException
	 *	@throws SystemServiceTemporarilyUnavailableException
	 *	@throws UnknownException
	 */
	public function listCampaigns() {
		return $this->send("ListCampaigns", array());
	}
}