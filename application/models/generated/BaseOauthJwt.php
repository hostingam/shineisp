<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('OauthJwt', 'doctrine');

/**
 * BaseOauthJwt
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $client_id
 * @property integer $user_id
 * @property string $subject
 * @property string $public_key
 * @property Doctrine_Collection $AdminUser
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseOauthJwt extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('oauth_jwt');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('client_id', 'string', 250, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '250',
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('subject', 'string', 2048, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '2048',
             ));
        $this->hasColumn('public_key', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('AdminUser', array(
             'local' => 'user_id',
             'foreign' => 'user_id'));
    }
}