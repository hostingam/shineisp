<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Servers', 'doctrine');

/**
 * BaseServers
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $server_id
 * @property string $name
 * @property string $ip
 * @property string $netmask
 * @property string $host
 * @property string $domain
 * @property string $description
 * @property integer $isp_id
 * @property integer $type_id
 * @property integer $status_id
 * @property Isp $Isp
 * @property Servers_Types $Servers_Types
 * @property Statuses $Statuses
 * @property CustomAttributesValues $CustomAttributesValues
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseServers extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('servers');
        $this->hasColumn('server_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('name', 'string', 200, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '200',
             ));
        $this->hasColumn('ip', 'string', 200, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '200',
             ));
        $this->hasColumn('netmask', 'string', 200, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '200',
             ));
        $this->hasColumn('host', 'string', 200, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '200',
             ));
        $this->hasColumn('domain', 'string', 200, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '200',
             ));
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             'notnull' => false,
             'length' => '',
             ));
        $this->hasColumn('isp_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('type_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('status_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Isp', array(
             'local' => 'isp_id',
             'foreign' => 'isp_id'));

        $this->hasOne('Servers_Types', array(
             'local' => 'type_id',
             'foreign' => 'type_id'));

        $this->hasOne('Statuses', array(
             'local' => 'status_id',
             'foreign' => 'status_id'));

        $this->hasOne('CustomAttributesValues', array(
             'local' => 'server_id',
             'foreign' => 'external_id'));
    }
}