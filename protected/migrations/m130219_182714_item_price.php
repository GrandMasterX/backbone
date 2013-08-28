<?php

class m130219_182714_item_price extends CDbMigration
{
	public function up()
	{
        $this->addColumn('item', 'price', 'int(10) unsigned NOT NULL DEFAULT "0"');
	}

	public function down()
	{
		echo "m130219_182714_item_price does not support migration down.\n";
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