<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('WhoisServers', 'doctrine');

/**
 * BaseWhoisServers
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $server_id
 * @property string $tld
 * @property string $server
 * @property string $response
 * @property Doctrine_Collection $DomainsTlds
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseWhoisServers extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('whois_servers');
        $this->hasColumn('server_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('tld', 'string', 10, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '10',
             ));
        $this->hasColumn('server', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '100',
             ));
        $this->hasColumn('response', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '100',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('DomainsTlds', array(
             'local' => 'server_id',
             'foreign' => 'server_id'));
    }
}