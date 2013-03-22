<?php

/**
 * NewslettersHistory
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class NewslettersHistory extends BaseNewslettersHistory
{
	/**
	 * Add to the queue the subscriber selected
	 * @param integer $subscriber_id
	 */
	public static function add_to_queue($subscriber_id, $news_id){

		// Check if the subscriber is already in the current queue
		if(false == self::subscriber_exists_in_active_queue($subscriber_id, $news_id)){
			$queue = new NewslettersHistory();
			$queue['subscriber_id'] = $subscriber_id;
			$queue['news_id'] = $news_id;
			$queue['date_added'] = date('Y-m-d H:i:s');
			return $queue->trySave();
		}
	}
	
	/**
	 * Add all the subscribers to the queue
	 */
	public static function add_all_to_queue($news_id){
		$subscribers = NewslettersSubscribers::get_active_subscribers();
		
		foreach ($subscribers as $subscriber) {
			self::add_to_queue($subscriber['subscriber_id'], $news_id);	
		}
		return true;
	}
	
	/**
	 * Get the active queue ready to be sent
	 */
	public static function get_active_queue($test=false, $id=false, $limit=20){
		$dq =Doctrine_Query::create ()->from ( 'NewslettersHistory nh' )
								    	->leftJoin('nh.NewslettersSubscribers s')
								    	->leftJoin('nh.Newsletters n')
								    	->limit($limit);
		if(!$test){
			$dq->where ( "nh.sent IS NULL")
			   ->andWhere ( "n.sendat <= NOW()");
		}
		
		if(is_numeric($id)){
			$dq->andWhere ( "nh.news_id = ?", $id);
		}
								    						    	
		return $dq->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
	}
	
	/**
	 * Clear queue
	 */
	public static function clear_queue($newsletterID){
		return Doctrine_Query::create ()->delete('NewslettersHistory nh' )
								    	->where ( "nh.news_id = ?", $newsletterID)
								    	->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
	}
	
	/**
	 * Get the the queue by newsletter_id
	 */
	public static function get_queue_by_newsletter_id($news_id, $fields="*"){
		return Doctrine_Query::create ()->select($fields)->from ( 'NewslettersHistory nh' )
								    	->where ( "news_id = ?", $news_id)
								    	->leftJoin('nh.NewslettersSubscribers ns')
								    	->leftJoin('ns.Customers c')
								    	->leftJoin('nh.Newsletters n')
								    	->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
	}
	
	/**
	 * Set the status of the item in the queue 
	 * @param integer $subscriber_id
	 * @param integer $newsletter_id
	 * @param boolean $status
	 * @param string $log
	 */
	public static function set_status($subscriber_id, $newsletter_id, $status=1, $log=null){
		$dq = Doctrine_Query::create ()
								->update ( 'NewslettersHistory' )
								->set ( 'sent', '?', $status )
								->where ( "subscriber_id = ?", $subscriber_id )
								->andWhere( "newsletter_id = ?", $newsletter_id );
		if($status){
			$dq->set ( 'date_sent', '?', date('Y-m-d H:i:s') );
		}
		
		if(!empty($log)){
			$dq->set ( 'log', '?', $log );
		}
		
		return $dq->execute ();
	}
	
	/**
	 * Check if the subscriber is already in the active queue
	 */
	public static function subscriber_exists_in_active_queue($subscriber_id, $news_id){
		$result = Doctrine_Query::create ()->from ( 'NewslettersHistory' )
								    	->where ( "subscriber_id = ?", $subscriber_id )
								    	->andWhere ( "news_id = ?", $news_id )
								    	->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
								    	
		return !empty($result[0]) ? true : false;
	}
}