<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('DomainsTldsData', 'doctrine');

/**
 * BaseDomainsTldsData
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $data_id
 * @property integer $tld_id
 * @property integer $language_id
 * @property string $name
 * @property string $description
 * @property string $tags
 * @property DomainsTlds $DomainsTlds
 * @property Languages $Languages
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseDomainsTldsData extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('domains_tlds_data');
        $this->hasColumn('data_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('tld_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('language_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 1,
             'length' => '4',
             ));
        $this->hasColumn('name', 'string', 250, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '250',
             ));
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '',
             ));
        $this->hasColumn('tags', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('DomainsTlds', array(
             'local' => 'tld_id',
             'foreign' => 'tld_id'));

        $this->hasOne('Languages', array(
             'local' => 'language_id',
             'foreign' => 'language_id',
             'onDelete' => 'CASCADE'));
    }
}