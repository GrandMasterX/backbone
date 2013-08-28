<?php

class m130325_120214_resFormula_titles extends CDbMigration
{
	public function up()
	{
        
        $this->getDbConnection()->createCommand(
            'CREATE TABLE `resFormulaTitle` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `is_locked` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
              `is_blocked` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
              `created_by_id` int(10) unsigned NOT NULL,
              `updated_by_id` int(10) unsigned DEFAULT NULL,
              `weight` smallint(6) DEFAULT \'0\',
              `create_time` datetime DEFAULT NULL,
              `update_time` datetime DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;'
        )->execute(); 
        
        $this->getDbConnection()->createCommand(
            'CREATE TABLE `resFormulaTitle_translation` (
              `id` int(10) unsigned NOT NULL,
              `language_id` char(10) NOT NULL,
              `title` varchar(255) NOT NULL,
              PRIMARY KEY (`id`,`language_id`),
              CONSTRAINT `resFormulaTitle_translation_fk1` FOREIGN KEY (`id`) REFERENCES `resFormulaTitle` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
        )->execute();                   
        
	}

	public function down()
	{
		echo "m130325_120214_resFormula_titles does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}