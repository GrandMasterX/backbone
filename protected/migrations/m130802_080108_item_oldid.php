<?php

class m130802_080108_item_oldid extends CDbMigration
{
	public function up()
	{
        $this->addColumn('item','old_id','int(12) unsigned DEFAULT NULL');
	}

	public function down()
	{
		echo "m130802_080108_item_oldid does not support migration down.\n";
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