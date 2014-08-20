<?php
/**
* DotMailer PHP Wrapper
*
* @version 2.0
* @author James Mortemore
* @copyright Clock Limited 2014
* @license http://opensource.org/licenses/bsd-license.php New BSD License
*/
class DotMailer {
	public $soapClient;
	protected $dotMailerClient;

	protected $mockingException;
	protected $options;

	protected $exceptionMap = array(
		"ERROR_ADDRESSBOOK_DUPLICATE" 								=> "AddressBookDuplicateException",
		"ERROR_ADDRESSBOOK_INVALID"										=> "AddressBookInvalidException",
		"ERROR_ADDRESSBOOK_LIMITEXCEEDED"							=> "AddressBookLimitExceededException",
		"ERROR_ADDRESSBOOK_NOT_FOUND"									=> "AddressBookNotFoundException",
		"ERROR_ADDRESSBOOK_NOTWRITABLE"								=> "AddressBookNotWriteableException",
		"ERROR_APIUSAGE_EXCEEDED"											=> "ApiUsageExceededException",
		"ERROR_CAMPAIGN_INVALID"											=> "CampaignInvalidException",
		"ERROR_CAMPAIGN_NOT_FOUND"										=> "CampaignNotFoundException",
		"ERROR_CAMPAIGN_SENDNOTPERMITTED"							=> "CampaignSendNotPermittedException",
		"ERROR_CAMPAIGN_READONLY"											=> "CampaignReadOnlyException",
		"ERROR_CONTACT_INVALID"												=> "ContactInvalidException",
		"ERROR_CONTACT_NOT_FOUND"											=> "ContactNotFoundException",
		"ERROR_CONTACT_SUPPRESSEDFORADDRESSBOOK"			=> "ContactSuppressedException",
		"ERROR_CONTACT_SUPPRESSED"										=> "ContactSuppressedException",
		"ERROR_DATAFIELD_NOTFOUND"										=> "DatafieldNotFoundException",
		"ERROR_IMAGE_DATAEMPTY"												=> "ImageDataEmptyException",
		"ERROR_IMAGE_NAMEINVALID"											=> "ImageNameInvalidException",
		"ERROR_IMAGE_PARENTFOLDERDELETED"							=> "ImageParentFolderDeletedException",
		"ERROR_IMAGE_PARENTFOLDERDOESNOTEXIST"				=> "ImageParentFolderDoesNotExistException",
		"ERROR_IMAGE_UNSUPPORTEDFORMAT"								=> "ImageUnsupportedFormatException",
		"ERROR_IMPORT_TOOMANYACTIVEIMPORTS"						=> "ImportTooManyActiveImportsException",
		"ERROR_INVALID_EMAIL"													=> "InvalidEmailException",
		"ERROR_INVALID_LOGIN"													=> "InvalidLoginException",
		"ERROR_NO_EMAIL_COLUMN"												=> "NoEmailColumnException",
		"ERROR_PARAMETER_INVALID"											=> "ParameterInvalidException",
		"ERROR_SYSTEM_SERVICETEMPORARILYUNAVAILABLE"	=> "SystemServiceTemporarilyUnavailableException",
		"ERROR_UNKNOWN"																=> "UnknownException"
	);

	public function __construct(DotMailerClient $client, $logger = null) {
		$this->mockingException = $client->getMockException();
		$moreOptions = $client->getMoreOptions();
		$options = array("trace" => 1, "cache_wsdl" => WSDL_CACHE_BOTH);
		if (is_array($moreOptions)) {
			$options = array_merge($moreOptions, $options);
		}
		$this->dotMailerClient = $client;
		$loginOptions = array('login' => $client->getUsername(), 'password' => $client->getPassword());

		$this->options = array_merge($loginOptions, $options);

		$this->soapClient = new \SoapClient($client->getWsdl(), $this->options);

		$this->logger = $logger;
	}

	public function setAccountDetails($username, $password) {
		$this->dotMailerClient->setUsername($username);
		$this->dotMailerClient->setPassword($password);

		$loginOptions = array('login' => $username, 'password' => $password);

		$this->options = array_merge($this->options, $loginOptions);

		$this->soapClient = new \SoapClient($this->dotMailerClient->getWsdl(), $this->options);
	}

	/**
	 * Send your request to the DotMailer interface using SOAP.
	 *
	 * @param params Array containing your parameters.
	 * @return mixed The response from the SOAP request.
	 * @throws AddressBookDuplicateException
	 * @throws AddressBookInvalidException
	 * @throws AddressBookLimitExceededException
	 * @throws AddressBookNotFoundException
	 * @throws AddressBookNotWriteableException
	 * @throws ApiUsageExceededException
	 * @throws CampaignInvalidException
	 * @throws CampaignNotFoundException
	 * @throws CampaignSendNotPermittedException
	 * @throws ContactInvalidException
	 * @throws ContactNotFoundException
	 * @throws ContactSuppressedException
	 * @throws DatafieldNotFoundException
	 * @throws ImageDataEmptyException
	 * @throws ImageNameInvalidException
	 * @throws ImageParentFolderDeletedException
	 * @throws ImageParentFolderDoesNotExistException
	 * @throws ImageUnsupportedFormatException
	 * @throws ImportTooManyActiveImportsException
	 * @throws InvalidEmailException
	 * @throws InvalidLoginException
	 * @throws NoEmailColumnException
	 * @throws NotImplementedException
	 * @throws ParameterInvalidException
	 * @throws SystemServiceTemporarilyUnavailableException
	 * @throws UnknownException
	 */
	protected function send($methodName, array $params) {
        // @todo: remove from here and handle in tests
		if (!empty($this->mockingException)) {
			$exceptionClass = $this->mockingException;
			throw new $exceptionClass("Mock Exception");
		}

		try {
			$response = $this->doRequest($methodName, $params);
			if ($this->logger) {
				$this->logger->info("Success: " . $methodName);
				$this->logger->info($this->soapClient->__getLastRequest());
				$this->logger->info($this->soapClient->__getLastResponse());
			}
		} catch (\SoapFault $e) {
			if ($this->logger) {
				$this->logger->error("Error: " . $methodName);
				$this->logger->error($this->soapClient->__getLastRequest());
				$this->logger->error($this->soapClient->__getLastResponse());
			}
			$this->throwException($e->faultstring);
		}
		return $response;
	}

	public function formatDate(\DateTime $date) {
		return $date->format("Y-m-d\TH:i:s");
	}

	protected function doRequest($methodName, $params) {
		$response = $this->soapClient->$methodName($params);
		return $response;
	}

	protected function throwException($exception) {
		$exceptionName = trim(substr($exception, strrpos($exception, " ")));
		$message = trim(substr($exception, strpos($exception, "---> ") + 5));
		if (isset($this->exceptionMap[$exceptionName])) {
			$exceptionClass = $this->exceptionMap[$exceptionName];
			require_once("Exception/{$exceptionClass}.php");
			throw new $exceptionClass($message);
		} else {
			require_once("Exception/UnknownException.php");
			throw new UnknownException($message);
		}
	}
}
