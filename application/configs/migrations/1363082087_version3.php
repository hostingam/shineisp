<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version3 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->dropForeignKey('settings', 'settings_isp_id_isp_isp_id');
        $this->dropForeignKey('settings', 'settings_parameter_id_settings_parameters_parameter_id');
        $this->createForeignKey('settings', 'settings_isp_id_isp_isp_id_1', array(
             'name' => 'settings_isp_id_isp_isp_id_1',
             'local' => 'isp_id',
             'foreign' => 'isp_id',
             'foreignTable' => 'isp',
             'onUpdate' => '',
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('settings', 'settings_parameter_id_settings_parameters_parameter_id_1', array(
             'name' => 'settings_parameter_id_settings_parameters_parameter_id_1',
             'local' => 'parameter_id',
             'foreign' => 'parameter_id',
             'foreignTable' => 'settings_parameters',
             'onUpdate' => '',
             'onDelete' => 'CASCADE',
             ));
        $this->addIndex('settings', 'settings_isp_id', array(
             'fields' => 
             array(
              0 => 'isp_id',
             ),
             ));
        $this->addIndex('settings', 'settings_parameter_id', array(
             'fields' => 
             array(
              0 => 'parameter_id',
             ),
             ));
    }

    public function down()
    {
        $this->createForeignKey('settings', 'settings_isp_id_isp_isp_id', array(
             'name' => 'settings_isp_id_isp_isp_id',
             'local' => 'isp_id',
             'foreign' => 'isp_id',
             'foreignTable' => 'isp',
             ));
        $this->createForeignKey('settings', 'settings_parameter_id_settings_parameters_parameter_id', array(
             'name' => 'settings_parameter_id_settings_parameters_parameter_id',
             'local' => 'parameter_id',
             'foreign' => 'parameter_id',
             'foreignTable' => 'settings_parameters',
             ));
        $this->dropForeignKey('settings', 'settings_isp_id_isp_isp_id_1');
        $this->dropForeignKey('settings', 'settings_parameter_id_settings_parameters_parameter_id_1');
        $this->removeIndex('settings', 'settings_isp_id', array(
             'fields' => 
             array(
              0 => 'isp_id',
             ),
             ));
        $this->removeIndex('settings', 'settings_parameter_id', array(
             'fields' => 
             array(
              0 => 'parameter_id',
             ),
             ));
    }
}