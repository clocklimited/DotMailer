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
		if (isset($this->parameters["DataFields"]["Values"])) {
			foreach ($this->parameters["DataFields"]["Values"] as &$value) {
				if (is_string($value)) {
					$value = new SoapVar($value, XSD_STRING, "string", "http://www.w3.org/2001/XMLSchema");
				} elseif (is_int($value)) {
					$value = new SoapVar(strval($value), XSD_STRING, "string", "http://www.w3.org/2001/XMLSchema");
				}
			}
		}
		return $this->parameters;
	}

	public function __toXml() {
		// TODO
	}
}