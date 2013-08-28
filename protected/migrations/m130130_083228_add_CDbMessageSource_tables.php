<?php

class m130130_083228_add_CDbMessageSource_tables extends CDbMigration
{
    
    public function up()
	{
         $this->getDbConnection()->createCommand(
            'CREATE TABLE IF NOT EXISTS `SourceMessage` (
              `id` int(11) NOT NULL auto_increment,
              `category` varchar(32) default NULL,
              `message` text,
              PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;'
        )->execute();
        
         $this->getDbConnection()->createCommand(
            'CREATE TABLE IF NOT EXISTS `Message` (
              `id` int(11) NOT NULL,
              `language` varchar(16) NOT NULL default \'\',
              `translation` text,
              PRIMARY KEY  (`id`,`language`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
        )->execute();
        
         $this->getDbConnection()->createCommand(
            'ALTER TABLE `Message`
              ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id`) REFERENCES `SourceMessage` (`id`) ON DELETE CASCADE'
        )->execute();                  
        
    }

	public function down()
	{
		echo "m130130_083228_add_CDbMessageSource_tables does not support migration down.\n";
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