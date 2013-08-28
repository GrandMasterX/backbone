<?php

class m130806_115030_chaschka_for_itemsize extends CDbMigration
{
	public function up()
	{
        $this->addColumn('itemsize','cup','varchar(5) DEFAULT 0 COMMENT \'Чашечка\'');
        $this->addColumn('itemsize','birka','varchar(20) DEFAULT 0 COMMENT \'Бирка в магазине\'');
	}

	public function down()
	{
		echo "m130806_115030_chaschka_for_itemsize does not support migration down.\n";
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