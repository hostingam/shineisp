<?php

/**
 * ContactsTypes
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class ContactsTypes extends BaseContactsTypes {
	
	/**
	 * findAll
	 * Get all the records
	 * @return Doctrine Record
	 */
	public static function findAll() {
		return Doctrine::getTable ( 'ContactsTypes' )->findAll ();
	}
	
	/**
	 * findbyName
	 * Get a record by Name
	 * @param $name
	 * @return Doctrine Record
	 */
	public static function findbyName($name) {
		return Doctrine::getTable ( 'ContactsTypes' )->findOneBy ( 'name', $name, Doctrine_Core::HYDRATE_ARRAY );
	}
	
	/**
	 * Get a id type by Name
	 * @param $name
	 * @return integer
	 */
	public static function getIdbyName($name) {
		$result = Doctrine::getTable ( 'ContactsTypes' )->findOneBy ( 'name', $name, Doctrine_Core::HYDRATE_ARRAY );
		
		return !empty($result['type_id']) ? $result['type_id'] : 0;
	}
	
	/**
	 * getList
	 * Get the full list of items for the select objects
	 * @return Doctrine Record
	 */
	public static function getList() {
		$items = array ();
		$arrTypes = Doctrine::getTable ( 'ContactsTypes' )->findBy('enabled', 1);
		foreach ( $arrTypes->getData () as $c ) {
			$items [$c ['type_id']] = $c ['name'];
		}
		return $items;
	}
}