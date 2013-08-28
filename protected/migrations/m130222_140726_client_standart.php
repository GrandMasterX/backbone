<?php

class m130222_140726_client_standart extends CDbMigration
{
	public function up()
	{
         $this->getDbConnection()->createCommand(
            'CREATE TABLE IF NOT EXISTS `clientStandard` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT, 
              `index` int(10) default NULL COMMENT \'коэффициент\',
              PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
        )->execute();
        
        $this->getDbConnection()->createCommand(
            'CREATE TABLE `clientStandard_translation` (
              `id` int(10) unsigned NOT NULL,
              `language_id` char(10) NOT NULL,
              `title` varchar(100) NOT NULL,
              PRIMARY KEY (`id`,`language_id`),
              CONSTRAINT `clientStandard_translation_fk1` FOREIGN KEY (`id`) REFERENCES `clientStandard` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
        )->execute();                
	}

	public function down()
	{
		echo "m130222_140726_client_standart does not support migration down.\n";
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