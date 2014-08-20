<?php

class DotMailerEntity {
	protected $parameters;

	public function __construct($params = array()) {
		$this->parameters = is_array($params) ? $params : array();
	}

	public function __set($name, $value) {
		$this->parameters[$name] = $value;
	}

	public function __get($name) {
		return isset($this->parameters[$name]) ? $this->parameters[$name] : null;
	}

	public function toArray() {
		return $this->parameters;
	}

	/**
	 * This function is similar to toArray apart from it replaces the values
	 * in the DataFields with SoapVars instead of default data types
	 */
	public function toArrayWithSoapVars() {
		$params = $this->parameters;
		if (isset($params['DataFields'])) {
			unset($params['DateFields']);
		}

		$dataFields = array();
		foreach ($this->parameters["DataFields"] as $key => $value) {
			if (is_string($value)) {
				$soapValue = new SoapVar($value, XSD_STRING, "string", "http://www.w3.org/2001/XMLSchema");
			} else if (is_int($value)) {
				$soapValue = new SoapVar(strval($value), XSD_STRING, "string", "http://www.w3.org/2001/XMLSchema");
			}

			if ($soapValue) {
				$dataFields[] = array(
					'Key' => $key,
					'Value' => $soapValue
				);
			}
		}

		if (!empty($dataFields)) {
			$params['DataFields'] =  $dataFields;
		}
		return $params;
	}

	public function __toXml() {
		// TODO
	}
}