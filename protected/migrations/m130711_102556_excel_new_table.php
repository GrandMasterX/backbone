<?php

class m130711_102556_excel_new_table extends CDbMigration
{
	public function up()
	{
            $this->getDbConnection()->createCommand(
            'CREATE TABLE IF NOT EXISTS `excel_table` (
              `id` int(11) NOT NULL auto_increment,
              `article` varchar(64) DEFAULT NULL,
              `K` varchar(64) DEFAULT NULL,
              `DI` varchar(64) DEFAULT NULL,
              `DBSH` varchar(64) DEFAULT NULL,
              `SHs` varchar(64) DEFAULT NULL,
              `SHUG` varchar(64) DEFAULT NULL,
              `SHUGr` varchar(64) DEFAULT NULL,
              `SHUT` varchar(64) DEFAULT NULL,
              `SHUTr` varchar(64) DEFAULT NULL,
              `SHUB` varchar(64) DEFAULT NULL,
              `SHR` varchar(64) DEFAULT NULL,
              `Dr` varchar(64) DEFAULT NULL,
              `VP` varchar(64) DEFAULT NULL,
              `SHUP` varchar(64) DEFAULT NULL,
              `notice` varchar(64) DEFAULT NULL,
              `razmer` varchar(64) DEFAULT NULL,
              `tkan` varchar(64) DEFAULT NULL,
              `Kpoyas` varchar(64) DEFAULT NULL,
              `bretels` varchar(64) DEFAULT NULL,
              `chashka` varchar(64) DEFAULT NULL,
              `KG` varchar(64) DEFAULT NULL,
              `KT` varchar(64) DEFAULT NULL,
              `KB` varchar(64) DEFAULT NULL,
              `SHg` varchar(64) DEFAULT NULL,
              `Shleif` varchar(64) DEFAULT NULL,
              `constr_notice` varchar(64) DEFAULT NULL,
              `create_time` datetime NOT NULL,
              `update_time` datetime DEFAULT NULL,
              PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;'
        )->execute();  
	}

	public function down()
	{
		echo "m130711_102556_excel_new_table does not support migration down.\n";
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