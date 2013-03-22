<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('SettingsGroups', 'doctrine');

/**
 * BaseSettingsGroups
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $group_id
 * @property string $name
 * @property string $description
 * @property string $help
 * @property SettingsParameters $SettingsParameters
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSettingsGroups extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('settings_groups');
        $this->hasColumn('group_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('name', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
        $this->hasColumn('help', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('SettingsParameters', array(
             'local' => 'group_id',
             'foreign' => 'group_id',
             'onDelete' => 'CASCADE'));
    }
}