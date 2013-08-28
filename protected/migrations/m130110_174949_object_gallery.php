<?php

class m130110_174949_object_gallery extends CDbMigration
{
	public function up()
	{
        
         $this->getDbConnection()->createCommand(
            'CREATE TABLE IF NOT EXISTS `object_gallery` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `object_id` varchar(100) DEFAULT NULL COMMENT \'ID объекта\',
              `path` varchar(100) DEFAULT NULL,
              `name` varchar(100) NOT NULL COMMENT \'Файл\',
              `tag` varchar(100) DEFAULT NULL COMMENT \'Тег\',
              `title` text COMMENT \'Название\',
              `descr` text COMMENT \'Описание\',
              `order` int(11) unsigned NOT NULL COMMENT \'Порядок\',
              `users_id` int(11) unsigned NOT NULL,
              PRIMARY KEY (`id`),
              KEY `object_gallery_key` (`object_id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; '
        )->execute();        
        
	}

	public function down()
	{
		echo "m130110_174949_object_gallery does not support migration down.\n";
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