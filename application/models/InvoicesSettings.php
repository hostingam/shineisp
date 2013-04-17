<?php

/**
 * InvoicesSettings
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class InvoicesSettings extends BaseInvoicesSettings
{
    /**
     * Check everyday if the settings are correct
     * 
     * 
     * @return Boolean
     */
    public static function checkSettings() {
    	
    	$currentYear = date('Y');
    	if(date('m') == 1){
	        $record = Doctrine_Query::create ()
	                ->from ( 'InvoicesSettings is' )
	                ->where ( "is.year = ?", $currentYear )
	                ->limit ( 1 )
	                ->execute ( array (), Doctrine_Core::HYDRATE_ARRAY );
	        
	        if(empty($record)){
				$is = new InvoicesSettings();
				$is['year'] = $currentYear;
				$is['next_number'] = 1;
				$is->save();
	        }
        	return true;
    	}
    	return false;
    }
    
    /**
     * findByYear
     * Get the invoice settings by Year
     * @param $year
     * @return Doctrine Record
     */
    public static function findByYear($year, $fields = "*", $retarray = false) {
        $dq = Doctrine_Query::create ()
                ->select ( $fields )
                ->from ( 'InvoicesSettings is' )
                ->where ( "is.year = $year" )->limit ( 1 );
        
        $retarray = $retarray ? Doctrine_Core::HYDRATE_ARRAY : null;
        $record = $dq->execute ( array (), $retarray );
        return $record;
    }
    
    /**
     * getLastInvoice
     * Get the last invoice number
     * @param $year
     * @return Doctrine Record
     */
    public static function getLastInvoice() {
    	
    	// Check if a year is passed
    	self::checkSettings();
    	
        $dq = Doctrine_Query::create ()
                ->select ( 'next_number' )
                ->from ( 'InvoicesSettings is' )
                ->where('is.year = ?', date('Y'))
                ->limit ( 1 );
        
        $record = $dq->execute ( array (), Doctrine_Core::HYDRATE_ARRAY );
        if (count ( $record ) > 0) {
            return $record[0] ['next_number'];
        } else {
            return 1;
        }
    }   
    /**
     * setLastInvoice
     * Set the last invoice number
     * @param $current_invoice_number
     * @return Doctrine Record
     */
    public static function setLastInvoice($current_invoice_number) {
    	$q = Doctrine_Query::create()
				    ->update('InvoicesSettings')
				    ->set('next_number', $current_invoice_number + 1)
				    ->where('year = ' . date('Y'));

        return $q->execute();
    }   

    
}