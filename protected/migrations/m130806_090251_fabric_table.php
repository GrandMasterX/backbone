<?php

class m130806_090251_fabric_table extends CDbMigration
{
	public function up()
	{
        $this->getDbConnection()->createCommand(
            'CREATE TABLE IF NOT EXISTS `item_fabric` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `title` varchar(100) DEFAULT NULL,
              PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
        )->execute();

        $this->insert('item_fabric',array('title'=>'Костюмная'));
        $this->insert('item_fabric',array('title'=>'Трикотаж'));
        $this->insert('item_fabric',array('title'=>'Блузочная'));
        $this->insert('item_fabric',array('title'=>'Кобинированная'));
    }

	public function down()
	{
		echo "m130806_090251_fabric_table does not support migration down.\n";
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