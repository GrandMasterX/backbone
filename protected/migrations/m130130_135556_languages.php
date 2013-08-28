<?php

class m130130_135556_languages extends CDbMigration
{
	public function up()
	{
         $this->getDbConnection()->createCommand(
            'CREATE TABLE IF NOT EXISTS `languages` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `title` varchar(100) DEFAULT NULL COMMENT \'Наименование языка\',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
        )->execute();         
	}

	public function down()
	{
		echo "m130130_135556_languages does not support migration down.\n";
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