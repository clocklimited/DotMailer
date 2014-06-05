<?php

require_once("Account.php");
require_once("AddressBooks.php");
require_once("Campaigns.php");
require_once("Contacts.php");
require_once("DotMailer.php");
require_once("DotMailerClient.php");
require_once("DotMailerEntity.php");
require_once("Images.php");
require_once("Reporting.php");
require_once("Test/Preferences.php");

require_once("Exception/AddressBookLimitExceededException.php");
require_once("Exception/ApiUsageExceededException.php");
require_once("Exception/CampaignSendNotPermittedException.php");
require_once("Exception/ContactSuppressedException.php");
require_once("Exception/DatafieldNotFoundException.php");
require_once("Exception/ImageNameInvalidException.php");
require_once("Exception/ImageParentFolderDeletedException.php");
require_once("Exception/ImageUnsupportedFormatException.php");
require_once("Exception/ImportTooManyActiveImportsException.php");
require_once("Exception/InvalidEmailException.php");
require_once("Exception/NoEmailColumnException.php");
require_once("Exception/ParameterInvalidException.php");
require_once("Exception/SystemServiceTemporarilyUnavailableException.php");

require_once("Exception/UnknownException.php");

class DotMailerTest extends \PHPUnit_Framework_TestCase {
	public $client;

	public function __construct() {
		$this->dotMailerClient = DotMailerClient::getInstance(array(
			"wsdl"      => Preferences::WSDL,
			"username"  => Preferences::USERNAME,
			"password"  => Preferences::PASSWORD
		));
	}

	public function testDotMailerClient() {
		$this->assertNotEmpty($this->dotMailerClient->getUsername());
		$this->assertNotEmpty($this->dotMailerClient->getPassword());
		$this->assertNotEmpty($this->dotMailerClient->getWsdl());
	}

	/**
	 * @expectedException AddressBookDuplicateException
	 */
	public function testApiThrowsAddressBookDuplicateException() {
		$addressBook = new DotMailerEntity();
		$addressBook->ID = -1;
		$addressBook->Name = "AddressBook";
		$client = new AddressBooks($this->dotMailerClient);
		$book = $client->createAddressBook($addressBook);
		$client->createAddressBook($addressBook);
	}

	/**
	 * @expectedException AddressBookInvalidException
	 */
	public function testApiThrowsAddressBookInvalidException() {
		$addressBook = new DotMailerEntity();
		$addressBook->ID = -1;
		$client = new AddressBooks($this->dotMailerClient);
		$client->createAddressBook($addressBook);
	}

	/**
	 * @expectedException AddressBookLimitExceededException
	 */
	public function testApiThrowsAddressBookLimitExceededException() {
		$dotMailerClient = DotMailerClient::getInstance(array(
			"wsdl"      => Preferences::WSDL,
			"username"  => Preferences::USERNAME,
			"password"  => Preferences::PASSWORD
		), array(), "AddressBookLimitExceededException");
		$client = new AddressBooks($dotMailerClient);
		$book = new DotMailerEntity();
		$book->ID = -1;
		$book->Name = "testBook";
		$client->createAddressBook($book);
	}

	/**
	 * @expectedException AddressBookNotWriteableException
	 */
	public function testApiThrowsAddressBookNotWriteableException() {
		// Test Address Book id = 1015872
		$contact = new DotMailerEntity();
		$contact->Email = "test@clock.co.uk";
		$contact->ID = -1;
		$contact->OptInType = AddressBooks::OPT_IN_TYPE_UNKNOWN;
		$contact->AudienceType = Contacts::AUDIENCE_TYPE_UNKNOW;
		$contact->EmailType = Contacts::CONTACT_EMAIL_TYPE_PLAIN;
		$client = new AddressBooks($this->dotMailerClient);
		$client->addContactToAddressBook($contact, 1015872);
	}

	/**
	 * @expectedException ApiUsageExceededException
	 */
	public function testApiThrowsApiUsageExceededException() {
		$dotMailerClient = DotMailerClient::getInstance(array(
			"wsdl"      => Preferences::WSDL,
			"username"  => Preferences::USERNAME,
			"password"  => Preferences::PASSWORD
		), array(), "ApiUsageExceededException");
		$client = new Images($dotMailerClient);
		$client->uploadImage(0, "", realpath(dirname(__FILE__) . "/Fixtures/a.txt"));
	}

	/**
	 * @expectedException CampaignInvalidException
	 */
	public function testApiThrowsCampaignInvalidException() {
		$client = new Campaigns($this->dotMailerClient);
		$client->createCampaign(-1, "", "", "",
			Campaigns::REPLY_ACTION_UNSET, "", "");
	}

	/**
	* @expectedException CampaignNotFoundException
	*/
	public function testApiThrowsCampaignNotFoundException() {
		$this->client = new Campaigns($this->dotMailerClient);
		$this->client->getCampaign(-1);
	}

	/**
	 * @expectedException CampaignSendNotPermittedException
	 */
	public function testApiThrowsCampaignSendNotPermittedException() {
		$dotMailerClient = DotMailerClient::getInstance(array(
			"wsdl"      => Preferences::WSDL,
			"username"  => Preferences::USERNAME,
			"password"  => Preferences::PASSWORD
		), array(), "CampaignSendNotPermittedException");
		$client = new Campaigns($dotMailerClient);
		$client->sendCampaignToAddressBooksWithProgress(0, array(1), new \DateTime());
	}

	/**
	 * @expectedException ContactInvalidException
	 */
	public function testApiThrowsContactInvalidException() {
		$contact = new DotMailerEntity();
		$contact->ID = -1;
		$contact->AudienceType = Contacts::AUDIENCE_TYPE_UNKNOW;
		$contact->OptInType = AddressBooks::OPT_IN_TYPE_UNKNOWN;
		$contact->EmailType = Contacts::CONTACT_EMAIL_TYPE_PLAIN;
		$client = new Contacts($this->dotMailerClient);
		$client->createContact($contact);
	}

	/**
	 * @expectedException ContactNotFoundException
	 */
	public function testApiThrowsContactNotFoundException() {
		$client = new Contacts($this->dotMailerClient);
		$client->getContactByEmail("someEmail@somedomain.com");
	}

	/**
	 * @expectedException ContactSuppressedException
	 */
	public function testApiThrowsContactSuppressedException() {
		$dotMailerClient = DotMailerClient::getInstance(array(
			"wsdl"      => Preferences::WSDL,
			"username"  => Preferences::USERNAME,
			"password"  => Preferences::PASSWORD
		), array(), "ContactSuppressedException");
		$client = new Images($dotMailerClient);
		$client->uploadImage(0, "", realpath(dirname(__FILE__) . "/Fixtures/a.txt"));
	}

	/**
	 * @expectedException DatafieldNotFoundException
	 */
	public function testApiThrowsDatafieldNotFoundException() {
		$dotMailerClient = DotMailerClient::getInstance(array(
			"wsdl"      => Preferences::WSDL,
			"username"  => Preferences::USERNAME,
			"password"  => Preferences::PASSWORD
		), array(), "DatafieldNotFoundException");
		$client = new Images($dotMailerClient);
		$client->uploadImage(0, "", realpath(dirname(__FILE__) . "/Fixtures/a.txt"));
	}

	/**
	 * @expectedException ImageDataEmptyException
	 */
	public function testApiThrowsImageDataEmptyException() {
		$client = new Images($this->dotMailerClient);
		$client->uploadImage(0, "test-image", realpath(dirname(__FILE__) . "/Fixtures/a.txt"));
	}

	/**
	 * @expectedException ImageNameInvalidException
	 */
	public function testApiThrowsImageNameInvalidException() {
		$dotMailerClient = DotMailerClient::getInstance(array(
			"wsdl"      => Preferences::WSDL,
			"username"  => Preferences::USERNAME,
			"password"  => Preferences::PASSWORD
		), array(), "ImageNameInvalidException");
		$client = new Images($dotMailerClient);
		$client->uploadImage(0, "", realpath(dirname(__FILE__) . "/Fixtures/a.txt"));
	}

	/**
	 * @expectedException ImageParentFolderDeletedException
	 */
	public function testApiThrowsImageParentFolderDeletedException() {
		$dotMailerClient = DotMailerClient::getInstance(array(
			"wsdl"      => Preferences::WSDL,
			"username"  => Preferences::USERNAME,
			"password"  => Preferences::PASSWORD
		), array(), "ImageParentFolderDeletedException");
		$client = new Images($dotMailerClient);
		$client->uploadImage(0, "", realpath(dirname(__FILE__) . "/Fixtures/a.txt"));
	}

	/**
	 * @expectedException ImageParentFolderDoesNotExistException
	 */
	public function testApiThrowsImageParentFolderDoesNotExistException() {
		$client = new Images($this->dotMailerClient);
		$client->createImageFolder("folderName", -1);
	}

	/**
	 * @expectedException ImageUnsupportedFormatException
	 */
	public function testApiThrowsImageUnsupportedFormatException() {
		$dotMailerClient = DotMailerClient::getInstance(array(
			"wsdl"      => Preferences::WSDL,
			"username"  => Preferences::USERNAME,
			"password"  => Preferences::PASSWORD
		), array(), "ImageUnsupportedFormatException");

		$client = new Images($dotMailerClient);
		$client->uploadImage(0, "", realpath(dirname(__FILE__) . "/Fixtures/a.txt"));
	}

	/**
	 * @expectedException ImportTooManyActiveImportsException
	 */
	public function testApiThrowsImportTooManyActiveImportsException() {
		$dotMailerClient = DotMailerClient::getInstance(array(
			"wsdl"      => Preferences::WSDL,
			"username"  => Preferences::USERNAME,
			"password"  => Preferences::PASSWORD
		), array(), "ImportTooManyActiveImportsException");
		$client = new Images($dotMailerClient);
		$client->uploadImage(0, "", realpath(dirname(__FILE__) . "/Fixtures/a.txt"));
	}

	/**
	 * @expectedException InvalidEmailException
	 */
	public function testApiThrowsInvalidEmailException() {
		// As yet an InvalidEmailException is not thrown from the DotMailer
		// API so this method always errors.
		$dotMailerClient = DotMailerClient::getInstance(array(
			"wsdl"      => Preferences::WSDL,
			"username"  => Preferences::USERNAME,
			"password"  => Preferences::PASSWORD
		), array(), "InvalidEmailException");
		$client = new Contacts($dotMailerClient);
		$client->getContactStatusByEmail("~'##;{some.invalid}email@domain.com");
	}

	/**
	 * @expectedException InvalidLoginException
	 */
	public function testApiThrowsInvalidLoginException() {
		$dotMailerClient = DotMailerClient::getInstance(array(
			"wsdl"      => Preferences::WSDL,
			"username"  => "invalidUsername",
			"password"  => "invalidPassword"
		), array(), "", true);
		$client = new Account($dotMailerClient);
		$client->getCurrentAccountInfo();
	}

	/**
	 * @expectedException NoEmailColumnException
	 */
	public function testApiThrowsNoEmailColumnException() {
		$dotMailerClient = DotMailerClient::getInstance(array(
			"wsdl"      => Preferences::WSDL,
			"username"  => Preferences::USERNAME,
			"password"  => Preferences::PASSWORD
		), array(), "NoEmailColumnException");
		// The method we call doesn't matter because we are mocking the exception
		$client = new Images($dotMailerClient);
		$client->uploadImage(0, "", realpath(dirname(__FILE__) . "/Fixtures/a.txt"));
	}

	/**
	 * @expectedException ParameterInvalidException
	 */
	public function testApiThrowsParameterInvalidException() {
		$dotMailerClient = DotMailerClient::getInstance(array(
			"wsdl"      => Preferences::WSDL,
			"username"  => Preferences::USERNAME,
			"password"  => Preferences::PASSWORD
		), array(), "ParameterInvalidException");
		$client = new Images($dotMailerClient);
		// Second parameter should be string - int given.
		$client->uploadImage(0, 12, realpath(dirname(__FILE__) . "/Fixtures/testImage.png"));
	}

	/**
	 * @expectedException SystemServiceTemporarilyUnavailableException
	 */
	public function testApiThrowsSystemServiceTemporarilyUnavailableException() {
		$dotMailerClient = DotMailerClient::getInstance(array(
			"wsdl"      => Preferences::WSDL,
			"username"  => Preferences::USERNAME,
			"password"  => Preferences::PASSWORD
		), array(), "SystemServiceTemporarilyUnavailableException");
		$client = new Images($dotMailerClient);
		$client->uploadImage(0, "", realpath(dirname(__FILE__) . "/Fixtures/a.txt"));
	}

	/**
	 * @expectedException UnknownException
	 */
	public function testApiThrowsUnknownException() {
		$dotMailerClient = DotMailerClient::getInstance(array(
			"wsdl"      => Preferences::WSDL,
			"username"  => Preferences::USERNAME,
			"password"  => Preferences::PASSWORD
		), array(), "UnknownException");
		$client = new Images($dotMailerClient);
		$client->uploadImage(0, "", realpath(dirname(__FILE__) . "/Fixtures/a.txt"));
	}
}