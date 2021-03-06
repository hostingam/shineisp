<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Navigation', 'doctrine');

/**
 * BaseNavigation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $label
 * @property string $description
 * @property string $uri
 * @property integer $parent_id
 * @property string $module
 * @property string $controller
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseNavigation extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('navigation');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('label', 'string', 200, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '200',
             ));
        $this->hasColumn('description', 'string', 200, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '200',
             ));
        $this->hasColumn('uri', 'string', 200, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '200',
             ));
        $this->hasColumn('parent_id', 'integer', 4, array(
             'type' => 'integer',
             'default' => '0',
             'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('module', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '20',
             ));
        $this->hasColumn('controller', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '20',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}