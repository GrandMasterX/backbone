<?php

class m130722_104608_mailing_list_stat extends CDbMigration
{
	public function up()
	{
        $this->getDbConnection()->createCommand(
            'CREATE TABLE IF NOT EXISTS `mailing_list_stat` (
              `id` int(11) unsigned NOT NULL auto_increment,
              `mailing_list_id` int(11) unsigned NOT NULL,
              `client_id` int(11) unsigned NOT NULL,
              `client_clicked` tinyint(1) unsigned DEFAULT NULL COMMENT \'Клиент перешел по самой важной ссылке\' ,
              `create_time` date NOT NULL COMMENT \'Дата отправки\',
              `status` tinyint(1) unsigned NOT NULL DEFAULT "0",
              `created_by_id` int(10) unsigned NOT NULL,
              PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;'
        )->execute();        
	}

	public function down()
	{
		echo "m130722_104608_mailing_list_stat does not support migration down.\n";
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