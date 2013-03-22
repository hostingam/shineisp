<?php

/**
 * Newsletters
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Newsletters extends BaseNewsletters
{

	/**
	 * grid
	 * create the configuration of the grid
	 */	
	public static function grid($rowNum = 10) {
		
		$translator = Zend_Registry::getInstance ()->Zend_Translate;
		
		$config ['datagrid'] ['columns'] [] = array ('label' => null, 'field' => 'n.news_id', 'alias' => 'news_id', 'type' => 'selectall' );
		$config ['datagrid'] ['columns'] [] = array ('label' => $translator->translate ( 'ID' ), 'field' => 'n.news_id', 'alias' => 'news_id', 'sortable' => true, 'searchable' => true, 'type' => 'string' );
		$config ['datagrid'] ['columns'] [] = array ('label' => $translator->translate ( 'Subject' ), 'field' => 'n.subject', 'alias' => 'subject', 'sortable' => true, 'searchable' => true, 'type' => 'string' );
		$config ['datagrid'] ['columns'] [] = array ('label' => $translator->translate ( 'Send at' ), 'field' => 'n.sendat', 'alias' => 'sendat', 'sortable' => true, 'searchable' => true, 'type' => 'date' );
		$config ['datagrid'] ['columns'] [] = array ('label' => $translator->translate ( 'Sent' ), 'field' => 'n.sent', 'alias' => 'sent', 'sortable' => true, 'searchable' => true, 'type' => 'date' );
		
		$config ['datagrid'] ['fields'] = "n.news_id, 
										   DATE_FORMAT(n.sendat, '%d/%m/%Y %H:%i:%s') as sendat, 
										   n.sent as sent,
										   n.subject as subject";
		
		$config ['datagrid'] ['dqrecordset'] = Doctrine_Query::create ()->select ( $config ['datagrid'] ['fields'] )->from ( 'Newsletters n' );
		
		$config ['datagrid'] ['rownum'] = $rowNum;
		
		$config ['datagrid'] ['basepath'] = "/admin/newsletter/";
		$config ['datagrid'] ['index'] = "news_id";
		$config ['datagrid'] ['rowlist'] = array ('10', '50', '100', '1000' );
		
		$config ['datagrid'] ['buttons'] ['edit'] ['label'] = $translator->translate ( 'Edit' );
		$config ['datagrid'] ['buttons'] ['edit'] ['cssicon'] = "edit";
		$config ['datagrid'] ['buttons'] ['edit'] ['action'] = "/admin/newsletter/edit/id/%d";
		
		$config ['datagrid'] ['buttons'] ['delete'] ['label'] = $translator->translate ( 'Delete' );
		$config ['datagrid'] ['buttons'] ['delete'] ['cssicon'] = "delete";
		$config ['datagrid'] ['buttons'] ['delete'] ['action'] = "/admin/newsletter/delete/id/%d";
		$config ['datagrid'] ['massactions']['common'] = array ('massdelete'=>'Mass Delete');
		return $config;
	}	
	
/**
     * find
     * Get a record by ID
     * @param $id
     * @return Doctrine Record
     */
    public static function find($id) {
        return Doctrine::getTable ( 'Newsletters' )->findOneBy ( 'news_id', $id );
    }
    
    /**
     * findbyvar
     * Get a record by ID
     * @param $var
     * @return Doctrine Record
     */
    public static function findbyvar($var) {
        return Doctrine::getTable ( 'Newsletters' )->findBy ( 'var', $var, Doctrine::HYDRATE_ARRAY);
    }
    
    /**
     * delete
     * Delete a record by ID
     * @param $id
     */
    public static function deleteItem($id) {
        Doctrine::getTable ( 'Newsletters' )->findOneBy ( 'news_id', $id )->delete();
    }
    
    /**
     * set_sending_date
     * Set sent date
     * @param $id
     */
    public static function set_sending_date($id) {
        try{
        	
        	$dq = Doctrine_Query::create ()->update ( 'Newsletters' )
									->set ( 'sent', "'" . date('Y-m-d H:i:s') . "'" )
									->where('news_id = ?', $id)
									->execute();
        }catch (Exception $e){
        	die($e->getMessage());
        }
    }
    
    /**
     * getbyId
     * Get a record by ID
     * @param $id
     */
    public static function getbyId($id) {
        return Doctrine::getTable ( 'Newsletters' )->find ( $id );
    }
    
    /**
     * get_active
     * Get all active newsletters 
     * @return Array
     */
    public static function get_active() {
        return Doctrine_Query::create ()->from ( 'Newsletters n' )
								        ->where ( "n.sendat = ?", null )
                                        ->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
    }
    
    /**
     * Save all the information about the newsletter
     * @param array $params
     */
    public static function save_data($params){
    	
		if (is_numeric ( $params['news_id'] )) {
			$newsletter = self::getbyId( $params['news_id'] );
		}else{
			$newsletter = new Newsletters();
		}
		
		$newsletter['subject'] = $params ['subject'];
		$newsletter['sendat'] = Shineisp_Commons_Utilities::formatDateIn($params ['sendat']);
		$newsletter['sent'] = Shineisp_Commons_Utilities::formatDateIn($params ['sent']);
		$newsletter['message'] = $params ['message'];
		$newsletter->save ();
		
		// If the newsletter has been already sent and you'd like to send it again, clear the history 
		if($params['sendagain']){
			NewslettersHistory::clear_queue($newsletter['news_id']);

			// Update the sent field value
			$newsletter['sent'] = null;
			$newsletter->save ();
		}
		
		// Create the queue
		NewslettersHistory::add_all_to_queue($newsletter['news_id']);
		
		return $newsletter['news_id'];
    }
    
    /**
     * getAllInfo
     * Get all data starting from the wikiID 
     * @param $id
     * @return Doctrine Record / Array
     */
    public static function getAllInfo($id, $fields = "*", $retarray = false) {
        $dq = Doctrine_Query::create ()->select ( $fields )->from ( 'Newsletters n' )
        								->leftJoin('n.NewslettersHistory nh') 
                                       ->where ( "n.news_id = $id" )
                                       ->limit ( 1 );
        
        $retarray = $retarray ? Doctrine_Core::HYDRATE_ARRAY : null;
        $items = $dq->execute ( array (), $retarray );
       
        return $items;
    }
    
	
	/**
	 * massdelete
	 * delete the newsletter selected 
	 * @param array
	 * @return Boolean
	 */
	public static function massdelete($items) {
		return Doctrine_Query::create ()->delete ()->from ( 'Newsletters n' )->whereIn ( 'n.news_id', $items )->execute ();
	}    
    
    /**
     * Prepare the newsletter content
     */
    private static function fill_content(){
    	$ns = new Zend_Session_Namespace ( 'Default' );
    	$contents = array();
    	
    	// Get all the products
		$contents['products'] = "<ul>";
		$records = Products::getAllHighlighted($ns->idlang);
		foreach ( $records as $record ) {
			$contents['products'] .= "<b><a href='http://" . $_SERVER ['HTTP_HOST'] . "/" . $record['uri'] . ".html'>" . $record['ProductsData'][0]['name'] . "</a></b><p>" . $record['ProductsData'][0]['shortdescription'] . "</p>";
		}
		$contents['products'] .= "</ul>";
		
		// Get all the cms pages
		$contents['pages'] = "";
		$records = CMSPages::getRssPages($ns->lang);
		foreach ( $records as $record ) {
			$link = 'http://' . $_SERVER ['HTTP_HOST'] . '/cms/' . $record ['var'] . '.html';
			$contents['pages'] .= "<p><b><a href='".$link."'>" . $record ['title'] . "</a></b></p>";
			$contents['pages'] .= Shineisp_Commons_Utilities::truncate($record ['body'], 200, "...", false, true);
		}
		$contents['pages'] = str_replace ( "src=\"/", "src=\"http://" . $_SERVER ['HTTP_HOST']."/", $contents['pages'] );

		return $contents;
    }
    
    /**
     * Get the list saved in the remote MailChimp service
     */
    public static function get_mailchimp_list(){
    	$errors = array();
    	
    	$key = Settings::findbyParam ( "MailChimp_key", "admin", Isp::getActiveISPID () );
    			
    	if(empty($key)){
    		echo('<div class="notification error">MailChimp Api Key has been not set yet. Subscribe a Mailchimp.com account and then go to Configuration > MailChimp to fill up the API key</div>');
    		return false;
    	}
    			
    	$api = new Shineisp_Api_Newsletters_Mailchimp_Main($key);
    	
    	$lists = $api->lists();
    	$data = array();
    	if(!empty($lists['data'])){
	    	foreach ($lists['data'] as $list){
	    		$data[$list['id']] = $list['name'] . " - (" . $list['stats']['member_count'] . " members)";
	    	}
    	}
    	return $data;
    }
    
    /**
     * Send the newsletter to the queue
     */
    public static function send_queue($test=FALSE, $id=NULL){
		$queue = NewslettersHistory::get_active_queue($test, $id);
		
		$isp = Isp::getActiveISP ();
		try{
			// Get the template from the main email template folder
			$retval = Shineisp_Commons_Utilities::getEmailTemplate ( 'newsletter' );
			
			if(!empty($retval) && !empty($queue)){
				
				$contents = self::fill_content();	
					
				$subject = $retval ['subject'];
				$template =  $retval ['template'] ;
				
				$subject = str_replace ( "[subject]", $queue[0] ['Newsletters']['subject'], $subject );
				$template = str_replace ( "[subject]", $queue[0] ['Newsletters']['subject'], $template );
				$template = str_replace ( "[body]", $queue[0] ['Newsletters']['message'], $template );
				
				foreach ($contents as $name=>$content) {
					$template = str_replace ( "[" . $name . "]", $content, $template );
				}
				
				foreach ($isp as $field=>$value) {
					$template = str_replace ( "[" . $field . "]", $value, $template );
				}
				
				$template = str_replace ( "[url]", "http://" . $_SERVER ['HTTP_HOST'] . "/media/newsletter/" , $template );
				
				foreach ($queue as $item) {
					
					// Send a test of the newsletter to the default isp email otherwise send an email to the queue
					if ($test){
						$body = str_replace ( "[optout]", "#", $template); 
						Shineisp_Commons_Utilities::SendEmail ( $isp ['email'], $isp ['email'], null, "<!--TEST --> " . $subject, $body, true);
						break;
					}else{
						
						// Create the optout link to be added in the email
						$body = str_replace ( "[optout]", '<a href="http://' . $_SERVER ['HTTP_HOST'] . "/newsletter/optout/id/" . MD5($item['NewslettersSubscribers'] ['email']) . '" >Unsubscribe</a>', $template );
						
						$result = Shineisp_Commons_Utilities::SendEmail ( $isp ['email'], $item['NewslettersSubscribers'] ['email'], null, $subject, $body, true);
						if($result === true){
							NewslettersHistory::set_status($item['subscriber_id'], $item['newsletter_id'], 1, "Mail Sent");	
						}else{
							NewslettersHistory::set_status($item['subscriber_id'], $item['newsletter_id'], 0, $result['message']);
						}
						self::set_sending_date($item['news_id']);
					}
				}
			}
		}catch (Exception $e){
			echo $e->getMessage();
			return false;
		}
		return true;
    }

	######################################### BULK ACTIONS ############################################
	
	
	/**
	 * massdelete
	 * delete the customer selected 
	 * @param array
	 * @return Boolean
	 */
	public static function bulk_delete($items) {
		if(!empty($items)){
			return self::massdelete($items);
		}
		return false;
	}    
	
}