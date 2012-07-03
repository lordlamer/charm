<?php

class Crm_Array {
	/**
	 * filter an array and return only the given keys from the array
	 * @param array $keys
	 * @param array $values
	 * @return array
	 */
	public function filter($keys, $values) {
		if(!is_array($keys) || !is_array($values)) return null;

		$array = array();

		foreach($keys as $value) {
			if($this->isKeyInArray($value, $values)) {
				$array[$value] = $values[$value];
			}
		}

		return $array;
	}

	/**
	 * check if key is in array
	 * @param string $key
	 * @param array $array
	 * @return bool return true if key is found
	 */
	public function isKeyInArray($key, $array) {
		if(!is_array($array)) return false;

		foreach($array as $arrKey => $arrValue) {
			if($arrKey == $key) {
				return true;
			}
		}

		return false;
	}
}

?>
