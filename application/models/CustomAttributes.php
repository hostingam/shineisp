<?php

/**
 * CustomAttributes
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class CustomAttributes extends BaseCustomAttributes
{
/**
	 * Create a custom attribute
	 * @param string $var
	 * @param string $label
	 * @param string $type
	 */
	public static function createAttribute($var, $label, $type="text", $section="customers", $panel_id = null){

		// Check if the attribute exists
		$attr = self::getAttributeIdByVar($var, $section);
		if(!empty($attr)){
			return false;
		}
		
		$attribute = new CustomAttributes();
		$attribute['var']     = $var;
		$attribute['label']   = $label;
		$attribute['type']    = $type;
		$attribute['section'] = $section;
		$attribute['panel_id'] = $panel_id;
		return $attribute->trySave();
	}
	
	/**
	 * save all the custom customer fields 
	 */
	public static function saveElementsValues(array $params, $external_id, $section) {
		foreach ($params as $param){
			foreach ($param as $attr => $value){
				$attribute = self::getAttribute($external_id, $attr);

				if(!empty($attribute['value_id'])){
					$theAttribute = Doctrine::getTable ( 'CustomAttributesValues' )->find($attribute['value_id']);	
				}else{
					$theAttribute = new CustomAttributesValues();
				}
				
				$theAttribute['external_id']  = $external_id;
				$theAttribute['attribute_id'] = self::getAttributeIdByVar($attr, $section);
				$theAttribute['value']        = !empty($value) ? $value : null;
								
				$theAttribute->save();
			}
		}
	}
	
	/**
	 * clear all custom fields for an external id in a section
	 */
	public static function clearValues($external_id, $section) {
		return Doctrine_Query::create ()
			->from ( 'CustomAttributesValues cav' )
			->leftJoin ( 'cav.CustomAttributes ca' )
			->where ( "ca.section = ?", $section )
			->andWhere ( "cav.external_id = ?", $external_id )
			->execute ()
			->delete();
	}
	
	
	
	/**
	 * Get the attribute 
	 * @param $external_id
	 * @param $var
	 * @return ArrayObject
	 */
	public static function getAttribute($external_id, $var){
		$record = Doctrine_Query::create ()
			->from ( 'CustomAttributesValues cav' )
			->leftJoin ( 'cav.CustomAttributes ca' )
			->where ( "ca.var = ?", $var )
			->andWhere ( "cav.external_id = ?", $external_id )
			->execute ( array (), Doctrine_Core::HYDRATE_ARRAY );
			
		return !empty($record[0]) ? $record[0] : false; 
	}
	
	/**
	 * Get the external attribute id by the var name
	 * @param integer
	 */
	public static function getAttributeIdByVar($var, $section){
		if(!empty($var)){
			$record = Doctrine_Query::create ()
				->from ( 'CustomAttributes ca' )
				->where ( "ca.var = ?", $var )
				->andWhere ( "ca.section = ?", $section )
				->execute ( array (), Doctrine_Core::HYDRATE_ARRAY );
		}		
		return !empty($record[0]['attribute_id']) ? $record[0]['attribute_id'] : 0; 
	}
	
	/**
	 * get all the custom external fields values
	 */
	public static function getElementsValues($external_id, $section = null, $panel_id = null){
		$record = array();
				
		$fields = Doctrine_Query::create ()->select ( "ca.var, cav.value" )
											->from ( 'CustomAttributesValues cav' )
											->leftJoin ( 'cav.CustomAttributes ca' )
											->where ( "cav.external_id = ?", $external_id )
											->andWhere('ca.section = ?', $section)
											->andWhere('ca.panel_id = ? OR ca.panel_id IS ?', array(intval($panel_id), null))
											->execute ( array (), Doctrine_Core::HYDRATE_ARRAY );
																																
		foreach ($fields as $field) {
			$record[$field['CustomAttributes']['var']] = $field['value'];
		}
		
		return $record;
	}
	
	/**
	 * get all the custom external fields 
	 */
	public static function getElements(Zend_Form $form, $section="customers", $panel_id = null){
		$attributeForm = new Zend_Form_SubForm ();
		
		// Get the list field
		$fields = Doctrine_Query::create ()
				->from ( 'CustomAttributes ca' )
				->andWhere ( "ca.section = ?", $section )
				->andWhere('ca.panel_id = ? OR ca.panel_id IS ?', array(intval($panel_id), null))
				->execute ( array (), Doctrine_Core::HYDRATE_ARRAY );
				
		// Set the decorator
		$attributeForm->addElementPrefixPath('Shineisp_Decorator', 'Shineisp/Decorator/', 'decorator');
		
		foreach ($fields as $field) {
			
			// Create the custom field 
			$attributeForm->addElement($field['type'], $field['var'], array(
	            'filters'    => array('StringTrim'),
	            'label'      => $field['label'],
	            'decorators' => array('Composite'),
	            'class'      => 'text-input large-input'
	        ));
		}

		// Add the subform 
		$form->addSubForm ( $attributeForm, 'attributes' );
		
		return $form;
	}
}