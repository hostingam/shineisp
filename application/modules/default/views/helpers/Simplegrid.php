<?php
/**
 *
 * @version 0.1
 */
/**
 * Simplegrid helper
 * Create a simple grid with paging and sorting system.
 * Zebra Style and 
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_Simplegrid extends Zend_View_Helper_Abstract {
	public function simplegrid($data) {
		$this->view->module = Zend_Controller_Front::getInstance ()->getRequest ()->getModuleName ();
		$this->view->controller = Zend_Controller_Front::getInstance ()->getRequest ()->getControllerName ();
		$this->view->action = Zend_Controller_Front::getInstance ()->getRequest ()->getActionName ();
		if (isset ( $data ['records'] )) {
			// Name of the table, useful for the jQuery pager
			$this->view->name = !empty($data['name']) ? $data['name'] : "table_" . rand(1,50);
			// Index of the table 
			$this->view->id = (! empty ( $this->view->fields [0] ) && is_numeric ( $data ['records'] [0] [$this->view->fields [0]] )) ? $data ['records'] [0] [$this->view->fields [0]] : "0";
			// All the records 
			$this->view->records = $data ['records'];
			
			// If these options are true a link appear for each row in a table
			$this->view->edit = ! empty ( $data ['edit'] ) ? $data ['edit'] : false;
			$this->view->delete = ! empty ( $data ['delete'] ) ? $data ['delete'] : false;
			
			// If you need more action use this parameter Array{'url'=>'name'}
			$this->view->actions = ! empty ( $data ['actions'] ) ? $data ['actions'] : false;
			
			// Show/Hide the pager in the list
			$this->view->pager = ! empty ( $data ['pager'] ) ? true : false;
			
			// Path of the template
			return $this->view->render ( 'partials/simplegrid.phtml' );
		}
	}
}
