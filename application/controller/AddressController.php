<?php

class AddressController extends Zend_Controller_Action {
	private $class = null;

	public function init() {
		$this->class = Crm_Registry::get('class');
		$this->view->class = $this->class;
	}

	public function __call($name, $params) {
		$this->_forward('index');
	}

	public function indexAction() {
		$this->_forward('list');
	}

	public function listAction() {
		$companies = new Crm_Address();

		if($this->getRequest()->getParam('search') != '') {
			$this->view->companies = $companies->getCompanies($this->getRequest()->getParam('search'));
			$this->view->search = $this->getRequest()->getParam('search');
		} else {
			$this->view->companies = $companies->getCompanies();
			$this->view->search = '';
		}
	}

	public function showcompanyAction() {
		$company = new Crm_Address();
		$this->view->company = $company->getCompany($this->getRequest()->getParam('id'));
		$this->view->companycontactsno = $company->countCompanyContacts($this->getRequest()->getParam('id'));
		$this->view->activetab = 'company';
	}

	public function editcompanyAction() {
		$company = new Crm_Address();
		$this->view->company = $company->getCompany($this->getRequest()->getParam('id'));
		$this->view->companycontactsno = $company->countCompanyContacts($this->getRequest()->getParam('id'));
		$this->view->activetab = 'company';

		$form = new Crm_Form_Address_Company();
		$form->setAction('./address/editcompany');

		$form->addElement('hidden', 'id', array('value' => $this->getRequest()->getParam('id')));

		if($this->getRequest()->isPost() && $form->isValid($_POST)) {
			// save and redirect
			$company->editCompany($this->getRequest()->getParam('id'), $form->getValues());
			$this->_redirect('./address/showcompany/id/'.$this->getRequest()->getParam('id'));
		} else {
			// fill up with values
			$form->fillForm($this->view->company);

			// show form
			$this->view->form = $form;
		}
	}

	public function addcompanyAction() {
		$form = new Crm_Form_Address_Company();
		$form->setAction('./address/addcompany');

		if($this->getRequest()->isPost() && $form->isValid($_POST)) {
			// save
			$company = new Crm_Address();
			$companyid = $company->addCompany($form->getValues());

			// redirect to company
			$this->_redirect('./address/showcompany/id/'.$companyid);
		} else {
			// show form
			$this->view->form = $form;
		}
	}

	public function showcontactsAction() {
		$contacts = new Crm_Address();
		$this->view->contacts = $contacts->getContacts($this->getRequest()->getParam('id'));
		$this->view->company = $contacts->getCompany($this->getRequest()->getParam('id'));
		$this->view->companycontactsno = $contacts->countCompanyContacts($this->getRequest()->getParam('id'));
		$this->view->activetab = 'contact';
	}

	public function addcontactAction() {
		$company = new Crm_Address();
		$this->view->company = $company->getCompany($this->getRequest()->getParam('id'));
		$this->view->companycontactsno = $company->countCompanyContacts($this->getRequest()->getParam('id'));
		$this->view->activetab = 'contact';

		$form = new Crm_Form_Address_Contact();
		$form->setAction('./address/addcontact');

		$form->addElement('hidden', 'companyid', array('value' => $this->getRequest()->getParam('id')));

		if($this->getRequest()->isPost() && $form->isValid($_POST)) {
			// save
			$company = new Crm_Address();
			$contactid = $company->addContact($form->getValues());

			// make redirect
			$this->_redirect('./address/showcontact/id/'.$contactid);
		} else {
			// show form
			$this->view->form = $form;
		}
	}

	public function editcontactAction() {
		$company = new Crm_Address();
		$this->view->contact = $company->getContact($this->getRequest()->getParam('id'));
		$this->view->company = $company->getCompany($this->view->contact['companyid']);
		$this->view->companycontactsno = $company->countCompanyContacts($this->view->contact['companyid']);
		$this->view->activetab = 'contact';

		$form = new Crm_Form_Address_Contact();
		$form->setAction('./address/editcontact');

		$form->addElement('hidden', 'id', array('value' => $this->getRequest()->getParam('id')));

		if($this->getRequest()->isPost() && $form->isValid($_POST)) {
			// save and redirect
			$company->editContact($this->getRequest()->getParam('id'), $form->getValues());
			$this->_redirect('./address/showcontact/id/'.$this->getRequest()->getParam('id'));
		} else {
			// fill up with values
			$form->fillForm($this->view->contact);

			// show form
			$this->view->form = $form;
		}
	}

	public function showcontactAction() {
		$company = new Crm_Address();
		$this->view->contact = $company->getContact($this->getRequest()->getParam('id'));
		$this->view->company = $company->getCompany($this->view->contact['companyid']);
		$this->view->companycontactsno = $company->countCompanyContacts($this->view->contact['companyid']);
		$this->view->activetab = 'contact';
	}

	public function delcompanyAction() {
		$company = new Crm_Address();
		$this->view->company = $company->getCompany($this->getRequest()->getParam('id'));
		$this->view->companycontactsno = $company->countCompanyContacts($this->getRequest()->getParam('id'));
		$this->view->activetab = 'company';

		$form = new Zend_Form();
		//$form->clearDecorators();
		$form->setAction('./address/delcompany');
		$form->setMethod('post');

		$hidden = new Zend_Form_Element_Hidden('id');
		$hidden->setValue($this->getRequest()->getParam('id'));
		$hidden->addDecorators(array(
                         'ViewHelper',
                         'Errors',
                         array('HtmlTag', array('tag' => 'div')),
                         array('Label', array('tag' => 'div')),
                 ));
		$form->addElement($hidden);

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->clearDecorators();
		$submit->setLabel('Wirklich loeschen!');
		$submit->setAttrib('class', 'button');
		$submit->addDecorators(array(
                         'ViewHelper',
                         'Errors',
                         array('HtmlTag', array('tag' => 'div')),
                 ));
		$form->addElement($submit);

		if($this->getRequest()->isPost() && $form->isValid($_POST)) {
			// delete and redirect
			$company->deleteCompany($this->getRequest()->getParam('id'));
			$this->_redirect('./address');
		} else {
			$this->view->confirmform = $form;
		}
	}

	public function delcontactAction() {
		$company = new Crm_Address();
		$this->view->contact = $company->getContact($this->getRequest()->getParam('id'));
		$this->view->company = $company->getCompany($this->view->contact['companyid']);
		$this->view->companycontactsno = $company->countCompanyContacts($this->view->contact['companyid']);
		$this->view->activetab = 'contact';

		$form = new Zend_Form();
		//$form->clearDecorators();
		$form->setAction('./address/delcontact');
		$form->setMethod('post');

		$hidden = new Zend_Form_Element_Hidden('id');
		$hidden->setValue($this->getRequest()->getParam('id'));
		$hidden->addDecorators(array(
                         'ViewHelper',
                         'Errors',
                         array('HtmlTag', array('tag' => 'div')),
                         array('Label', array('tag' => 'div')),
                 ));
		$form->addElement($hidden);

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->clearDecorators();
		$submit->setLabel('Wirklich loeschen!');
		$submit->setAttrib('class', 'button');
		$submit->addDecorators(array(
                         'ViewHelper',
                         'Errors',
                         array('HtmlTag', array('tag' => 'div')),
                 ));
		$form->addElement($submit);

		if($this->getRequest()->isPost() && $form->isValid($_POST)) {
			// delete and redirect
			$company->deleteContact($this->getRequest()->getParam('id'));
			$this->_redirect('./address/showcompany/id/'.$this->view->company['id']);
		} else {
			$this->view->confirmform = $form;
		}
	}

	public function vcardexportAction() {
		$company = new Crm_Address();
		$this->view->contact = $company->getContact($this->getRequest()->getParam('id'));
		$this->view->company = $company->getCompany($this->view->contact['companyid']);

		$filename = $this->view->contact['firstname'] . '_' . $this->view->contact['name'] . '.vcf';

		header("Content-Type: text/x-vcard; name=\"$filename\"");
		header("Content-Disposition: attachment; filename=\"$filename\";");
		header("Pragma: private");
		header("Expires: 0");
		header("Cache-Control: private, must-revalidate, post-check=0, pre-check=0");
		header("Content-Transfer-Encoding: binary");

		$this->_helper->layout->disableLayout();
	}

	public function companyvcardexportAction() {
		$company = new Crm_Address();
		$this->view->contact = $company->getContact($this->getRequest()->getParam('id'));
		$this->view->company = $company->getCompany($this->view->contact['companyid']);

		$filename = $this->view->contact['firstname'] . '_' . $this->view->contact['name'] . '.vcf';

		header("Content-Type: text/x-vcard; name=\"$filename\"");
		header("Content-Disposition: attachment; filename=\"$filename\";");
		header("Pragma: private");
		header("Expires: 0");
		header("Cache-Control: private, must-revalidate, post-check=0, pre-check=0");
		header("Content-Transfer-Encoding: binary");

		$this->_helper->layout->disableLayout();
	}
}

?>
