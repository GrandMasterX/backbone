<?php

class m130617_144253_item_unavailable extends CDbMigration
{
	public function up()
	{
        $this->addColumn('item', 'unavailable', 'tinyint(1) unsigned NOT NULL DEFAULT "0"');
	}

	public function down()
	{
		echo "m130617_144253_item_unavailable does not support migration down.\n";
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