<?php

class m130822_075052_sync_status_for_item extends CDbMigration
{
	public function up()
	{
        $this->addColumn('item','sync_status','tinyint(1) DEFAULT NULL');
        $this->addColumn('item_source','sync_status','tinyint(1) DEFAULT NULL');
	}

	public function down()
	{
		echo "m130822_075052_sync_status_for_item does not support migration down.\n";
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