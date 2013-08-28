<?php

class m130503_082525_log_table extends CDbMigration
{
	public function up()
	{
        
         $this->getDbConnection()->createCommand(
            'CREATE TABLE IF NOT EXISTS `log` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `client_id` int(11) unsigned NOT NULL,
              `item_id` int(11) unsigned DEFAULT NULL,
              `action` varchar(255) NOT NULL,
              `create_time` datetime NOT NULL,   
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; '
        )->execute();         
        
	}

	public function down()
	{
		echo "m130503_082525_log_table does not support migration down.\n";
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