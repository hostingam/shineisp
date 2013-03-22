<?php

/**
 * CMSBlocksData
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class CMSBlocksData extends BaseCMSBlocksData
{
/**
     * Get a record by ID
     * 
     * @param $pageid
     * @param $locale
     * @return Doctrine Record
     */
    public static function findbyPageDatabyID($pageid, $locale = 1) {
        
    	
    	$record = Doctrine_Core::getTable('CMSBlocksData')
				    ->createQuery('u')
				    ->addWhere ( "block_id = ?", $pageid )
                    ->addWhere ( "language_id = ?", $locale )
				    ->fetchOne();
	
        return $record;
    }
    
	/**
	 * delete
	 * Delete a record by ID
	 * @param $id
	 */
	public static function deleteItems($id) {
		Doctrine::getTable ( 'CMSBlocksData' )->findBy ( 'block_id', $id )->delete ();
	}
	
	/**
	 * Get the list of the languages by $blockid
	 * 
	 *  
	 * @param integer $index
	 */
	public static function getTranslations($blockid){
		$items = array();
		$records = Doctrine_Query::create ()->from ( 'CMSBlocksData' )
										    ->where ( "block_id = ?", $blockid )
										    ->execute ( array (), Doctrine_Core::HYDRATE_ARRAY );
		foreach ($records as $record) {
				$items[] = Languages::getLanguageLabel($record['language_id']);
		}
		
		return implode(", ", $items);
	}
}