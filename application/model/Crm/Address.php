<?php

class Crm_Address {
	/**
	 * internal link to global class
	 * @var $class
	 */
	private $class = null;

	/**
	 * construct
	 */
	public function __construct() {
		$this->class = Crm_Registry::get('class');
	}

	/**
	 * get companylist
	 * @param string $namePrefix
	 * @return array
	 */
	public function getCompanies($namePrefix = null) {
		$companies = array();

		if($namePrefix == null) {
			$res = $this->class->db->query("SELECT * FROM company WHERE deleted=0 AND disabled=0 ORDER BY name");
		} else {
			$res = $this->class->db->query("SELECT * FROM company WHERE name ilike :prefix AND deleted=0 AND disabled=0 ORDER BY name", array(':prefix' => $namePrefix.'%'));
		}

		$companies = $res->fetchAll();

		return $companies;
	}

	/**
	 * get company data
	 * @param integer $companyid
	 * @return array
	 */
	public function getCompany($companyId) {
		$company = $this->class->db->fetchRow('SELECT * FROM company WHERE deleted=0 AND disabled=0 AND id=:companyid', array(':companyid' => $companyId));
		return $company;
	}

	/**
	 * get list of contacts
	 * @param integer $companyid
	 * @return array
	 */
	public function getContacts($companyId) {
		return $this->class->db->fetchAll('SELECT * FROM companycontact WHERE deleted=0 AND disabled=0 AND companyid=:companyid ORDER BY name ASC', array(':companyid' => $companyId));
	}

	/**
	 * get contact data
	 * @param integer $contactid
	 * @return array
	 */
	public function getContact($contactId) {
		$contact = $this->class->db->fetchRow('SELECT * FROM companycontact WHERE deleted=0 AND disabled=0 AND id=:companycontactid', array(':companycontactid' => $contactId));
		return $contact;
	}

	/**
	 * add a company
	 * @param array $values
	 * @return int companyid
	 */
	public function addCompany($values) {
		if(isset($values['submit'])) unset($values['submit']);
		$this->class->db->insert('company', $values);
		return $this->class->db->lastSequenceId('seq_master');
	}

	/**
	 * edit a company
	 * @param integer $id
	 * @param array $values
	 * @return bool
	 */
	public function editCompany($id, $values) {
		if(isset($values['submit'])) unset($values['submit']);
		$n = $this->class->db->update('company', $values, 'id = '.$id);
		if($n == 1) return true;
		else false;
	}

	/**
	 * delete company
	 * @param integer $companyid
	 * @return bool
	 */
	public function deleteCompany($companyid) {
		$this->class->db->update('company', array('deleted' => 1), 'id = '.$companyid);
		return true;
	}

	/**
	 * disable company
	 * @param integer $companyid
	 * @return bool
	 */
	public function disableCompany($companyid) {
		$this->class->db->update('company', array('disabled' => 1), 'id = '.$companyid);
		return true;
	}

	/**
	 * add a companycontact
	 * @param array $values
	 * @return bool
	 */
	public function addContact($values) {
		if(isset($values['submit'])) unset($values['submit']);
		$this->class->db->insert('companycontact', $values);
		return $this->class->db->lastSequenceId('seq_master');
	}

	/**
	 * edit a companycontact
	 * @param integer $id
	 * @param array $values
	 * @return bool
	 */
	public function editContact($id, $values) {
		if(isset($values['submit'])) unset($values['submit']);
		$n = $this->class->db->update('companycontact', $values, 'id = '.$id);
		if($n == 1) return true;
		else false;
	}

	/**
	 * delete companycontact
	 * @param integer $contactid
	 * @return bool
	 */
	public function deleteContact($contactid) {
		$this->class->db->update('companycontact', array('deleted' => 1), 'id = '.$contactid);
		return true;
	}

	/**
	 * disable companycontact
	 * @param integer $contactid
	 * @return bool
	 */
	public function disableContact($contactid) {
		$this->class->db->update('companycontact', array('disabled' => 1), 'id = '.$contactid);
		return true;
	}

	public function deleteTagedCompanies() {

	}

	public function deleteTagedContacts() {

	}

	public function addLine() {

	}

	public function editLine() {

	}

	public function deleteLine() {

	}

	public function addCompanyLineMapping() {

	}

	public function editCompanyLineMapping() {
		// vielleicht nicht sinnvoll
	}

	public function deleteCompanyLineMapping() {

	}

	/**
	 * return number of company contacts
	 * @param integer $companyid
	 * @return integer number of contacts
	 */
	public function countCompanyContacts($companyid) {
		$res = $this->class->db->query("SELECT count(id) as no FROM companycontact WHERE companyid=:companyid AND deleted=0 AND disabled=0", array(':companyid' => $companyid));
		$no = $res->fetch();
		return $no['no'];
	}
}

?>
