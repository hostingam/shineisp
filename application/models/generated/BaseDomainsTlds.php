<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('DomainsTlds', 'doctrine');

/**
 * BaseDomainsTlds
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $tld_id
 * @property integer $server_id
 * @property boolean $ishighlighted
 * @property float $registration_price
 * @property float $transfer_price
 * @property float $renewal_price
 * @property float $registration_cost
 * @property float $transfer_cost
 * @property float $renewal_cost
 * @property integer $registrars_id
 * @property integer $tax_id
 * @property Registrars $Registrars
 * @property Taxes $Taxes
 * @property WhoisServers $WhoisServers
 * @property Doctrine_Collection $DomainsTldsData
 * @property Doctrine_Collection $DomainsBulk
 * @property Doctrine_Collection $Domains
 * @property Doctrine_Collection $OrdersItems
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseDomainsTlds extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('domains_tlds');
        $this->hasColumn('tld_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('server_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('ishighlighted', 'boolean', 25, array(
             'type' => 'boolean',
             'default' => 0,
             'length' => '25',
             ));
        $this->hasColumn('registration_price', 'float', 10, array(
             'type' => 'float',
             'default' => '0.00',
             'notnull' => true,
             'length' => '10',
             ));
        $this->hasColumn('transfer_price', 'float', 10, array(
             'type' => 'float',
             'default' => '0.00',
             'notnull' => true,
             'length' => '10',
             ));
        $this->hasColumn('renewal_price', 'float', 10, array(
             'type' => 'float',
             'default' => '0.00',
             'notnull' => true,
             'length' => '10',
             ));
        $this->hasColumn('registration_cost', 'float', 10, array(
             'type' => 'float',
             'default' => '0.00',
             'notnull' => true,
             'length' => '10',
             ));
        $this->hasColumn('transfer_cost', 'float', 10, array(
             'type' => 'float',
             'default' => '0.00',
             'notnull' => true,
             'length' => '10',
             ));
        $this->hasColumn('renewal_cost', 'float', 10, array(
             'type' => 'float',
             'default' => '0.00',
             'notnull' => true,
             'length' => '10',
             ));
        $this->hasColumn('registrars_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('tax_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Registrars', array(
             'local' => 'registrars_id',
             'foreign' => 'registrars_id'));

        $this->hasOne('Taxes', array(
             'local' => 'tax_id',
             'foreign' => 'tax_id'));

        $this->hasOne('WhoisServers', array(
             'local' => 'server_id',
             'foreign' => 'server_id'));

        $this->hasMany('DomainsTldsData', array(
             'local' => 'tld_id',
             'foreign' => 'tld_id'));

        $this->hasMany('DomainsBulk', array(
             'local' => 'tld_id',
             'foreign' => 'tld_id'));

        $this->hasMany('Domains', array(
             'local' => 'tld_id',
             'foreign' => 'tld_id'));

        $this->hasMany('OrdersItems', array(
             'local' => 'tld_id',
             'foreign' => 'tld_id'));
    }
}