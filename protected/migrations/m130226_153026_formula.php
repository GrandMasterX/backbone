<?php

class m130226_153026_formula extends CDbMigration
{
	public function up()
	{
         $this->getDbConnection()->createCommand(
            'CREATE TABLE IF NOT EXISTS `formula` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT, 
              `title` varchar(255) default NULL COMMENT \'Наименование формулы\',
              `value` text default NULL COMMENT \'Значение формулы\',
              `info` text default NULL COMMENT \'Описание формулы\',
              `weight` smallint(6) default NULL COMMENT \'порядок\',
              PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
        )->execute();        
	}

	public function down()
	{
		echo "m130226_153026_formula does not support migration down.\n";
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