<?php

/**
 * Legalforms
 * Manage the legalforms items table
 * @version 1.0
 */

class Admin_LegalformsController extends Shineisp_Controller_Admin {
	
	protected $legalforms;
	protected $datagrid;
	protected $session;
	protected $translator;
	
	protected $readOnly = array(1,2,3); // These legal forms are readonly and cannot be deleted
	
	/**
	 * preDispatch
	 * Starting of the module
	 * (non-PHPdoc)
	 * @see library/Zend/Controller/Zend_Controller_Action#preDispatch()
	 */
	
	public function preDispatch() {
		$this->session = new Zend_Session_Namespace ( 'Admin' );
		$this->legalforms = new Legalforms();
		$this->translator = Shineisp_Registry::getInstance ()->Zend_Translate;
		$this->datagrid = $this->_helper->ajaxgrid;
		$this->datagrid->setModule ( "legalforms" )->setModel ( $this->legalforms );				
	}
	
	/**
	 * indexAction
	 * Create the User object and get all the records.
	 * @return unknown_type
	 */
	public function indexAction() {
		$redirector = Zend_Controller_Action_HelperBroker::getStaticHelper ( 'redirector' );
		$redirector->gotoUrl ( '/admin/legalforms/list' );
	}
	
	/**
	 * indexAction
	 * Create the User object and get all the records.
	 * @return datagrid
	 */
	public function listAction() {
		$this->view->title = $this->translator->translate("Customer's legal forms");
		$this->view->description = $this->translator->translate("Here you can see all the customer legal forms.");
		$this->view->buttons = array(array("url" => "/admin/legalforms/new/", "label" => $this->translator->translate('New'), "params" => array('css' => array('button', 'float_right'))));
		
		$this->datagrid->setConfig ( Legalforms::grid() )->datagrid ();
	}

	/**
	 * Load Json Records
	 *
	 * @return string Json records
	 */
	public function loadrecordsAction() {
		$this->_helper->ajaxgrid->setConfig ( Legalforms::grid() )->loadRecords ($this->getRequest ()->getParams());
	}
	
	/**
	 * searchProcessAction
	 * Search the record 
	 * @return unknown_type
	 */
	public function searchprocessAction() {
		$this->_helper->ajaxgrid->setConfig ( Legalforms::grid() )->search ();
	}
	
	/*
	 *  bulkAction
	 *  Execute a custom function for each item selected in the list
	 *  this method will be call from a jQuery script 
	 *  @return string
	 */
	public function bulkAction() {
		$this->_helper->ajaxgrid->massActions ();
	}
	
	/**
	 * recordsperpage
	 * Set the number of the records per page
	 * @return unknown_type
	 */
	public function recordsperpageAction() {
		$this->_helper->ajaxgrid->setRowNum ();
	}
	
	/**
	 * newAction
	 * Create the form module in order to create a record
	 * @return unknown_type
	 */
	public function newAction() {
		$this->view->form = $this->getForm ( "/admin/legalforms/process" );
		$this->view->title = $this->translator->translate("New Customers' legal forms");
		$this->view->description = $this->translator->translate("Here you can create a new customer legal forms.");
		$this->view->buttons = array(array("url" => "#", "label" => $this->translator->translate('Save'), "params" => array('css' => array('button', 'float_right'), 'id' => 'submit')),
								array("url" => "/admin/legalforms/list", "label" => $this->translator->translate('List'), "params" => array('css' => array('button', 'float_right'))));
		
		$this->render ( 'applicantform' );
	}

	/**
	 * deleteAction
	 * Delete a record previously selected by the reviews
	 * @return unknown_type
	 */
	public function deleteAction() {
		$id = $this->getRequest ()->getParam ( 'id' );
		if (is_numeric ( $id ) && !in_array($id, $this->readOnly) ) {
			Legalforms::deleteItem( $id );
		}
		return $this->_helper->redirector ( 'index', 'legalforms' );
	}
	
	/**
	 * confirmAction
	 * Ask to the user a confirmation before to execute the task
	 * @return null
	 */
	public function confirmAction() {
		$id = $this->getRequest ()->getParam ( 'id' );
		$controller = Zend_Controller_Front::getInstance ()->getRequest ()->getControllerName ();
		try {
			if (is_numeric ( $id )) {
				$this->view->goto = "/admin/$controller/delete/id/$id";
				$this->view->back = "/admin/$controller/edit/id/$id";
				$this->view->title = $this->translator->translate ( 'Are you sure to delete the record selected?' );
				$this->view->description = $this->translator->translate ( 'If you delete the customer legal form information the data will be no longer restored' );
				
				$record = $this->legalforms->find ( $id, null, true );
				$this->view->recordselected = $record [0] ['name'];
			} else {
				$this->_helper->redirector ( 'list', $controller, 'admin', array ('mex' => $this->translator->translate ( 'Unable to process request at this time.' ), 'status' => 'error' ) );
			}
		} catch ( Exception $e ) {
			echo $e->getMessage ();
		}
	}

	/**
	 * editAction
	 * Get a record and populate the application form 
	 * @return unknown_type
	 */
	public function editAction() {
		$form = $this->getForm ( '/admin/legalforms/process' );
		$id = $this->getRequest ()->getParam ( 'id' );
		
		// Create the buttons in the edit form
		$this->view->buttons = array(
				array("url" => "#", "label" => $this->translator->translate('Save'), "params" => array('css' => array('button', 'float_right'), 'id' => 'submit')),
				array("url" => "/admin/legalforms/list", "label" => $this->translator->translate('List'), "params" => array('css' => array('button', 'float_right'), 'id' => 'submit')),
				array("url" => "/admin/legalforms/new/", "label" => $this->translator->translate('New'), "params" => array('css' => array('button', 'float_right'))),
		);
		
		if ( !empty($id) && is_numeric($id) ) {
			$rs = Legalforms::getById( $id, null, true );
			if (! empty ( $rs[0] )) {
				$form->populate ( $rs[0] );
				
				if ( !in_array($id, $this->readOnly) ) {
					$this->view->buttons[] = array("url" => "/admin/legalforms/confirm/id/$id", "label" => $this->translator->translate('Delete'), "params" => array('css' => array('button', 'float_right')));
				}
			}
		}
		
		$this->view->mex = $this->getRequest ()->getParam ( 'mex' );
		$this->view->mexstatus = $this->getRequest ()->getParam ( 'status' );
		$this->view->title = $this->translator->translate("Legal form edit");
		$this->view->description = $this->translator->translate("Here you can edit the customer legal form information.");
		
		$this->view->form = $form;
		$this->render ( 'applicantform' );
	}
	
	/**
	 * processAction
	 * Update the record previously selected
	 * @return unknown_type
	 */
	public function processAction() {
		$redirector = Zend_Controller_Action_HelperBroker::getStaticHelper ( 'redirector' );
		$form = $this->getForm ( "/admin/legalforms/process" );
		$request = $this->getRequest ();
		
		// Create the buttons in the edit form
		$this->view->buttons = array(
				array("url" => "#", "label" => $this->translator->translate('Save'), "params" => array('css' => array('button', 'float_right'), 'id' => 'submit')),
				array("url" => "/admin/legalforms/list", "label" => $this->translator->translate('List'), "params" => array('css' => array('button', 'float_right'), 'id' => 'submit')),
				array("url" => "/admin/legalforms/new/", "label" => $this->translator->translate('New'), "params" => array('css' => array('button', 'float_right'))),
		);
		
		// Check if we have a POST request
		if (! $request->isPost ()) {
			return $this->_helper->redirector ( 'list', 'legalforms', 'admin' );
		}
		
		if ($form->isValid ( $request->getPost () )) {
			
			$params = $form->getValues ();
			
			// Get the id 
			$id = Legalforms::saveData($params, $params ['legalform_id']);
			if (is_numeric ( $id )) {
				$this->_helper->redirector ( 'edit', 'legalforms', 'admin', array ('id' => $id, 'mex' => $this->translator->translate ( "The task requested has been executed successfully." ), 'status' => 'success' ) );
			} else {
				$redirector->gotoUrl ( "/admin/legalforms/list/" );
			}
		} else {
			$this->view->form = $form;
			$this->view->title = "Legal form edit";
			$this->view->description = "Here you can edit the customer legal form information.";
			return $this->render ( 'applicantform' );
		}
	}
	
	/**
	 * getForm
	 * Get the customized application form 
	 * @return form
	 */
	private function getForm($action) {
		$form = new Admin_Form_LegalformsForm ( array ('action' => $action, 'method' => 'post' ) );
		return $form;
	}

}
