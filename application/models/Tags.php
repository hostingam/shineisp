<?php

/**
 * Tags
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Tags extends BaseTags
{
    /**
     * getList
     * Get a list ready for the html select object
     * @return array
     */
    public static function getList($customer_id, $empty = true) {
        $items = array ();
        
        $dq = Doctrine_Query::create ()
                                        ->from ( 'Tags t' )
                                        ->leftJoin('t.TagsConnections tc')
                                        ->where('tc.customer_id = ?', $customer_id)
                                        ->addWhere("tc.domain_id is not null");
                                      
        $records = $dq->execute ( array (), Doctrine_Core::HYDRATE_ARRAY );
        foreach ( $records as $record ) {
            $items [$record ['tag_id']] = $record ['tag'];
        }
        
        return $items;
    }
    
    /**
     * findConnectionbyDomainID
     * Get a record using the customerID
     * @return array
     */
    public static function findConnectionbyDomainID($domainid) {
        $items = array ();
        
        $dq = Doctrine_Query::create ()
                                       ->from ( 'Tags t' )
                                       ->leftJoin('t.TagsConnections tc')
                                       ->where('tc.domain_id = ?', $domainid);
                                       
        $records = $dq->execute ( array (), Doctrine_Core::HYDRATE_ARRAY );
        return $records;
    }    
    
    /**
     * findbyDomainID
     * Get a record using the customerID
     * @return array
     */
    public static function findbyDomainID($domainid) {
        $dq = Doctrine_Query::create ()->select('tc.tagconnection_id as idc, t.tag_id as id, t.tag as tag')
                                       ->from ( 'Tags t' )
                                       ->leftJoin('t.TagsConnections tc')
                                       ->where('tc.domain_id = ?', $domainid);
                                       
        return $dq->execute ( array (), Doctrine_Core::HYDRATE_ARRAY );
    }    
    

    public static function DeleteTagConnection($idconnection){
    	Doctrine::getTable ( 'TagsConnections' )->find ( $idconnection )->delete ();
    }
    
    /**
     * findbyCustomerID
     * Get a record using the customerID
     * @return array
     */
    public static function findbyCustomerID($customer_id) {
        $items = array ();
        
        $dq = Doctrine_Query::create ()->select ( 'tc.tagconnection_id as idt, t.tag_id as id, t.tag as tag' )
                                       ->from ( 'Tags t' )
                                       ->leftJoin('TagsConnections tc')
                                       ->where('tc.customer_id = ?', $customer_id);
                                        
        $records = $dq->execute ( array (), Doctrine_Core::HYDRATE_ARRAY );
        foreach ( $records as $record ) {
            $items [$record ['id']] = $record ['tag'];
        }
        
        return $items;
    }    
    
    /**
     * findbyTag
     * Get a record using the tag
     * @return array
     */
    public static function findbyTag($tag, $customer_id) {
        
        $dq = Doctrine_Query::create ()->select('tc.tagconnection_id as connection_id, t.tag_id as id, t.tag as tag')
                                    ->from ( 'TagsConnections tc' )
                                    ->leftJoin('Tags t')
                                    ->where('tc.customer_id = ?', $customer_id)
                                    ->addWhere("t.tag = ?", $tag);
                                    
        $records = $dq->execute ( array (), Doctrine_Core::HYDRATE_ARRAY );
        
        return $records;
    }
}